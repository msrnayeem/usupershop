<?php

namespace App\Traits;

use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

/**
 * Trait to send WhatsApp notifications via Meta Cloud API.
 * Just use this trait in any controller.
 */
trait WhatsAppNotifyTrait
{
    /**
     * Notify admin when a customer places an order.
     */
    public function notifyAdminNewOrder(\App\Models\Order $order): void
    {
        try {
            app(WhatsAppService::class)->sendOrderNotification($order);
        } catch (\Exception $e) {
            Log::warning('WhatsApp order notify failed: ' . $e->getMessage());
        }
    }

    /**
     * Notify admin when seller/vendor/dropshipper payment is completed.
     */
    public function notifyAdminNewMemberPayment(
        \App\Models\User $user,
        string $invoiceNo,
        string $packageName = '1 Year'
    ): void {
        try {
            app(WhatsAppService::class)->sendMemberPaymentNotification($user, $invoiceNo, $packageName);
        } catch (\Exception $e) {
            Log::warning('WhatsApp member notify failed: ' . $e->getMessage());
        }
    }
}
