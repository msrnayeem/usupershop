<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CourierService
{
    protected $steadfastConfig;
    protected $pathaoConfig;

    public function __construct()
    {
        $this->steadfastConfig = [
            'base_url' => 'https://portal.packzy.com/api/v1',
            'api_key' => '8tglqf4sskogfpaqw236zymkvcjhomli',
            'secret_key' => '2iiqxtgqnztsc9u9esshh2xf'
        ];

        $this->pathaoConfig = [
            'base_url' => 'https://courier-api-sandbox.pathao.com',
            'client_id' => '7N1aMJQbWm',
            'client_secret' => 'wRcaibZkUdSNz2EI9ZyuXLlNrnAv0TdPUPXMnD39',
            'username' => 'test@pathao.com',
            'password' => 'lovePathao',
            'grant_type' => 'password'
        ];
    }

    /**
     * Get valid Pathao store ID
     */
    protected function getValidPathaoStoreId()
    {
        $cacheKey = 'pathao_store_id';
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $token = $this->getPathaoToken();
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json'
                ])
                ->get($this->pathaoConfig['base_url'] . '/aladdin/api/v1/stores');

            if ($response->successful()) {
                $result = $response->json();
                
                // Handle different response structures
                $stores = [];
                if (isset($result['data']['data'])) {
                    $stores = $result['data']['data'];
                } elseif (isset($result['data']) && is_array($result['data'])) {
                    $stores = $result['data'];
                } elseif (is_array($result)) {
                    $stores = $result;
                }
                
                if (!empty($stores) && isset($stores[0]['store_id'])) {
                    $storeId = $stores[0]['store_id'];
                    Cache::put($cacheKey, $storeId, 24 * 60 * 60); // Cache for 24 hours
                    return $storeId;
                }
            }

            Log::warning('Failed to get valid Pathao store ID, using default', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get Pathao store ID', ['error' => $e->getMessage()]);
        }

        return 1; // Default fallback
    }

    /**
     * Send order to selected courier
     */
    public function sendToCourier($order, $courierId, $priority = 'normal', $notes = null)
    {
        try {
            switch ($courierId) {
                case 'steadfast':
                    return $this->sendToSteadfast($order, $priority, $notes);
                case 'pathao':
                    return $this->sendToPathao($order, $priority, $notes);
                case 'redx':
                case 'sa_paribahan':
                case 'sundarban':
                case 'karatoa':
                    // Mock response for unsupported couriers
                    return [
                        'success' => true,
                        'tracking_id' => 'MOCK_' . strtoupper($courierId) . '_' . time(),
                        'message' => "Order successfully assigned to " . ucfirst($courierId) . " (Demo Mode)",
                        'response' => ['mock' => true, 'courier' => $courierId]
                    ];
                default:
                    return ['success' => false, 'message' => 'Unsupported courier service: ' . $courierId];
            }
        } catch (\Exception $e) {
            Log::error('Courier API Error', [
                'courier' => $courierId,
                'order' => $order->order_no ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return ['success' => false, 'message' => 'Courier API connection failed: ' . $e->getMessage()];
        }
    }

    /**
     * Send order to Steadfast
     */
    protected function sendToSteadfast($order, $priority, $notes)
    {
        $endpoint = $this->steadfastConfig['base_url'] . '/create_order';
        
        // Debug: Log order data to see what fields are available
        Log::info('Order Data for Steadfast', [
            'order_no' => $order->order_no,
            'billing_name' => $order->billing_name ?? 'NULL',
            'billing_mobile' => $order->billing_mobile ?? 'NULL',
            'billing_phone' => $order->billing_phone ?? 'NULL',
            'customer_name' => $order->customer_name ?? 'NULL',
            'customer_phone' => $order->customer_phone ?? 'NULL',
            'phone' => $order->phone ?? 'NULL',
            'mobile' => $order->mobile ?? 'NULL'
        ]);
        
        // Try different field combinations that might exist in your Order model
        $recipientName = $order->billing_name 
            ?? $order->customer_name 
            ?? $order->name 
            ?? $order->recipient_name 
            ?? 'Customer';
            
        $recipientPhone = $order->billing_mobile 
            ?? $order->billing_phone 
            ?? $order->customer_phone 
            ?? $order->phone 
            ?? $order->mobile 
            ?? $order->customer_mobile 
            ?? '01700000000'; // Default phone number
            
        $recipientAddress = $order->billing_address 
            ?? $order->customer_address 
            ?? $order->address 
            ?? $order->shipping_address 
            ?? 'Dhaka, Bangladesh';
        
        $orderData = [
            'invoice' => $order->order_no,
            'recipient_name' => trim($recipientName),
            'recipient_phone' => trim($recipientPhone),
            'recipient_address' => trim($recipientAddress),
            'recipient_city' => $order->billing_district ?? $order->district ?? 'Dhaka',
            'recipient_zone' => $order->billing_upazila ?? $order->upazila ?? 'Dhaka',
            'cod_amount' => $order->payment_id === 'cash_on_delivery' || $order->payment_method === 'cash_on_delivery' ? (float)$order->order_total : 0,
            'note' => $notes ?? ('Order from ' . config('app.name', 'E-commerce')),
        ];

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Api-Key' => $this->steadfastConfig['api_key'],
                    'Secret-Key' => $this->steadfastConfig['secret_key'],
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])
                ->post($endpoint, $orderData);

            Log::info('Steadfast API Response', [
                'order_no' => $order->order_no,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            if ($response->successful()) {
                $result = $response->json();
                
                // Handle different Steadfast response formats
                if (isset($result['status']) && $result['status'] == 200) {
                    return [
                        'success' => true,
                        'tracking_id' => $result['consignment']['tracking_code'] ?? null,
                        'message' => 'Order successfully sent to Steadfast',
                        'response' => $result
                    ];
                } elseif (isset($result['success']) && $result['success'] === true) {
                    return [
                        'success' => true,
                        'tracking_id' => $result['data']['tracking_code'] ?? $result['tracking_code'] ?? null,
                        'message' => 'Order successfully sent to Steadfast',
                        'response' => $result
                    ];
                }
            }

            $errorMessage = 'Unknown error';
            if ($response->json()) {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? $errorData['error'] ?? 'API request failed';
            }

            return [
                'success' => false,
                'message' => 'Failed to send order to Steadfast: ' . $errorMessage
            ];

        } catch (\Exception $e) {
            Log::error('Steadfast API Exception', [
                'order_no' => $order->order_no,
                'error' => $e->getMessage()
            ]);
            
            throw new \Exception('Steadfast API Error: ' . $e->getMessage());
        }
    }

    /**
     * Get Pathao access token
     */
    protected function getPathaoToken()
    {
        $cacheKey = 'pathao_access_token';
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = Http::timeout(30)
                ->asForm()
                ->post($this->pathaoConfig['base_url'] . '/aladdin/api/v1/issue-token', [
                    'client_id' => $this->pathaoConfig['client_id'],
                    'client_secret' => $this->pathaoConfig['client_secret'],
                    'username' => $this->pathaoConfig['username'],
                    'password' => $this->pathaoConfig['password'],
                    'grant_type' => $this->pathaoConfig['grant_type']
                ]);

            Log::info('Pathao Token Response', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $token = $result['access_token'] ?? null;
                
                if (!$token) {
                    throw new \Exception('Access token not found in response: ' . json_encode($result));
                }
                
                $expiresIn = $result['expires_in'] ?? 3600;
                Cache::put($cacheKey, $token, $expiresIn - 300);
                return $token;
            }

            throw new \Exception('Failed to get Pathao access token. Status: ' . $response->status() . ' Response: ' . $response->body());

        } catch (\Exception $e) {
            Log::error('Pathao Token Error', ['error' => $e->getMessage()]);
            throw new \Exception('Pathao token error: ' . $e->getMessage());
        }
    }

    /**
     * Send order to Pathao - FIXED VERSION
     */
    protected function sendToPathao($order, $priority, $notes)
    {
        try {
            $token = $this->getPathaoToken();
            $endpoint = $this->pathaoConfig['base_url'] . '/aladdin/api/v1/orders';

            // Get recipient information with proper null checks and type casting
            $recipientName = trim((string)($order->billing_name 
                ?? $order->customer_name 
                ?? $order->name 
                ?? $order->recipient_name 
                ?? 'Customer'));
                
            $recipientPhone = trim((string)($order->billing_mobile 
                ?? $order->billing_phone 
                ?? $order->customer_phone 
                ?? $order->phone 
                ?? $order->mobile 
                ?? $order->customer_mobile 
                ?? '01700000000'));
                
            $recipientAddress = trim((string)($order->billing_address 
                ?? $order->customer_address 
                ?? $order->address 
                ?? $order->shipping_address 
                ?? 'Dhaka, Bangladesh'));

            // Get city and zone names as strings
            $cityName = (string)($order->billing_district ?? $order->district ?? 'Dhaka');
            $zoneName = (string)($order->billing_upazila ?? $order->upazila ?? 'Dhaka');

            // Get city and zone IDs with safe fallbacks
            $cityId = $this->getPathaoCityId($cityName);
            $zoneId = $this->getPathaoZoneId($zoneName, $cityId);

            // First get valid store list to find correct store_id
            $validStoreId = $this->getValidPathaoStoreId();
            
            // Ensure all values are properly typed
            $orderData = [
                'store_id' => (int)$validStoreId,
                'merchant_order_id' => (string)$order->order_no,
                'sender_name' => (string)(config('app.name', 'E-commerce')),
                'sender_phone' => '01700000000',
                'recipient_name' => $recipientName,
                'recipient_phone' => $recipientPhone,
                'recipient_address' => $recipientAddress,
                'recipient_city' => (int)$cityId,
                'recipient_zone' => (int)$zoneId,
                'delivery_type' => (int)48,
                'item_type' => (int)2,
                'special_instruction' => (string)($notes ?? 'Handle with care'),
                'item_quantity' => (int)1,
                'item_weight' => (float)0.5,
                'amount_to_collect' => (float)($order->payment_id === 'cash_on_delivery' || $order->payment_method === 'cash_on_delivery' ? (float)$order->order_total : 0),
                'item_description' => 'Order #' . (string)$order->order_no
            ];

            // Log the data being sent for debugging
            Log::info('Pathao Order Data', [
                'order_no' => $order->order_no,
                'order_data' => $orderData
            ]);

            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])
                ->post($endpoint, $orderData);

            Log::info('Pathao Order Response', [
                'order_no' => $order->order_no,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            if ($response->successful()) {
                $result = $response->json();
                
                // Handle different Pathao response structures safely
                $consignmentId = null;
                
                if (isset($result['data']['consignment_id'])) {
                    $consignmentId = $result['data']['consignment_id'];
                } elseif (isset($result['data']) && is_array($result['data']) && isset($result['data']['id'])) {
                    $consignmentId = $result['data']['id'];
                } elseif (isset($result['consignment_id'])) {
                    $consignmentId = $result['consignment_id'];
                } elseif (isset($result['id'])) {
                    $consignmentId = $result['id'];
                }
                
                return [
                    'success' => true,
                    'tracking_id' => $consignmentId,
                    'message' => 'Order successfully sent to Pathao',
                    'response' => $result
                ];
            }

            $errorMessage = 'Unknown error';
            $responseData = $response->json();
            if ($responseData) {
                $errorMessage = $responseData['message'] ?? $responseData['error'] ?? 'API request failed';
                if (isset($responseData['errors']) && is_array($responseData['errors'])) {
                    $errorDetails = [];
                    foreach ($responseData['errors'] as $field => $messages) {
                        if (is_array($messages)) {
                            $errorDetails[] = $field . ': ' . implode(', ', $messages);
                        } else {
                            $errorDetails[] = $field . ': ' . (string)$messages;
                        }
                    }
                    $errorMessage .= ' - ' . implode(', ', $errorDetails);
                }
            }

            return [
                'success' => false,
                'message' => 'Failed to send order to Pathao: ' . $errorMessage
            ];

        } catch (\Exception $e) {
            Log::error('Pathao Order Exception', [
                'order_no' => $order->order_no,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            throw new \Exception('Pathao API Error: ' . $e->getMessage());
        }
    }

    /**
     * Get Pathao cities with safe error handling
     */
    public function getPathaoCities()
    {
        $cacheKey = 'pathao_cities';
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $token = $this->getPathaoToken();
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json'
                ])
                ->get($this->pathaoConfig['base_url'] . '/aladdin/api/v1/cities');

            if ($response->successful()) {
                $result = $response->json();
                
                // Handle different response structures safely
                $cities = [];
                if (isset($result['data']['data'])) {
                    $cities = $result['data']['data'];
                } elseif (isset($result['data']) && is_array($result['data'])) {
                    $cities = $result['data'];
                } elseif (is_array($result)) {
                    $cities = $result;
                }
                
                Cache::put($cacheKey, $cities, 24 * 60 * 60);
                return $cities;
            }

            Log::warning('Failed to get Pathao cities', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [];

        } catch (\Exception $e) {
            Log::error('Failed to get Pathao cities', ['error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Get Pathao zones for a city with safe error handling
     */
    public function getPathaoZones($cityId)
    {
        $cacheKey = "pathao_zones_{$cityId}";
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $token = $this->getPathaoToken();
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json'
                ])
                ->get($this->pathaoConfig['base_url'] . "/aladdin/api/v1/cities/{$cityId}/zone-list");

            if ($response->successful()) {
                $result = $response->json();
                
                // Handle different response structures safely
                $zones = [];
                if (isset($result['data']['data'])) {
                    $zones = $result['data']['data'];
                } elseif (isset($result['data']) && is_array($result['data'])) {
                    $zones = $result['data'];
                } elseif (is_array($result)) {
                    $zones = $result;
                }
                
                Cache::put($cacheKey, $zones, 24 * 60 * 60);
                return $zones;
            }

            Log::warning('Failed to get Pathao zones', [
                'city_id' => $cityId,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [];

        } catch (\Exception $e) {
            Log::error('Failed to get Pathao zones', [
                'city_id' => $cityId, 
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Get city ID by name with safe fallback - IMPROVED VERSION
     */
    protected function getPathaoCityId($cityName)
    {
        $cities = $this->getPathaoCities();
        
        if (empty($cities)) {
            return 1; // Default to Dhaka if no cities found
        }
        
        // Convert cityName to string and trim
        $cityName = trim((string)$cityName);
        
        foreach ($cities as $city) {
            if (isset($city['city_name']) && 
                stripos((string)$city['city_name'], $cityName) !== false) {
                return (int)$city['city_id'];
            }
        }
        
        return 1; // Default to Dhaka
    }

    /**
     * Get zone ID by name and city with safe fallback - IMPROVED VERSION
     */
    protected function getPathaoZoneId($zoneName, $cityId)
    {
        $zones = $this->getPathaoZones($cityId);
        
        if (empty($zones)) {
            return 1; // Default zone ID
        }
        
        // Convert zoneName to string and trim
        $zoneName = trim((string)$zoneName);
        
        foreach ($zones as $zone) {
            if (isset($zone['zone_name']) && 
                stripos((string)$zone['zone_name'], $zoneName) !== false) {
                return (int)$zone['zone_id'];
            }
        }
        
        return (int)($zones[0]['zone_id'] ?? 1); // Default to first zone
    }

    /**
     * Track order status
     */
    public function trackOrder($courierId, $trackingId)
    {
        switch ($courierId) {
            case 'steadfast':
                return $this->trackSteadfastOrder($trackingId);
            case 'pathao':
                return $this->trackPathaoOrder($trackingId);
            default:
                return ['success' => false, 'message' => 'Unsupported courier service'];
        }
    }

    /**
     * Track Steadfast order
     */
    protected function trackSteadfastOrder($trackingId)
    {
        try {
            $endpoint = $this->steadfastConfig['base_url'] . '/track_order';
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'Api-Key' => $this->steadfastConfig['api_key'],
                    'Secret-Key' => $this->steadfastConfig['secret_key']
                ])
                ->post($endpoint, [
                    'tracking_code' => $trackingId
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return ['success' => false, 'message' => 'Failed to track Steadfast order'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Tracking error: ' . $e->getMessage()];
        }
    }

    /**
     * Track Pathao order
     */
    protected function trackPathaoOrder($consignmentId)
    {
        try {
            $token = $this->getPathaoToken();
            $endpoint = $this->pathaoConfig['base_url'] . "/aladdin/api/v1/orders/{$consignmentId}";

            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json'
                ])
                ->get($endpoint);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return ['success' => false, 'message' => 'Failed to track Pathao order'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Tracking error: ' . $e->getMessage()];
        }
    }

    /**
     * Bulk send orders to courier
     */
    public function bulkSendToCourier($orders, $courierId, $priority = 'normal')
    {
        $results = [];
        $successful = 0;
        $failed = 0;

        foreach ($orders as $order) {
            try {
                $result = $this->sendToCourier($order, $courierId, $priority);
                
                if ($result['success']) {
                    $successful++;
                } else {
                    $failed++;
                }
                
                $results[] = [
                    'order_no' => $order->order_no,
                    'result' => $result
                ];

            } catch (\Exception $e) {
                $failed++;
                $results[] = [
                    'order_no' => $order->order_no,
                    'result' => [
                        'success' => false,
                        'message' => 'Exception: ' . $e->getMessage()
                    ]
                ];
                
                Log::error('Bulk courier send exception', [
                    'order_no' => $order->order_no,
                    'courier' => $courierId,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return [
            'success' => $successful > 0,
            'message' => "Successfully sent {$successful} orders to {$courierId}, {$failed} failed",
            'details' => $results,
            'summary' => [
                'total' => count($orders),
                'successful' => $successful,
                'failed' => $failed
            ]
        ];
    }
}