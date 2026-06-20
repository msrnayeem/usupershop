<?php

namespace App\Http\Controllers\Api;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\EPSGatewayTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Traits\SendSmsTrait;
use Illuminate\Support\Facades\URL;

class EPSpaymentGatewayController extends Controller
{
    use EPSGatewayTrait, SendSmsTrait;
    public function EPSsuccess_callback()
    {
        if (request()->has('Status') && request()->has('MerchantTransactionId')) {
            $marchentID = request()->MerchantTransactionId;
            $status = request()->Status;
            if ($status === 'Success') {
                $tokenData = $this->getToken();
                if (isset($tokenData['token'])) {
                    $executePayment = $this->verifyPayment($tokenData['token'], $marchentID);
                    if ($executePayment['status'] === true && $executePayment['data']['MerchantTransactionId']) {
                        $executemarchentID = $executePayment['data']['MerchantTransactionId'];
                        $executeTransactionID = $executePayment['data']['EPSTransactionId'];
                        $amount = $executePayment['data']['TotalAmount'];
                        $orderId = $executePayment['data']['ProductName'];
                        if ($orderId) {
                            $orderData = Order::where('id', $executePayment['data']['ProductName'])->first();
                        } else {
                            return redirect()->route('success.page');
                        }
                        try {
                            DB::beginTransaction();
                            /* Create New User */
                            // below code not needed if it is create in payment method
                            if ($orderData) {
                                DB::table('payments_transaction')->insert([
                                    'client_id' => $orderData->user_id,
                                    'order_id' => $orderData->id,
                                    'transaction_type' => 'eps payment',
                                    'trxID' => $executeTransactionID,
                                    'payment_method' => 'eps',
                                    'credit' => $amount,
                                    'debit' => 0,
                                    'order_note' => 'order eps payment',
                                    'status' => 0,
                                ]);
                                $orderData->invoice_no = $executemarchentID;
                                $orderData->order_payment = 'Paid';
                                $orderData->status = 'pending';
                                $orderData->save();
                                
                                try {
                                    $this->sendOrderConfirmedSms($orderData);
                                } catch (\Exception $e) {
                                    Log::error('EPS payment SMS failed', ['error' => $e->getMessage()]);
                                }

                                if (!$orderData->user_id) {
                                    DB::commit();
                                    return redirect()->to(URL::temporarySignedRoute(
                                        'guest.order.confirmation',
                                        now()->addMinutes(60),
                                        ['order' => $orderData->id]
                                    ));
                                }
                            }
                            DB::commit();
                            return redirect()->route('success.page');
                        } catch (\Exception $e) {
                            DB::rollback();
                            throw $e;
                        }
                    } else {
                        return redirect('/api/callback/eps/fail');
                    }
                } else {
                    return redirect('/api/callback/eps/fail');
                }
            }
        } else {
            return redirect('/api/callback/eps/fail');
        }
    }
    public function EPSfailed_callback()
    {
        $status = request()->Status;
        $marchentID = request()->MerchantTransactionId;
        if ($status === 'Failed') {
            $tokenData = $this->getToken();
            if (isset($tokenData['token'])) {
                $this->verifyPayment($tokenData['token'], $marchentID);
                    $orderData = Order::latest('id')->first();
                    try {
                        DB::beginTransaction();
                        /* Create New User */
                        // below code not needed if it is create in payment method
                        if ($orderData) {
                            DB::table('payments_transaction')->insert([
                                'client_id' => $orderData->user_id,
                                'order_id' => $orderData->id,
                                'transaction_type' => 'eps payment',
                                'trxID' => $marchentID,
                                'payment_method' => 'eps',
                                'credit' => 0000,
                                'debit' => 0,
                                'order_note' => 'order eps payment failed',
                                'status' => 0,
                            ]);
                            $orderData->invoice_no = $marchentID;
                            $orderData->order_payment = 'Unpaid';
                            $orderData->status = 'canceled';
                            $orderData->save();
                        }
                        DB::commit();
                        return redirect()->route('failed.page');
                    } catch (\Exception $e) {
                        DB::rollback();
                        throw $e;
                    }
               
            } else {
                return redirect()->route('failed.page');
            }
        }
    }
    public function EPScanceled_callback()
    {
        $status = request()->Status;
        $marchentID = request()->MerchantTransactionId;
        if ($status === 'Cancel') {
            $tokenData = $this->getToken();
            if (isset($tokenData['token'])) {
                $this->verifyPayment($tokenData['token'], $marchentID);
                $orderData = Order::latest('id')->first();
                try {
                    DB::beginTransaction();
                    if ($orderData) {
                        // Insert payment transaction record
                        DB::table('payments_transaction')->insert([
                            'client_id' => $orderData->user_id,
                            'order_id' => $orderData->id,
                            'transaction_type' => 'eps payment',
                            'trxID' => $marchentID,
                            'payment_method' => 'eps',
                            'credit' => 0,  // Changed from 0000 to 0
                            'debit' => 0,
                            'order_note' => 'EPS payment cancelled',
                            'status' => 0,
                        ]);
                        
                        // Update order status
                        $orderData->invoice_no = $marchentID;
                        $orderData->order_payment = 'Unpaid'; 
                        $orderData->status = 'canceled';
                        $orderData->save();
                    }
                    DB::commit();
                    return redirect()->route('cancel.page');
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error('EPS Cancellation Error: ' . $e->getMessage());
                    return redirect()->route('cancel.page')->with('error', 'Payment cancellation failed');
                }
            } else {
                return redirect()->route('cancel.page');
            }
        }
    }
}
