<?php
namespace App\Traits;
use App\Models\PaymentGateway;
use App\Models\Sms;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

trait BkashPaymentTrait
{
    public function grantToken()
    {
        $payment = PaymentGateway::where('active_status', 1)->first();
        if (!$payment || !$payment->BKASH_API_KEY || !$payment->BKASH_SECRET_KEY) {
            return [
                'status' => false,
                'message' => 'bKash credentials missing in payment_gateways table',
            ];
        }
        $request_data = [
            'app_key' => $payment->BKASH_API_KEY,
            'app_secret' => $payment->BKASH_SECRET_KEY,
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'username' => $payment->BKASH_USERNAME,
            'password' => $payment->BKASH_PASSWORD,
        ])->post(env('BKASH_BASE_URL') . '/tokenized/checkout/token/grant', $request_data);

        $result = $response->json();
        if (!isset($result['id_token'])) {
            return [
                'status' => false,
                'message' => 'Failed to retrieve bKash token',
                'data' => $result,
            ];
        }
        return $result;
    }

    public function paymentCreate($data)
    {
        $payment = PaymentGateway::where('active_status', 1)->first();
        if (!$payment || !$data['token_id']) {
            return [
                'status' => false,
                'message' => 'Payment gateway credentials or token missing',
            ];
        }

        if (isset($data['callback_url'])) {
            $callback_url = $data['callback_url'];
        } else {
            $callback_url = env('BKASH_CALLBACK_URL');
            if(isset($data['success_url'])){
                $callback_url = env('BKASH_CALLBACK_URL') . $data['success_url'];
            }
        }
        $requestBody = [
            'mode' => '0011',
            'amount' => $data['amount'],
            'currency' => 'BDT',
            'intent' => 'sale',
            'payerReference' => 'payer_reference',
            'merchantInvoiceNumber' => $data['merchantInvoiceNumber'],
            'callbackURL' => $callback_url,
        ];
    
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $data['token_id'],
            'X-APP-Key' => $payment->BKASH_API_KEY,
        ])->post(env('BKASH_BASE_URL') . '/tokenized/checkout/create', $requestBody);
    
        if ($response->successful()) {
            return [
                'status' => true,
                'message' => 'Payment created successfully',
                'data' => $response->json(),
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Payment creation failed',
                'data' => $response->json(),
            ];
        }
    }
    
    public function paymentExecute($paymentID, $session_token)
    {
        $requestBody = [
            'paymentID' => $paymentID,
        ];
        $payment = PaymentGateway::where('active_status', 1)->first();
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $session_token,
            'X-APP-Key' => $payment->BKASH_API_KEY,
        ])->post(env('BKASH_BASE_URL') . '/tokenized/checkout/execute', $requestBody);
        if ($response->successful()) {
            return [
                'status' => true,
                'message' => 'Payment Executed Successfully',
                'data' => $response->json(),
            ];
        } else {
            return [
                'status' => false,
                'message' => 'payment is not checked successfully',
                'data' => $response->json(),
            ];
        }
    }
    public function checkPayment($paymentID,$session_token)
    {
        $requestBody = [
            'paymentID' => $paymentID,
        ];
        $payment = PaymentGateway::where('active_status', 1)->first();
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $session_token,
            'X-APP-Key' => $payment->BKASH_API_KEY,
        ])->post(env('BKASH_BASE_URL') . '/tokenized/checkout/payment/status', $requestBody);
        if ($response->successful()) {
            return [
                'status' => true,
                'message' => 'payment is checked successfully',
                'data' => $response->json(),
            ];
        } else {
            return [
                'status' => false,
                'message' => 'payment is checked successfully',
                'data' => $response->json(),
            ];
        }
    } 
}
