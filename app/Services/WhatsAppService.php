<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * CallMeBot WhatsApp Service
 * ──────────────────────────
 * বিনামূল্যে — Meta Business Account লাগে না।
 *
 * SETUP (মাত্র একবার):
 * ১. আপনার WhatsApp থেকে এই নম্বরে message করুন:
 *    +34 644 65 21 68
 *    Message: "I allow callmebot to send me messages"
 * ২. API Key পাবেন reply-তে (যেমন: 1234567)
 * ৩. .env-এ দিন:
 *    CALLMEBOT_API_KEY=1234567
 *    ADMIN_WHATSAPP_NUMBER=8801816622128
 */
class WhatsAppService
{
    private string $apiKey;
    private string $adminNumber;

    public function __construct()
    {
        // Read from DB settings first, fallback to .env
        try {
            $setting = \App\Models\Setting::first();
            $this->apiKey      = $setting->callmebot_api_key      ?? config('services.whatsapp.callmebot_api_key', '');
            $this->adminNumber = $setting->admin_whatsapp_number   ?? config('services.whatsapp.admin_number', '8801816622128');
        } catch (\Exception $e) {
            // DB not available yet (migrations running)
            $this->apiKey      = config('services.whatsapp.callmebot_api_key', '');
            $this->adminNumber = config('services.whatsapp.admin_number', '8801816622128');
        }
    }

    /**
     * Send WhatsApp message via CallMeBot API.
     */
    private function send(string $number, string $message): bool
    {
        if (empty($this->apiKey)) {
            Log::warning('CallMeBot: API key not set in .env (CALLMEBOT_API_KEY)');
            return false;
        }

        // Normalize number: must start with country code, no +
        $number = preg_replace('/[\s\-\+\(\)]/', '', $number);
        if (str_starts_with($number, '0')) {
            $number = '880' . substr($number, 1);
        }
        if (!str_starts_with($number, '880')) {
            $number = '880' . $number;
        }

        $url = 'https://api.callmebot.com/whatsapp.php?' . http_build_query([
            'phone'  => $number,
            'text'   => $message,
            'apikey' => $this->apiKey,
        ]);

        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 15,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_USERAGENT      => 'USuperShop/1.0',
            ]);
            $response = curl_exec($ch);
            $err      = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($err) {
                Log::error('CallMeBot curl error: ' . $err, ['number' => $number]);
                return false;
            }

            // CallMeBot returns "Message Sent" on success
            $success = stripos((string)$response, 'Message Sent') !== false
                    || $httpCode === 200;

            if ($success) {
                Log::info('WhatsApp sent to admin', ['number' => $number]);
            } else {
                Log::warning('CallMeBot response', [
                    'http_code' => $httpCode,
                    'response'  => substr((string)$response, 0, 200),
                ]);
            }

            return $success;

        } catch (\Exception $e) {
            Log::error('CallMeBot exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Notify admin when a customer places an order.
     */
    public function sendOrderNotification(\App\Models\Order $order): bool
    {
        if (empty($this->adminNumber)) return false;

        $invoice   = $order->invoice_no ?? ('USP' . str_pad($order->id, 5, '0', STR_PAD_LEFT));
        $customer  = $order->shipping->name   ?? ($order->users->name ?? 'Guest');
        $mobile    = $order->shipping->mobile ?? 'N/A';
        $address   = trim(($order->shipping->address ?? '') . ', ' . ($order->shipping->city ?? ''). ', ' . ($order->shipping->area ?? ''), ', ');
        $total     = number_format((float)($order->grand_total ?? $order->order_total ?? 0), 0);
        $payment   = $order->order_payment ?? 'N/A';
        $payMethod = $order->payments->payment_method ?? ($payment === 'COD' ? 'Cash on Delivery' : 'bKash');
        $time      = now()->setTimezone('Asia/Dhaka')->format('d M Y, h:i A');

        // Product list
        $items        = \App\Models\OrderDetail::with('product')
            ->where('order_id', $order->id)->get();
        $productLines = '';
        $i            = 1;
        foreach ($items as $item) {
            $name          = $item->product->name ?? 'Product';
            $qty           = $item->quantity ?? 1;
            $price         = number_format((float)(($item->sell_price ?? 0) * $qty), 0);
            $productLines .= "\n {$i}. {$name}\n    Qty: {$qty} | Tk {$price}";
            $i++;
        }

        $deliveryNote = ((float)($order->delivery_charge ?? 0) <= 0)
            ? '🚚 Delivery: FREE'
            : '🚚 Delivery Charge: Tk ' . number_format((float)$order->delivery_charge, 0);

        $message = "🛒 *নতুন Order — U Super Shop*\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "📋 Invoice : *{$invoice}*\n"
            . "👤 Name    : {$customer}\n"
            . "📱 Phone   : {$mobile}\n"
            . "📍 Address : {$address}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "🛍️ *Products:*{$productLines}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "💰 Total    : *Tk {$total}*\n"
            . "{$deliveryNote}\n"
            . "💳 Method   : {$payMethod}\n"
            . "✅ Payment  : {$payment}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "⏰ {$time}";

        return $this->send($this->adminNumber, $message);
    }

    /**
     * Notify admin when seller/vendor/dropshipper completes payment.
     */
    public function sendMemberPaymentNotification(
        \App\Models\User $user,
        string $invoiceNo,
        string $packageName = '1 Year'
    ): bool {
        if (empty($this->adminNumber)) return false;

        $accountType = match ($user->usertype) {
            'vendor'      => 'Vendor 🏭',
            'dropshipper' => 'Dropshipper 🚀',
            default        => 'Seller 🏪',
        };

        $fee = match ($user->usertype) {
            'vendor'      => '৳499',
            'dropshipper' => '৳999',
            default        => '৳399',
        };

        $expireDate = $user->subscription_plan
            ? \Carbon\Carbon::createFromTimestamp($user->subscription_plan)->format('d M Y')
            : 'N/A';

        $referrer = 'None';
        if ($user->reseller_id) {
            $ref      = \App\Models\User::find($user->reseller_id);
            $referrer = $ref ? "{$ref->name} ({$ref->mobile})" : 'Unknown';
        }

        $time = now()->setTimezone('Asia/Dhaka')->format('d M Y, h:i A');

        $message = "🎉 *নতুন Member Payment — U Super Shop*\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "👤 Name     : *{$user->name}*\n"
            . "📱 Phone    : {$user->mobile}\n"
            . "📧 Email    : {$user->email}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "🆔 Account  : {$accountType}\n"
            . "📄 Invoice  : *{$invoiceNo}*\n"
            . "💳 Amount   : {$fee}\n"
            . "📦 Package  : {$packageName}\n"
            . "⏳ Expires  : {$expireDate}\n"
            . "✅ Payment  : Completed\n"
            . "🔗 Refer By : {$referrer}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "⏰ {$time}";

        return $this->send($this->adminNumber, $message);
    }

    /**
     * Notify admin when order status changes (delivered/canceled/return)
     */
    public function sendOrderStatusNotification(\App\Models\Order $order, string $status): bool
    {
        if (empty($this->adminNumber)) return false;

        $invoice   = $order->invoice_no ?? ('USP' . str_pad($order->id, 5, '0', STR_PAD_LEFT));
        $customer  = $order->shipping->name ?? ($order->users->name ?? 'Customer');
        $mobile    = $order->shipping->mobile ?? 'N/A';
        $statusMap = [
            'delivered' => '✅ Delivered',
            'canceled'  => '❌ Cancelled',
            'return'    => '↩️ Returned',
        ];
        $statusLabel = $statusMap[$status] ?? ucfirst($status);
        $time = now()->setTimezone('Asia/Dhaka')->format('d M Y, h:i A');

        $message = "📦 *Order Status Update*\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "📋 Invoice  : *{$invoice}*\n"
            . "👤 Customer : {$customer}\n"
            . "📱 Phone    : {$mobile}\n"
            . "🔄 Status   : *{$statusLabel}*\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "⏰ {$time}";

        return $this->send($this->adminNumber, $message);
    }

}
