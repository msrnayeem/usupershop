<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Meta WhatsApp Cloud API Service
 *
 * Setup Guide:
 * 1. Go to: https://developers.facebook.com
 * 2. Create App → Business → WhatsApp
 * 3. Get Phone Number ID and Temporary/Permanent Access Token
 * 4. Add to .env:
 *    WHATSAPP_TOKEN=your_token
 *    WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id
 *    ADMIN_WHATSAPP_NUMBER=8801816622128
 */
class WhatsAppService
{
    private string $token;
    private string $phoneNumberId;
    private string $apiUrl;

    public function __construct()
    {
        $this->token         = config('services.whatsapp.token', '');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id', '');
        $this->apiUrl        = "https://graph.facebook.com/v19.0/{$this->phoneNumberId}/messages";
    }

    /**
     * Send a plain text message.
     */
    public function sendText(string $to, string $message): bool
    {
        if (empty($this->token) || empty($this->phoneNumberId)) {
            Log::warning('WhatsApp: token or phone_number_id not configured in .env');
            return false;
        }

        // Normalize number: remove +, spaces → must start with country code
        $to = preg_replace('/[\s\-\+\(\)]/', '', $to);
        if (str_starts_with($to, '0')) {
            $to = '880' . substr($to, 1);
        }

        try {
            $response = Http::withToken($this->token)
                ->timeout(10)
                ->post($this->apiUrl, [
                    'messaging_product' => 'whatsapp',
                    'recipient_type'    => 'individual',
                    'to'                => $to,
                    'type'              => 'text',
                    'text'              => [
                        'preview_url' => false,
                        'body'        => $message,
                    ],
                ]);

            if ($response->successful()) {
                Log::info('WhatsApp sent successfully', ['to' => $to]);
                return true;
            }

            Log::error('WhatsApp API error', [
                'status'   => $response->status(),
                'response' => $response->json(),
                'to'       => $to,
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('WhatsApp exception: ' . $e->getMessage(), ['to' => $to]);
            return false;
        }
    }

    /**
     * Send new order notification to admin.
     */
    public function sendOrderNotification(\App\Models\Order $order): bool
    {
        $adminNumber = config('services.whatsapp.admin_number', '');
        if (empty($adminNumber)) {
            Log::warning('WhatsApp: ADMIN_WHATSAPP_NUMBER not set');
            return false;
        }

        $invoice  = $order->invoice_no ?? ('USP' . str_pad($order->id, 5, '0', STR_PAD_LEFT));
        $customer = $order->shipping->name   ?? ($order->users->name ?? 'Guest');
        $mobile   = $order->shipping->mobile ?? 'N/A';
        $address  = $order->shipping->address ?? 'N/A';
        $total    = number_format($order->grand_total ?? $order->order_total ?? 0, 0);
        $payment  = $order->order_payment ?? 'N/A';
        $payMethod = $order->payments->payment_method ?? 'N/A';
        $time     = now()->setTimezone('Asia/Dhaka')->format('d M Y, h:i A');

        // Product list
        $items = \App\Models\OrderDetail::with('product')
            ->where('order_id', $order->id)->get();

        $productLines = '';
        foreach ($items as $i => $item) {
            $num   = $i + 1;
            $name  = $item->product->name ?? 'Product';
            $qty   = $item->quantity ?? 1;
            $price = number_format(($item->sell_price ?? 0) * $qty, 0);
            $productLines .= "\n {$num}. {$name}\n    Qty: {$qty} | Price: ৳{$price}";
        }

        $message = "🛒 *নতুন অর্ডার — U Super Shop*\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "📋 Invoice    : *{$invoice}*\n"
            . "👤 Customer   : {$customer}\n"
            . "📱 Phone      : {$mobile}\n"
            . "📍 Address    : {$address}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "🛍️ *Products:*{$productLines}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "💰 Total      : *৳{$total}*\n"
            . "💳 Pay Method : {$payMethod}\n"
            . "✅ Pay Status : {$payment}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "⏰ {$time}";

        return $this->sendText($adminNumber, $message);
    }

    /**
     * Send new member (seller/vendor/dropshipper) payment notification to admin.
     */
    public function sendMemberPaymentNotification(
        \App\Models\User $user,
        string $invoiceNo,
        string $packageName = '1 Year'
    ): bool {
        $adminNumber = config('services.whatsapp.admin_number', '');
        if (empty($adminNumber)) return false;

        $accountType = match ($user->usertype) {
            'vendor'      => 'Vendor 🏭',
            'dropshipper' => 'Dropshipper 🚀',
            default       => 'Seller 🏪',
        };

        $expireDate = $user->subscription_plan
            ? \Carbon\Carbon::createFromTimestamp($user->subscription_plan)->format('d M Y')
            : 'N/A';

        $referrer = 'N/A';
        if ($user->reseller_id) {
            $ref      = \App\Models\User::find($user->reseller_id);
            $referrer = $ref ? "{$ref->name} ({$ref->mobile})" : 'Unknown';
        }

        $time = now()->setTimezone('Asia/Dhaka')->format('d M Y, h:i A');

        $message = "🎉 *নতুন Member Payment — U Super Shop*\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "👤 Name       : *{$user->name}*\n"
            . "📱 Phone      : {$user->mobile}\n"
            . "📧 Email      : {$user->email}\n"
            . "🆔 User ID    : #{$user->id}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "📋 Account    : {$accountType}\n"
            . "📄 Invoice    : *{$invoiceNo}*\n"
            . "📦 Package    : {$packageName}\n"
            . "⏳ Expires    : {$expireDate}\n"
            . "💳 Payment    : ✅ Completed\n"
            . "🔗 Referred By: {$referrer}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "⏰ {$time}";

        return $this->sendText($adminNumber, $message);
    }
}
