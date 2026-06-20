<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Traits\OrderAmountDistributionTrait;
use App\Traits\ReferCommissionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TestController extends Controller
{
    use ReferCommissionTrait, OrderAmountDistributionTrait;
   public function index()
    {
        // $categories = Category::orderBy('id', 'ASC')->get();
        // $categoriesCount = Category::count();
        
        // $pairedCategories = $categories->values()->filter(function ($category, $index) {
        //     return $index % 2 == 0;
        // })->values();
        
        // $unpairedCategories = $categories->values()->filter(function ($category, $index) {
        //     return $index % 2 != 0;
        // })->values();
        

        // $resultdata = [];
        // for($i = 1; $i <= round(($categoriesCount / 2)); $i++){
        //     $resultdata[] = [
        //         'pair' => $pairedCategories[$i] ?? null,
        //         'unpair' => $unpairedCategories[$i] ?? null,
        //     ];
        // }             
        
        
        // return response()->json($categoriesCount);

    //    $users = User::get();

    //     foreach ($users as $value) {
    //         do {
    //             $refer_code = Str::upper(Str::random(8));
    //         } while (User::where('refer_code', $refer_code)->exists());

    //         $user = User::where('id', $value->id)->update(['refer_code' => $refer_code]);
    //     }

        // return route('success.page').'?payment_type='.request()->payment_type;

        // $order = Order::find(1);
        // return $this->order_amount_distribution($order);
    }



    private function grantToken(){
        // Prepare request data
        $request_data = [
            'app_key' => env('BKASH_API_KEY'),
            'app_secret' => env('BKASH_SECRET_KEY'),
        ];
        // Initialize cURL
        $url = curl_init(env('BKASH_BASE_URL') .'/tokenized/checkout/token/grant');
        $request_data_json = json_encode($request_data);
        // Set headers
        $header = ['Content-Type: application/json', 'username: ' . env('BKASH_USERNAME'), 'password: ' . env('BKASH_PASSWORD')];
        // Set cURL options
       
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        // Execute cURL request
        $response = curl_exec($url);
        $err = curl_error($url);
        $requestData = json_decode($response, true);
        curl_close($url);
        return $requestData;
    }

    private function refreshToken($refresh_token){
        // Prepare request data
        $request_data = [
            'app_key' => env('BKASH_API_KEY'),
            'app_secret' => env('BKASH_SECRET_KEY'),
            'refresh_token' => $refresh_token,
        ];
        // Initialize cURL
        $url = curl_init(env('BKASH_BASE_URL') . '/tokenized/checkout/token/refresh');
        $request_data_json = json_encode($request_data);
        // Set headers
        $header = ['Content-Type: application/json', 'username: ' . env('BKASH_USERNAME'), 'password: ' . env('BKASH_PASSWORD')];
        // Set cURL options
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        // Execute cURL request
        $response = curl_exec($url);
        $err = curl_error($url);
        $requestData = json_decode($response, true);
        if ($requestData['statusCode'] == '0000') {
            $output = [
                'success' => true,
                'message' => 'Successful',
                'data' => $requestData,
            ];
        } else {
            $output = [
                'success' => false,
                'message' => 'Unsuccessfull',
                'data' => $requestData,
            ];
        }
        curl_close($url);
        return $output;
    }

    public function paymentCreate($data){
        $requestbody = [
            'mode' => '0011',
            'amount' => $data['amount'],
            'currency' => 'BDT',
            'intent' => 'sale',
            'payerReference' => 'payer_reference',
            'merchantInvoiceNumber' => $data['merchantInvoiceNumber'],
            'callbackURL' => env('BKASH_CALLBACK_URL'),
        ];
        $url = curl_init(env('BKASH_BASE_URL') . '/tokenized/checkout/create');
        $requestbodyJson = json_encode($requestbody);
        $header = ['Content-Type:application/json', 'Authorization:' . $data['token_id'], 'X-APP-Key: ' . env('BKASH_API_KEY')];
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata, true);
    }
    public function checkPayment($paymentID, $session_token)
    {
        $requestbody = [
            'paymentID' => $paymentID,
        ];
        $requestbodyJson = json_encode($requestbody);
        $url = curl_init(env('BKASH_BASE_URL') . '/tokenized/checkout/payment/status');
        $header = ['Content-Type:application/json', 'authorization:' . $session_token, 'x-app-key: ' . env('BKASH_API_KEY')];
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $response = curl_exec($url);
        curl_close($url);
        return json_decode($response);
    }
    public function paymentExecute($paymentID, $session_token)
    {
        $requestBody = [
            'paymentID' => $paymentID,
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $session_token,
            'X-APP-Key' => env('BKASH_API_KEY'),
        ])->post(env('BKASH_BASE_URL') . '/tokenized/checkout/execute', $requestBody);
        if ($response->successful()) {
            return [
                'status' => true,
                'message' => 'Payment Executed Successfully',
                'data' => $response->json()
            ];
        }else{
            return [
                'status' => false,
                'message' => 'payment is not checked successfully',
                'data' => $response->json(),
            ];
        }
    }
        // Handle a request for payment
     
    
}