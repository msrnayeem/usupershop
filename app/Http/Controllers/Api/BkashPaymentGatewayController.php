<?php

namespace App\Http\Controllers\Api;
use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderDetail;
use App\Models\SubscriptionFee;
use App\Traits\BkashPaymentTrait;
use App\Traits\SendSmsTrait;
use App\Traits\WhatsAppNotifyTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shipping;
use App\Traits\ReferCommissionTrait;
use App\utilities\Constant;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class BkashPaymentGatewayController extends Controller
{
    use BkashPaymentTrait, ReferCommissionTrait, SendSmsTrait;


    public function bkashcallback_new()
    {
        $status = request()->get('status');
        $paymentID = request()->get('paymentID');
        $paymentType = request()->get('payment_type');

        $returnData = ['payment_type' => $paymentType];

        if (!$status || !$paymentID || !$paymentType) {
            return view('frontend.failed', compact('returnData'));
        }

        $grant = $this->grantToken();
        if (!isset($grant['id_token'])) {
            return view('frontend.failed', compact('returnData'));
        }

        $token = $grant['id_token'];

        // SUCCESS
        if ($status === 'success') {

            $execute = $this->paymentExecute($paymentID, $token);

            if (
                !isset($execute['data']) ||
                $execute['data']['statusCode'] !== '0000' ||
                $execute['data']['transactionStatus'] !== 'Completed'
            ) {

                return view('frontend.failed', compact('returnData'));
            }

            $paymentData = [
                'trxID' => $execute['data']['trxID'],
                'merchantInvoiceNumber' => $execute['data']['merchantInvoiceNumber'],
                'amount' => $execute['data']['amount'] ?? 0,
            ];

            if ($paymentType === 'customer_order') {

                if ($this->customer_payment_confirmation('success', $paymentData)) {
                    // Get user for redirect
                    $order_id = explode('-', $paymentData['merchantInvoiceNumber'])[0];
                    $order = Order::find($order_id);
                    if ($order) {
                        try {
                            $smsResponse = $this->sendOrderConfirmedSms($order);
                            if (!isset($smsResponse['status']) || strtolower((string) $smsResponse['status']) !== 'success') {
                                \Illuminate\Support\Facades\Log::error('Customer order confirmation SMS not sent', [
                                    'order_id' => $order->id,
                                    'response' => $smsResponse,
                                ]);
                            }
                        } catch (\Throwable $e) {
                            \Illuminate\Support\Facades\Log::error('Customer order confirmation SMS failed', [
                                'order_id' => $order->id,
                                'error' => $e->getMessage(),
                            ]);
                        }

                        $returnData['user'] = User::find($order->user_id);
                        if (!$order->user_id) {
                            return redirect()->to(URL::temporarySignedRoute(
                                'guest.order.confirmation',
                                now()->addMinutes(60),
                                ['order' => $order->id]
                            ));
                        }
                    }
                    return view('frontend.sucess', compact('returnData'));
                }

                return view('frontend.failed', compact('returnData'));
            }

            if ($paymentType === 'user_subscription') {

                if ($this->user_subscription_payment_confirmation('success', $paymentData)) {
                    // Get user for redirect
                    $subscription_id = explode('-', $paymentData['merchantInvoiceNumber'])[0];
                    $subscription = SubscriptionFee::find($subscription_id);
                    if ($subscription) {
                        $returnData['user'] = User::find($subscription->seller_id);
                    }
                    return view('frontend.sucess', compact('returnData'));
                }

                return view('frontend.failed', compact('returnData'));
            }

            return view('frontend.failed', compact('returnData'));
        }


        // FAILURE OR CANCEL
        $check = $this->checkPayment($paymentID, $token);

        if (!isset($check['status']) || !$check['status']) {
            return view('frontend.failed', compact('returnData'));
        }

        $paymentData = [
            'trxID' => '',
            'merchantInvoiceNumber' => $check['data']['merchantInvoice'],
            'amount' => 0,
        ];

        // Get user information for redirect
        $user = null;
        if ($paymentType === 'customer_order') {
            $order_id = explode('-', $paymentData['merchantInvoiceNumber'])[0];
            $order = Order::find($order_id);
            if ($order) {
                $user = User::find($order->user_id);
                if (!empty($order->user_id)) {
                    auth()->loginUsingId($order->user_id);
                }
            }

            $this->customer_payment_confirmation(
                $status === 'failure' ? 'fail' : 'cancel',
                $paymentData
            );
        } elseif ($paymentType === 'user_subscription') {
            $subscription_id = explode('-', $paymentData['merchantInvoiceNumber'])[0];
            $subscription = SubscriptionFee::find($subscription_id);
            if ($subscription) {
                $user = User::find($subscription->seller_id);
                auth()->loginUsingId($subscription->seller_id);
            }
        }

        $returnData['user'] = $user;

        return $status === 'failure'
            ? view('frontend.failed', compact('returnData'))
            : view('frontend.cancel', compact('returnData'));
    }


    private function customer_payment_confirmation($payment_status, $data)
    {
        $order_id = explode('-', $data['merchantInvoiceNumber'])[0];
        $order = Order::find($order_id);

        if (!$order)
            return false;

        if (!empty($order->user_id)) {
            auth()->loginUsingId($order->user_id);
        }

        try {
            DB::beginTransaction();

            if ($payment_status === 'success') {

                DB::table('payments_transaction')->insert([
                    'client_id' => $order->user_id,
                    'order_id' => $order->id,
                    'transaction_type' => 'bkash_payment',
                    'trxID' => $data['trxID'],
                    'payment_method' => 'bkash',
                    'credit' => $data['amount'],
                    'debit' => 0,
                    'order_note' => 'order bkash payment',
                    'status' => 0
                ]);

                $order->update([
                    'status' => 'confirmed',
                    'order_payment' => 'Paid'
                ]);

                // WhatsApp notification to admin
                try {
                    $order->load(['shipping', 'users']);
                    $this->notifyAdminNewOrder($order);
                } catch (\Exception $e) {
                    \Log::warning('WhatsApp order notify failed: ' . $e->getMessage());
                }

                DB::commit();
                return true;
            }


            if ($payment_status === 'fail') {

                $items = OrderDetail::where('order_id', $order_id)->get();

                foreach ($items as $item) {
                    Product::where('id', $item->product_id)->increment('quantity', $item->quantity);
                }

                Shipping::destroy($order->shipping_id);
                Payment::destroy($order->payment_id);

                OrderDetail::where('order_id', $order_id)->delete();

                $order->delete();

                DB::commit();
                return true;
            }


            if ($payment_status === 'cancel') {

                OrderDetail::where('order_id', $order_id)->get()
                    ->each(
                        fn($item) =>
                        Product::where('id', $item->product_id)->increment('quantity', $item->quantity)
                    );

                $order->update([
                    'order_payment' => 'Unpaid',
                    'status' => 'canceled'
                ]);

                DB::commit();
                return true;
            }

            DB::rollBack();
            return false;

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    private function user_subscription_payment_confirmation($payment_status, $data)
    {
        $subscription_id = explode('-', $data['merchantInvoiceNumber'])[0];

        $subscription = SubscriptionFee::find($subscription_id);

        if (!$subscription)
            return false;

        auth()->loginUsingId($subscription->seller_id);

        try {

            DB::beginTransaction();

            if ($payment_status === 'success') {

                $user = User::find($subscription->seller_id);

                $user->payment_status = 1;
                $user->status = 1; // Reactivate if was suspended
                // Set subscription expiry to 1 year from now
                $user->subscription_plan = \Carbon\Carbon::now()->addYear()->timestamp;
                if ($user->usertype === 'seller') {
                    $user->commission = Constant::COMMISSION['seller_comission'];
                }
                $user->save();

                // Send appropriate SMS: welcome invoice for new accounts, renewal for existing
                $isFirstPayment = $subscription->status == 0 && 
                    \App\Models\SubscriptionFee::where('seller_id', $user->id)
                        ->where('status', 1)->count() === 0;

                $invoiceNo = 'USP-' . str_pad($subscription->id, 6, '0', STR_PAD_LEFT);
                $expireDate = \Carbon\Carbon::now()->addYear()->format('d M Y');

                if ($isFirstPayment) {
                    $this->sendWelcomeInvoiceSms($user, '••••••', $invoiceNo, '1 Year', $expireDate);
                } else {
                    $this->sendSubscriptionRenewedSms($user);
                }

                // WhatsApp notification to admin — new member payment
                try {
                    $this->notifyAdminNewMemberPayment($user, $invoiceNo, '1 Year');
                } catch (\Exception $e) {
                    \Log::warning('WhatsApp member notify failed: ' . $e->getMessage());
                }

                $subscription->update([
                    'date' => time(),
                    'status' => 1,
                ]);

                if ($user->reseller_id) {
                    $this->distribute_refer_commission($user, $data['amount']);
                }

                DB::commit();
                return true;
            }

            // fail OR cancel

            User::where('id', $subscription->seller_id)
                ->update(['payment_status' => 0]);

            $subscription->delete();

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

}
