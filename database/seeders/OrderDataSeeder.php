<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderDataSeeder extends Seeder
{
    public function run()
    {
        // IDs we found
        $vendorId = 2; // Rafi (Vendor)
        $sellerId = 3; // rafi islam (Seller)
        $customerId = 1; // Admin/Default customer
        $deliveryZoneId = 1;
        $paymentId = 1;
        $shippingId = 1;

        // Get some products
        $products = Product::take(3)->get();

        if ($products->isEmpty()) {
            $this->command->error('No products found to seed orders.');
            return;
        }

        $this->seedOrdersForUser(2, 3, $customerId, $shippingId, $paymentId, $products, 'R1');
        $this->seedOrdersForUser(11, 14, $customerId, $shippingId, $paymentId, $products, 'R2');

        $this->command->info('Order data seeded successfully for all accounts.');
    }

    private function seedOrdersForUser($vendorId, $sellerId, $customerId, $shippingId, $paymentId, $products, $prefix)
    {
        // 1. Create a Pending order for the Seller
        $sellerOrder = Order::create([
            'user_id' => $customerId,
            'shipping_id' => $shippingId,
            'payment_id' => $paymentId,
            'shop_id' => $sellerId,
            'order_no' => $prefix . '-S-P-' . time() . rand(10, 99),
            'invoice_no' => 'INV-' . $prefix . '-S-' . date('Ymd') . '-' . rand(100, 999),
            'order_total' => 1500,
            'grand_total' => 1500,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        foreach ($products as $product) {
            OrderDetail::create([
                'order_id' => $sellerOrder->id,
                'product_id' => $product->id,
                'color_id' => 0,
                'size_id' => 0,
                'quantity' => 1,
                'sell_price' => $product->price,
                'buy_price' => $product->price - 50,
                'vendor_id' => $product->user_id,
            ]);
        }

        // 2. Create an order for the Vendor
        $vendorProduct = Product::where('user_id', $vendorId)->first();
        if (!$vendorProduct) {
            $vendorProduct = $products->first();
            $vendorProduct->user_id = $vendorId;
            $vendorProduct->save();
        }

        $vendorOrder = Order::create([
            'user_id' => $customerId,
            'shipping_id' => $shippingId,
            'payment_id' => $paymentId,
            'order_no' => $prefix . '-V-P-' . time() . rand(10, 99),
            'invoice_no' => 'INV-' . $prefix . '-V-' . date('Ymd') . '-' . rand(100, 999),
            'order_total' => $vendorProduct->price,
            'grand_total' => $vendorProduct->price,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        OrderDetail::create([
            'order_id' => $vendorOrder->id,
            'product_id' => $vendorProduct->id,
            'color_id' => 0,
            'size_id' => 0,
            'quantity' => 1,
            'sell_price' => $vendorProduct->price,
            'buy_price' => $vendorProduct->price - 100,
            'vendor_id' => $vendorId,
        ]);

        // 3. Create a Confirmed order for Seller to test tracking
        $confirmedOrder = Order::create([
            'user_id' => $customerId,
            'shipping_id' => $shippingId,
            'payment_id' => $paymentId,
            'shop_id' => $sellerId,
            'order_no' => $prefix . '-S-C-' . time() . rand(10, 99),
            'invoice_no' => 'INV-' . $prefix . '-SC-' . date('Ymd') . '-' . rand(100, 999),
            'order_total' => 2000,
            'grand_total' => 2000,
            'status' => 'confirmed',
            'confirmed_at' => Carbon::now(),
            'created_at' => Carbon::now()->subDay(),
            'updated_at' => Carbon::now(),
        ]);

        OrderDetail::create([
            'order_id' => $confirmedOrder->id,
            'product_id' => $products->first()->id,
            'color_id' => 0,
            'size_id' => 0,
            'quantity' => 2,
            'sell_price' => $products->first()->price,
            'buy_price' => $products->first()->price - 50,
            'vendor_id' => $products->first()->user_id,
        ]);
    }
}
