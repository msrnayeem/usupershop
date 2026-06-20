<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CleanAbandonedOrders extends Command
{
    protected $signature   = 'orders:clean-abandoned';
    protected $description = 'Delete orders stuck in "initiated" status for more than 24 hours (payment abandoned)';

    public function handle()
    {
        $cutoff = Carbon::now()->subHours(24);

        $abandoned = Order::where('status', 'initiated')
            ->where('created_at', '<', $cutoff)
            ->with(['order_details'])
            ->get();

        $count = 0;
        foreach ($abandoned as $order) {
            // Restore product stock
            foreach ($order->order_details as $detail) {
                Product::where('id', $detail->product_id)
                    ->increment('quantity', $detail->quantity);
            }

            // Delete related records
            OrderDetail::where('order_id', $order->id)->delete();
            if ($order->shipping_id) Shipping::destroy($order->shipping_id);
            if ($order->payment_id)  Payment::destroy($order->payment_id);
            $order->delete();
            $count++;
        }

        Log::info("Cleaned {$count} abandoned orders");
        $this->info("✓ Cleaned {$count} abandoned orders (unpaid for 24h+)");
    }
}
