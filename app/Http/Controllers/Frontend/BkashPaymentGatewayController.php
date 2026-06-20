<?php

namespace App\Http\Controllers\Frontend;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Traits\BkashPaymentTrait;
use App\Traits\SendSmsTrait;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class BkashPaymentGatewayController extends Controller
{
    use BkashPaymentTrait, SendSmsTrait;

    public function BkashPaymentCreate(Request $request)
    {
        // Placeholder or legacy method
        return response()->json(['success' => true, 'message' => 'Order processed successfully!']);
    }

    public function callback(Request $request)
    {
        $status = $request->input('status');
        $paymentID = $request->input('paymentID');

        // Grant token is needed for almost everything
        $grantToken = $this->grantToken();
        if (!isset($grantToken['id_token'])) {
            return redirect()->route('frontend.home')->with('error', 'Token Generation Failed');
        }

        if ($status == 'cancel' || $status == 'failure') {
            // Try to find the order to log the user back in (session loss fix)
            $check = $this->checkPayment($paymentID, $grantToken['id_token']);
            $merchantInvoiceNumber = $check['data']['merchantInvoiceNumber'] ?? ($check['data']['merchantInvoice'] ?? null);
            
            if ($merchantInvoiceNumber) {
                $order_id = explode('-', $merchantInvoiceNumber)[0];
                $order = Order::find($order_id);
                if ($order && $order->user_id && !auth()->check()) {
                    auth()->loginUsingId($order->user_id);
                    Session::regenerate();
                }
            }

            // After re-login (or if session was alive), redirect to their appropriate home page
            if (auth()->check()) {
                $user = auth()->user();
                if ($user->usertype === 'customer') {
                    return redirect()->route('dashboard')->with('error', 'Payment Cancelled or Failed');
                } elseif ($user->usertype === 'seller' || $user->usertype === 'vendor') {
                    return redirect()->route('seller.dashboard')->with('error', 'Payment Cancelled or Failed');
                } elseif ($user->usertype === 'dropshipper') {
                    return redirect()->route('dropshipper.dashboard')->with('error', 'Payment Cancelled or Failed');
                }
            }

            // If not authenticated, redirect to home page instead of dashboard
            return redirect()->route('frontend.home')->with('error', 'Payment Cancelled or Failed');
        }

        if ($status == 'success') {
            $execution = $this->paymentExecute($paymentID, $grantToken['id_token']);

            if ($execution['status']) {
                $merchantInvoiceNumber = $execution['data']['merchantInvoiceNumber'];
                $order_id = explode('-', $merchantInvoiceNumber)[0];

                $order = Order::find($order_id);
                if ($order) {
                    // Log user back in if lost
                    if (!auth()->check() && $order->user_id) {
                        auth()->loginUsingId($order->user_id);
                        Session::regenerate();
                    }

                    $order->status = 'pending'; 
                    $order->save();

                    if ($order->payment_id) {
                         $payment = Payment::find($order->payment_id);
                         if ($payment) {
                             $payment->transaction_no = $execution['data']['trxID'];
                             $payment->save();
                         }
                    }
                    
                    try {
                        $smsResponse = $this->sendOrderConfirmedSms($order);
                        if (!isset($smsResponse['status']) || strtolower((string) $smsResponse['status']) !== 'success') {
                            \Illuminate\Support\Facades\Log::error('Order confirmation SMS not sent', [
                                'order_id' => $order->id,
                                'response' => $smsResponse,
                            ]);
                        }
                    } catch (\Throwable $e) {
                        \Illuminate\Support\Facades\Log::error('SMS sending failed on bkash payment', ['error' => $e->getMessage()]);
                    }
                   
                    Cart::destroy();
                    Session::forget(['coupon_discount', 'shipping_id', 'delivery_charge', 'areaID']);

                    if (!$order->user_id) {
                        return redirect()->to(URL::temporarySignedRoute(
                            'guest.order.confirmation',
                            now()->addMinutes(60),
                            ['order' => $order->id]
                        ));
                    }

                    if (auth()->user() && (auth()->user()->usertype == 'seller' || auth()->user()->usertype == 'vendor' || auth()->user()->usertype == 'dropshipper')) {
                        return redirect()->route('seller.customer.order.list')->with('success', 'Payment Successful! Transaction ID: ' . $execution['data']['trxID']);
                    }

                    return redirect()->route('customer.order.list')->with('success', 'Payment Successful! Transaction ID: ' . $execution['data']['trxID']);
                } else {
                     return redirect('/')->with('error', 'Order not found after payment!');
                }
            } else {
                 return redirect('/')->with('error', $execution['message']);
            }
        }
        
        return redirect('/')->with('error', 'Unknown Payment Status');
    }

    public function processPayment()
    {
        return response()->json(['error' => 'Use DashboardController flow'], 500);
    }
}
