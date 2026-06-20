<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Traits\SendSmsTrait;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckSubscriptionExpiry extends Command
{
    use SendSmsTrait;

    protected $signature   = 'subscription:check-expiry';
    protected $description = 'Check seller/vendor/dropshipper subscription expiry and send renewal reminders';

    public function handle()
    {
        $now       = Carbon::now();
        $oneMonth  = Carbon::now()->addDays(30)->timestamp;
        $today     = $now->timestamp;

        $usertypes = ['seller', 'vendor', 'dropshipper'];

        // ── 1. Suspend accounts whose subscription has expired ──────────────
        $expired = User::whereIn('usertype', $usertypes)
            ->where('payment_status', '!=', 0)      // not already suspended/unpaid
            ->whereNotNull('subscription_plan')
            ->where('subscription_plan', '<=', $today)
            ->get();

        foreach ($expired as $user) {
            $user->status         = 2;   // 2 = suspended
            $user->payment_status = 0;   // unpaid
            $user->save();

            $this->sendExpiryNoticeSms($user, 'expired');
            Log::info("Subscription expired & suspended: user #{$user->id} ({$user->name})");
        }

        // ── 2. Send 30-day renewal reminder ─────────────────────────────────
        $expiringSoon = User::whereIn('usertype', $usertypes)
            ->where('payment_status', '!=', 0)
            ->whereNotNull('subscription_plan')
            ->whereBetween('subscription_plan', [$today, $oneMonth])
            ->get();

        foreach ($expiringSoon as $user) {
            // Only send once — track via cache key
            $cacheKey = "renewal_reminder_sent:{$user->id}";
            if (\Illuminate\Support\Facades\Cache::has($cacheKey)) {
                continue;
            }

            $this->sendExpiryNoticeSms($user, 'reminder');
            \Illuminate\Support\Facades\Cache::put($cacheKey, true, now()->addDays(29));
            Log::info("Renewal reminder sent: user #{$user->id} ({$user->name})");
        }

        $this->info("✓ Expiry check done. Suspended: {$expired->count()}, Reminders: {$expiringSoon->count()}");
    }

    /**
     * Send SMS based on notice type.
     */
    private function sendExpiryNoticeSms(User $user, string $type): void
    {
        if (empty($user->mobile)) return;

        $mobile      = '88' . ltrim($user->mobile, '0');
        $name        = $user->name;
        $expireDate  = $user->subscription_plan
            ? Carbon::createFromTimestamp($user->subscription_plan)->format('d M Y')
            : 'N/A';
        $renewLink   = config('app.url') . '/seller-login';
        $accountType = match ($user->usertype) {
            'vendor'      => 'Vendor',
            'dropshipper' => 'Dropshipper',
            default       => 'Seller',
        };

        if ($type === 'reminder') {
            $message = "⚠️ Dear {$name},\n"
                . "Your U Super Shop {$accountType} account will EXPIRE on {$expireDate}.\n"
                . "Please renew your subscription to continue using your account.\n"
                . "🔄 Renew Now: {$renewLink}\n"
                . "📞 Support: 01816622128\n"
                . "Thank you — U Super Shop ❤️";
        } else {
            $message = "🚫 Dear {$name},\n"
                . "Your U Super Shop {$accountType} account has EXPIRED and is now SUSPENDED.\n"
                . "Expiry Date: {$expireDate}\n"
                . "To reactivate, please renew your subscription.\n"
                . "🔄 Renew: {$renewLink}\n"
                . "📞 Support: 01816622128\n"
                . "Thank you — U Super Shop ❤️";
        }

        try {
            $this->send_rapid_message($mobile, $message);
        } catch (\Exception $e) {
            Log::error("Expiry SMS failed for user #{$user->id}: " . $e->getMessage());
        }
    }
}
