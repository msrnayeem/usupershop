<?php
namespace App\Traits;
use App\utilities\Constant;
use Illuminate\Support\Facades\Log;

trait EPSGatewayTrait {
    private function generateHash($data){
        return base64_encode(hash_hmac('sha512', $data, env('EPS_SECRET_KEY'), true));
    }

    private function getToken(){
        $api_username = env('EPS_USERNAME');
        $api_password = env('EPS_PASSWORD');
        $xHash = $this->generateHash($api_username);
        $data = [
            'userName' => $api_username,
            'password' => $api_password
        ];
    
        $url = env('EPS_API_URL').'/Auth/GetToken';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'x-hash: ' . $xHash,
            'Content-Type: application/json',
        ]);
    
        $response = curl_exec($ch);
    
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            Log::error('cURL error: ' . $error);
            // FIX: return array instead of JsonResponse
            return [
                'status' => false,
                'message' => 'An error occurred',
                'details' => $error,
            ];
        }
        curl_close($ch);
        $response_data = json_decode($response, true);
        if (isset($response_data['token'])) {
            return [
                'status' => true,
                'token' => $response_data['token'],
                'expireDate' => $response_data['expireDate']
            ];
        } else {
            Log::error('API Error: ' . json_encode($response_data));
            return [
                'status' => false,
                'message' => 'Failed to get token',
                'details' => $response_data ?? 'No error message received'
            ];
        }
    }
    
    private function makePayment($authorizationToken, $data){
        // Generate the hash for the x-hash header
        $xHash = $this->generateHash($data['merchantTransactionId']);

        // Prepare the POST data
        $requestData = [
            'merchantId' => env('EPS_MERCHANT_ID'),
            'storeId' => env('EPS_STORE_ID'),
            'CustomerOrderId' => $data['CustomerOrderId'],
            'merchantTransactionId' => $data['merchantTransactionId'],
            'transactionTypeId' => $data['platform'],
            'totalAmount' => number_format($data['amount'], 2, '.', ''),
            'successUrl' => config('app.url') . Constant::EPS_INFO['successUrl'],
            'failUrl' => config('app.url') . Constant::EPS_INFO['failUrl'],
            'cancelUrl' => config('app.url') . Constant::EPS_INFO['cancelUrl'],
            'customerName' => (string) $data['customerName'],
            'customerEmail' => (string) $data['customerEmail'],
            'customerAddress' => (string) $data['customerAddress'],
            'customerCity' => (string) $data['customerCity'],
            'customerState' => (string) $data['customerState'],
            'customerPostcode' => (string) $data['customerPostcode'],
            'customerCountry' => (string) $data['customerCountry'],
            'customerPhone' => (string) $data['customerPhone'],
            'productName' => (string) $data['productName'],
            'paymentReferance' => (string) $data['paymentReferance'],
        ];


        // cURL initialization
        $url = env('EPS_API_URL') . '/EPSEngine/InitializeEPS';
        // Initialize curl
        $ch = curl_init();

        // Set curl options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $authorizationToken,
            'x-hash: ' . $xHash,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));

        // Execute request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }

        // Close curl
        curl_close($ch);

        // Decode and return the response
        $responseData = json_decode($response, true);

        // Check if the response contains a token
        if (isset($responseData['RedirectURL'])) {
            // Return the token and expiration date
            return [
                'status' => true,
                'message' => 'Payment initialized successfully',
                'data' => $responseData,
            ];
        } else {
            Log::error('API Error: ' . json_encode($responseData));
            return [
                'status' => false,
                'message' => $responseData['errorMessage'] ?? 'Payment initialized unsuccessfully'
            ];
        }

    }

    private function verifyPayment($authorizationToken, $merchantTransactionId){
        $xHash = $this->generateHash($merchantTransactionId);
        $url = env('EPS_API_URL').'/EPSEngine/CheckMerchantTransactionStatus?merchantTransactionId='.$merchantTransactionId;
        // Initialize curl
        $ch = curl_init();
        // Set curl options
        curl_setopt($ch, CURLOPT_URL, $url);  // The URL to send the GET request to
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $authorizationToken,  // Authorization header
            'x-hash: ' . $xHash,  // Hash header
            'Content-Type: application/json',  // Content-Type header
        ]);
        curl_setopt($ch, CURLOPT_HTTPGET, true);  // Make a GET request instead of POST

        // Execute the GET request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }

        // Close curl
        curl_close($ch);

        // Decode and return the response
        $responseData = json_decode($response, true);
        // Check if the response contains a token
        if (isset($responseData['MerchantTransactionId'])) {
            // Return the token and expiration date
            return [
                'status' => true,
                'message' => 'Payment verification successful',
                'data' => $responseData,
            ];
        } else {
            // Handle any errors in the response
            Log::error('API Error: ' . json_encode($responseData));
            return [
                'status' => false,
                'message' => $responseData['errorMessage'] ?? 'Payment verification unsuccessfully'
            ];
        }

    }
}