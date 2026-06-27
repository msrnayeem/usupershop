<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Courier;

class CourierService
{
    protected $steadfast;
    protected $pathao;

    public function __construct()
    {
        // ── Load credentials from DB ─────────────────────────────────
        $sfRow = Courier::where('name', 'Steadfast')->first();
        $ptRow = Courier::where('name', 'Pathao')->first();

        $this->steadfast = [
            'base_url'   => $sfRow->base_url    ?? 'https://portal.packzy.com/api/v1',
            'api_key'     => $sfRow->api_key     ?? '',
            'secret_key'  => $sfRow->secret_key  ?? '',
            'is_active'   => $sfRow->is_active   ?? 0,
            'is_sandbox'  => $sfRow->is_sandbox  ?? 0,
        ];

        $isSandbox = ($ptRow->is_sandbox ?? 0);
        $this->pathao = [
            'base_url'       => $ptRow->base_url      ?? ($isSandbox ? 'https://courier-api-sandbox.pathao.com' : 'https://courier-api.pathao.com'),
            'client_id'      => $ptRow->client_id     ?? '',
            'client_secret'  => $ptRow->client_secret ?? '',
            'username'       => $ptRow->username       ?? '',
            'password'       => $ptRow->password       ?? '',
            'store_id'       => $ptRow->store_id       ?? '',
            'is_active'      => $ptRow->is_active      ?? 0,
            'is_sandbox'     => $isSandbox,
            'grant_type'     => 'password',
        ];
    }

    // ── Send to courier ───────────────────────────────────────────────
    public function sendToCourier($order, $courierId, $priority = 'normal', $notes = null)
    {
        try {
            switch ($courierId) {
                case 'steadfast':
                    if (!$this->steadfast['is_active'])
                        return ['success' => false, 'message' => 'Steadfast courier is not active. Admin → Couriers থেকে activate করুন।'];
                    if (empty($this->steadfast['api_key']))
                        return ['success' => false, 'message' => 'Steadfast API Key নেই। Admin → Couriers থেকে set করুন।'];
                    return $this->sendToSteadfast($order, $priority, $notes);

                case 'pathao':
                    if (!$this->pathao['is_active'])
                        return ['success' => false, 'message' => 'Pathao courier is not active. Admin → Couriers থেকে activate করুন।'];
                    if (empty($this->pathao['client_id']))
                        return ['success' => false, 'message' => 'Pathao credentials নেই। Admin → Couriers থেকে set করুন।'];
                    return $this->sendToPathao($order, $priority, $notes);

                default:
                    return ['success' => false, 'message' => 'Unknown courier: ' . $courierId];
            }
        } catch (\Exception $e) {
            Log::error('Courier API Error', ['courier' => $courierId, 'error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Courier API error: ' . $e->getMessage()];
        }
    }

    // ── Steadfast ────────────────────────────────────────────────────
    protected function sendToSteadfast($order, $priority, $notes)
    {
        $shipping = $order->shipping;
        $recipientName    = $shipping->name    ?? $order->billing_name    ?? 'Customer';
        $recipientPhone   = $shipping->mobile  ?? $order->billing_mobile  ?? '01700000000';
        $recipientAddress = $shipping->address ?? $order->billing_address ?? 'Dhaka, Bangladesh';

        $isCOD = in_array(strtolower($order->payment_method ?? ''), ['cash on delivery', 'cod', 'unpaid']);
        $codAmount = $isCOD ? (float)($order->grand_total ?? $order->order_total ?? 0) : 0;

        $payload = [
            'invoice'            => $order->order_no ?? $order->invoice_no ?? ('USP' . $order->id),
            'recipient_name'     => trim($recipientName),
            'recipient_phone'    => trim($recipientPhone),
            'recipient_address'  => trim($recipientAddress),
            'cod_amount'         => $codAmount,
            'note'               => $notes ?? 'U Super Shop order',
        ];

        $response = Http::timeout(30)
            ->withHeaders([
                'Api-Key'    => $this->steadfast['api_key'],
                'Secret-Key' => $this->steadfast['secret_key'],
                'Content-Type' => 'application/json',
                'Accept'     => 'application/json',
            ])
            ->post($this->steadfast['base_url'] . '/create_order', $payload);

        Log::info('Steadfast Response', ['order' => $order->id, 'status' => $response->status(), 'body' => $response->body()]);

        if ($response->successful()) {
            $result = $response->json();
            $tracking = $result['consignment']['tracking_code']
                ?? $result['data']['tracking_code']
                ?? $result['tracking_code']
                ?? null;
            return ['success' => true, 'tracking_id' => $tracking, 'message' => 'Order sent to Steadfast successfully!', 'response' => $result];
        }

        $err = $response->json()['message'] ?? $response->json()['error'] ?? 'API request failed (HTTP ' . $response->status() . ')';
        return ['success' => false, 'message' => 'Steadfast error: ' . $err];
    }

    // ── Pathao Token ─────────────────────────────────────────────────
    protected function getPathaoToken()
    {
        $cacheKey = 'pathao_access_token_' . md5($this->pathao['client_id']);

        if (Cache::has($cacheKey)) return Cache::get($cacheKey);

        $response = Http::timeout(30)
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->post($this->pathao['base_url'] . '/aladdin/api/v1/issue-token', [
                'client_id'     => $this->pathao['client_id'],
                'client_secret' => $this->pathao['client_secret'],
                'username'      => $this->pathao['username'],
                'password'      => $this->pathao['password'],
                'grant_type'    => 'password',
            ]);

        if (!$response->successful())
            throw new \Exception('Pathao token failed: ' . $response->body());

        $result = $response->json();
        $token  = $result['access_token'] ?? throw new \Exception('No access_token in Pathao response');
        Cache::put($cacheKey, $token, ($result['expires_in'] ?? 3600) - 300);
        return $token;
    }

    // ── Pathao Store ID ──────────────────────────────────────────────
    protected function getValidPathaoStoreId()
    {
        if (!empty($this->pathao['store_id'])) return (int)$this->pathao['store_id'];

        $cacheKey = 'pathao_store_id_' . md5($this->pathao['client_id']);
        if (Cache::has($cacheKey)) return Cache::get($cacheKey);

        try {
            $token    = $this->getPathaoToken();
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json'])
                ->get($this->pathao['base_url'] . '/aladdin/api/v1/stores');
            if ($response->successful()) {
                $stores  = $response->json()['data']['data'] ?? $response->json()['data'] ?? [];
                $storeId = $stores[0]['store_id'] ?? 1;
                Cache::put($cacheKey, $storeId, 86400);
                return $storeId;
            }
        } catch (\Exception $e) { Log::warning('Pathao store fetch failed', ['error' => $e->getMessage()]); }
        return 1;
    }

    // ── Pathao Cities/Zones ──────────────────────────────────────────
    public function getPathaoCities()
    {
        $cacheKey = 'pathao_cities_' . md5($this->pathao['client_id']);
        if (Cache::has($cacheKey)) return Cache::get($cacheKey);
        try {
            $token    = $this->getPathaoToken();
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json'])
                ->get($this->pathao['base_url'] . '/aladdin/api/v1/cities');
            if ($response->successful()) {
                $cities = $response->json()['data']['data'] ?? $response->json()['data'] ?? [];
                Cache::put($cacheKey, $cities, 86400);
                return $cities;
            }
        } catch (\Exception $e) { }
        return [];
    }

    public function getPathaoZones($cityId)
    {
        $cacheKey = 'pathao_zones_' . $cityId . '_' . md5($this->pathao['client_id']);
        if (Cache::has($cacheKey)) return Cache::get($cacheKey);
        try {
            $token    = $this->getPathaoToken();
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json'])
                ->get($this->pathao['base_url'] . "/aladdin/api/v1/cities/{$cityId}/zone-list");
            if ($response->successful()) {
                $zones = $response->json()['data']['data'] ?? $response->json()['data'] ?? [];
                Cache::put($cacheKey, $zones, 86400);
                return $zones;
            }
        } catch (\Exception $e) { }
        return [];
    }

    protected function getPathaoCityId($cityName)
    {
        foreach ($this->getPathaoCities() as $city)
            if (isset($city['city_name']) && stripos($city['city_name'], $cityName) !== false)
                return (int)$city['city_id'];
        return 1;
    }

    protected function getPathaoZoneId($zoneName, $cityId)
    {
        $zones = $this->getPathaoZones($cityId);
        foreach ($zones as $z)
            if (isset($z['zone_name']) && stripos($z['zone_name'], $zoneName) !== false)
                return (int)$z['zone_id'];
        return (int)($zones[0]['zone_id'] ?? 1);
    }

    // ── Pathao Send Order ────────────────────────────────────────────
    protected function sendToPathao($order, $priority, $notes)
    {
        $token    = $this->getPathaoToken();
        $shipping = $order->shipping;

        $recipientName    = trim($shipping->name    ?? $order->billing_name    ?? 'Customer');
        $recipientPhone   = trim($shipping->mobile  ?? $order->billing_mobile  ?? '01700000000');
        $recipientAddress = trim($shipping->address ?? $order->billing_address ?? 'Dhaka, Bangladesh');
        $cityName         = $shipping->district ?? $order->billing_district ?? 'Dhaka';
        $zoneName         = $shipping->upazila  ?? $order->billing_upazila  ?? 'Dhaka';

        $cityId = $this->getPathaoCityId($cityName);
        $zoneId = $this->getPathaoZoneId($zoneName, $cityId);

        $isCOD = in_array(strtolower($order->payment_method ?? ''), ['cash on delivery', 'cod', 'unpaid']);
        $collectAmount = $isCOD ? (float)($order->grand_total ?? $order->order_total ?? 0) : 0;

        $payload = [
            'store_id'            => (int)$this->getValidPathaoStoreId(),
            'merchant_order_id'   => (string)($order->order_no ?? $order->invoice_no ?? 'USP' . $order->id),
            'sender_name'         => 'U Super Shop',
            'sender_phone'        => '01816622128',
            'recipient_name'      => $recipientName,
            'recipient_phone'     => $recipientPhone,
            'recipient_address'   => $recipientAddress,
            'recipient_city'      => $cityId,
            'recipient_zone'      => $zoneId,
            'delivery_type'       => 48,
            'item_type'           => 2,
            'special_instruction' => $notes ?? '',
            'item_quantity'       => 1,
            'item_weight'         => 0.5,
            'amount_to_collect'   => $collectAmount,
            'item_description'    => 'Order #' . ($order->order_no ?? $order->id),
        ];

        $response = Http::timeout(30)
            ->withHeaders(['Authorization' => 'Bearer ' . $token, 'Content-Type' => 'application/json', 'Accept' => 'application/json'])
            ->post($this->pathao['base_url'] . '/aladdin/api/v1/orders', $payload);

        Log::info('Pathao Response', ['order' => $order->id, 'status' => $response->status(), 'body' => $response->body()]);

        if ($response->successful()) {
            $result = $response->json();
            $consignmentId = $result['data']['consignment_id'] ?? $result['data']['id'] ?? $result['consignment_id'] ?? null;
            return ['success' => true, 'tracking_id' => $consignmentId, 'message' => 'Order sent to Pathao successfully!', 'response' => $result];
        }

        $errors = $response->json()['errors'] ?? [];
        $errMsg = $response->json()['message'] ?? 'API failed (HTTP ' . $response->status() . ')';
        if (!empty($errors)) $errMsg .= ' — ' . implode(', ', array_map(fn($e) => is_array($e) ? implode(', ', $e) : $e, $errors));
        return ['success' => false, 'message' => 'Pathao error: ' . $errMsg];
    }

    // ── Track Order ──────────────────────────────────────────────────
    public function trackOrder($courierId, $trackingId)
    {
        try {
            if ($courierId === 'steadfast') {
                $r = Http::withHeaders(['Api-Key' => $this->steadfast['api_key'], 'Secret-Key' => $this->steadfast['secret_key']])
                    ->post($this->steadfast['base_url'] . '/track_order', ['tracking_code' => $trackingId]);
                return $r->successful() ? ['success' => true, 'data' => $r->json()] : ['success' => false, 'message' => 'Tracking failed'];
            }
            if ($courierId === 'pathao') {
                $token = $this->getPathaoToken();
                $r = Http::withHeaders(['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json'])
                    ->get($this->pathao['base_url'] . "/aladdin/api/v1/orders/{$trackingId}");
                return $r->successful() ? ['success' => true, 'data' => $r->json()] : ['success' => false, 'message' => 'Tracking failed'];
            }
        } catch (\Exception $e) { return ['success' => false, 'message' => $e->getMessage()]; }
        return ['success' => false, 'message' => 'Unknown courier'];
    }

    // ── Test Connection ──────────────────────────────────────────────
    public function testConnection($courierId)
    {
        try {
            if ($courierId === 'steadfast') {
                if (empty($this->steadfast['api_key'])) return ['success' => false, 'message' => 'API Key খালি'];
                $r = Http::withHeaders(['Api-Key' => $this->steadfast['api_key'], 'Secret-Key' => $this->steadfast['secret_key']])
                    ->get($this->steadfast['base_url'] . '/get_balance');
                return $r->successful()
                    ? ['success' => true,  'message' => '✅ Steadfast সংযোগ সফল! Balance: ' . ($r->json()['current_balance'] ?? 'N/A')]
                    : ['success' => false, 'message' => '❌ Steadfast connection failed: ' . $r->body()];
            }
            if ($courierId === 'pathao') {
                if (empty($this->pathao['client_id'])) return ['success' => false, 'message' => 'Client ID খালি'];
                $token = $this->getPathaoToken();
                return ['success' => true, 'message' => '✅ Pathao সংযোগ সফল! Token পাওয়া গেছে।'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => '❌ Error: ' . $e->getMessage()];
        }
        return ['success' => false, 'message' => 'Unknown courier'];
    }
}
