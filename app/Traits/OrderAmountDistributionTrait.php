<?php
namespace App\Traits;

use App\Models\Transaction;
use App\Models\User;
use App\utilities\Constant;
use Illuminate\Support\Facades\Log;

trait OrderAmountDistributionTrait
{
    /**
     * Distribute commissions when order is DELIVERED.
     *
     * Commission rules:
     * ─ Vendor product  → Admin cuts 20% → Vendor gets 80%
     * ─ Seller product  → Admin cuts 20% → Seller gets 10%, Admin keeps 10%
     *
     * This runs ONLY on 'delivered' status.
     * On 'canceled' or 'return' → reverseOrderCommissions() is called instead.
     */
    public function order_amount_distribution($orderData)
    {
        // ── Idempotency: prevent double commission ────────────────────
        $alreadyProcessed = Transaction::where('from_user_id', $orderData->user_id)
            ->whereIn('tnx_type', [
                Constant::TRANSACTION_TYPE['product_seles'],
                Constant::TRANSACTION_TYPE['admin_sales_commission_amount'],
            ])
            ->whereRaw("description LIKE ?", ['%"order_id":"' . $orderData->id . '"%'])
            ->exists();

        if ($alreadyProcessed) {
            Log::info('Commission already distributed for order', ['order_id' => $orderData->id]);
            return true;
        }

        $orderItems      = $this->get_order_items($orderData->order_details);
        $itemPerDiscount = $this->get_per_item_discount($orderData, $orderItems['count']);
        $dateTime        = time();

        foreach ($orderItems['data'] as $item) {
            $transactionData = [];

            // ── 1. Calculate base amount (after coupon discount) ──────
            $totalProductAmount = (float)($item['sell_price'] * $item['quantity']);
            $amountAfterDiscount = max(0, $totalProductAmount - $itemPerDiscount);

            // ── 2. Determine product owner type ───────────────────────
            $productOwnerId   = $item['vendor_id']; // product owner (seller or vendor)
            $productOwnerType = 'seller';
            if ($productOwnerId) {
                $owner = User::select('id', 'usertype')->find($productOwnerId);
                if ($owner) {
                    $productOwnerType = $owner->usertype; // 'seller', 'vendor', 'dropshipper'
                }
            }

            // ── 3. Commission split ───────────────────────────────────
            // Admin always takes 20% of the sale
            $adminCutPercent  = 20;
            $adminCutAmount   = round($amountAfterDiscount * $adminCutPercent / 100, 2);
            $remainingAmount  = round($amountAfterDiscount - $adminCutAmount, 2);

            // Seller product: Seller gets 10% (half of admin's 20%), Admin keeps 10%
            // Vendor product: Vendor gets 80% (everything minus admin's 20%), Admin keeps 20%
            $sellerAmount    = 0;
            $vendorAmount    = 0;
            $adminFinalAmount= $adminCutAmount;

            if ($productOwnerType === 'seller') {
                // Seller gets 10% of total = half of the 20% cut
                $sellerPercent  = 10;
                $sellerAmount   = round($amountAfterDiscount * $sellerPercent / 100, 2);
                $adminFinalAmount = round($adminCutAmount - $sellerAmount, 2); // Admin keeps 10%
            } elseif (in_array($productOwnerType, ['vendor', 'dropshipper'])) {
                // Vendor gets remaining 80%
                $vendorAmount = $remainingAmount;
                // Admin keeps full 20%
            } else {
                // Unknown type — treat as seller
                $sellerAmount   = round($amountAfterDiscount * 10 / 100, 2);
                $adminFinalAmount = round($adminCutAmount - $sellerAmount, 2);
            }

            // ── 4. Reseller commission (from admin's share) ───────────
            $resellerCommissionAmount = 0;
            if ($item['reseller_id'] && $item['reseller_commission'] > 0) {
                $resellerCommissionAmount = round(
                    $adminFinalAmount * $item['reseller_commission'] / 100, 2
                );
                $adminFinalAmount = round($adminFinalAmount - $resellerCommissionAmount, 2);
            }

            $descriptionData = [
                'order_id'      => (string)$item['order_id'],
                'order_no'      => $item['order_no'],
                'product_id'    => $item['product_id'],
                'owner_type'    => $productOwnerType,
                'total_amount'  => $amountAfterDiscount,
                'vendor_amount' => $vendorAmount,
                'seller_amount' => $sellerAmount,
                'admin_amount'  => $adminFinalAmount,
            ];

            // ── 5. Credit SELLER (Seller product — 10%) ───────────────
            if ($sellerAmount > 0 && $productOwnerId) {
                $seller = User::find($productOwnerId);
                if ($seller) {
                    $seller->increment('sales_amount', $sellerAmount);
                    $seller->increment('balance', $sellerAmount);

                    $transactionData[] = [
                        'user_id'      => $productOwnerId,
                        'from_user_id' => $item['user_id'],
                        'wallet_type'  => Constant::WALLET_TYPE['balance_wallet'],
                        'tnx_type'     => Constant::TRANSACTION_TYPE['product_seles'],
                        'credit'       => $sellerAmount,
                        'debit'        => 0,
                        'note'         => "10% Seller Commission — Order: {$item['order_no']}",
                        'description'  => json_encode($descriptionData),
                        'status'       => Constant::STATUS['approved'],
                        'in_status'    => Constant::IN_STATUS['active'],
                        'date'         => $dateTime,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }

            // ── 6. Credit VENDOR (Vendor product — 80%) ───────────────
            if ($vendorAmount > 0 && $productOwnerId) {
                $vendor = User::find($productOwnerId);
                if ($vendor) {
                    $vendor->increment('sales_amount', $vendorAmount);
                    $vendor->increment('balance', $vendorAmount);

                    $transactionData[] = [
                        'user_id'      => $productOwnerId,
                        'from_user_id' => $item['user_id'],
                        'wallet_type'  => Constant::WALLET_TYPE['balance_wallet'],
                        'tnx_type'     => Constant::TRANSACTION_TYPE['product_seles'],
                        'credit'       => $vendorAmount,
                        'debit'        => 0,
                        'note'         => "80% Vendor Commission — Order: {$item['order_no']}",
                        'description'  => json_encode($descriptionData),
                        'status'       => Constant::STATUS['approved'],
                        'in_status'    => Constant::IN_STATUS['active'],
                        'date'         => $dateTime,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }

            // ── 7. Credit RESELLER (from admin's share) ───────────────
            if ($resellerCommissionAmount > 0 && $item['reseller_id']) {
                $reseller = User::find($item['reseller_id']);
                if ($reseller) {
                    $reseller->increment('reseller_commission_amount', $resellerCommissionAmount);
                    $reseller->increment('balance', $resellerCommissionAmount);

                    $transactionData[] = [
                        'user_id'      => $item['reseller_id'],
                        'from_user_id' => $item['user_id'],
                        'wallet_type'  => Constant::WALLET_TYPE['balance_wallet'],
                        'tnx_type'     => Constant::TRANSACTION_TYPE['reseller_seles_commission'],
                        'credit'       => $resellerCommissionAmount,
                        'debit'        => 0,
                        'note'         => "{$item['reseller_commission']}% Reseller Commission — Order: {$item['order_no']}",
                        'description'  => json_encode($descriptionData),
                        'status'       => Constant::STATUS['approved'],
                        'in_status'    => Constant::IN_STATUS['active'],
                        'date'         => $dateTime,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }

            // ── 8. Credit ADMIN (remaining commission) ────────────────
            if ($adminFinalAmount > 0) {
                // Admin user ID = 1
                $adminNote = $productOwnerType === 'vendor'
                    ? "20% Admin Commission (Vendor product) — Order: {$item['order_no']}"
                    : "10% Admin Commission (Seller product) — Order: {$item['order_no']}";

                $transactionData[] = [
                    'user_id'      => 1,
                    'from_user_id' => $item['user_id'],
                    'wallet_type'  => Constant::WALLET_TYPE['admin_wallet'],
                    'tnx_type'     => Constant::TRANSACTION_TYPE['admin_sales_commission_amount'],
                    'credit'       => $adminFinalAmount,
                    'debit'        => 0,
                    'note'         => $adminNote,
                    'description'  => json_encode($descriptionData),
                    'status'       => Constant::STATUS['approved'],
                    'in_status'    => Constant::IN_STATUS['active'],
                    'date'         => $dateTime,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }

            // ── 9. Insert all transactions for this item ──────────────
            if (!empty($transactionData)) {
                Transaction::insert($transactionData);
            }

            Log::info('Commission distributed', [
                'order_id'     => $item['order_id'],
                'product_id'   => $item['product_id'],
                'owner_type'   => $productOwnerType,
                'total'        => $amountAfterDiscount,
                'seller_gets'  => $sellerAmount,
                'vendor_gets'  => $vendorAmount,
                'admin_gets'   => $adminFinalAmount,
                'reseller_gets'=> $resellerCommissionAmount,
            ]);
        }

        return true;
    }

    /**
     * Reverse commissions on CANCELED or RETURN status.
     * Deducts the credited amounts from seller/vendor/reseller balances.
     */
    public function reverseOrderCommissions($orderData)
    {
        // Find all commission transactions for this order
        $orderDesc = '"order_id":"' . $orderData->id . '"';

        $transactions = Transaction::whereIn('tnx_type', [
            Constant::TRANSACTION_TYPE['product_seles'],
            Constant::TRANSACTION_TYPE['admin_sales_commission_amount'],
            Constant::TRANSACTION_TYPE['reseller_seles_commission'],
        ])
        ->whereRaw("description LIKE ?", ["%{$orderDesc}%"])
        ->where('credit', '>', 0)
        ->get();

        if ($transactions->isEmpty()) {
            Log::info('No commissions to reverse for order', ['order_id' => $orderData->id]);
            return;
        }

        $dateTime = time();

        foreach ($transactions as $txn) {
            if ($txn->credit <= 0) continue;

            // Deduct from user balance
            $user = User::find($txn->user_id);
            if ($user) {
                if ($txn->tnx_type === Constant::TRANSACTION_TYPE['admin_sales_commission_amount']) {
                    // Admin wallet — no balance field needed, just log
                } else {
                    $newBalance = max(0, ($user->balance ?? 0) - $txn->credit);
                    $user->balance = $newBalance;

                    if ($txn->tnx_type === Constant::TRANSACTION_TYPE['product_seles']) {
                        $newSales = max(0, ($user->sales_amount ?? 0) - $txn->credit);
                        $user->sales_amount = $newSales;
                    } elseif ($txn->tnx_type === Constant::TRANSACTION_TYPE['reseller_seles_commission']) {
                        $newReseller = max(0, ($user->reseller_commission_amount ?? 0) - $txn->credit);
                        $user->reseller_commission_amount = $newReseller;
                    }

                    $user->save();
                }

                // Create reversal transaction
                Transaction::create([
                    'user_id'      => $txn->user_id,
                    'from_user_id' => $txn->from_user_id,
                    'wallet_type'  => $txn->wallet_type,
                    'tnx_type'     => $txn->tnx_type,
                    'credit'       => 0,
                    'debit'        => $txn->credit,
                    'note'         => 'Commission Reversed — Order Cancelled/Returned: ' . ($orderData->order_no ?? $orderData->id),
                    'description'  => $txn->description,
                    'status'       => Constant::STATUS['approved'],
                    'in_status'    => Constant::IN_STATUS['active'],
                    'date'         => $dateTime,
                ]);
            }
        }

        Log::info('Commissions reversed for order', [
            'order_id'    => $orderData->id,
            'reversed'    => $transactions->count(),
        ]);
    }

    // ── Helper methods ────────────────────────────────────────────────

    public function get_per_item_discount($order_data, $item_count)
    {
        if (!empty($order_data->coupon_discount) && $order_data->coupon_discount > 0) {
            return (float)(($order_data->coupon_discount / max(1, $item_count)));
        }
        return 0.0;
    }

    public function get_order_items($orderItems)
    {
        $itemCount  = 0;
        $resultData = [];

        foreach ($orderItems as $item) {
            $resellerCommission = 0;
            if ($item->reseller_id) {
                $reseller = $item->reseller;
                if ($reseller && $reseller->commission) {
                    $resellerCommission = (float)$reseller->commission;
                }
            }

            $itemCount++;
            $resultData[] = [
                'id'                  => $item->id,
                'order_id'            => $item->order_id,
                'order_no'            => $item->order->order_no ?? '',
                'product_id'          => $item->product_id,
                'user_id'             => $item->order->user_id ?? null,
                'vendor_id'           => $item->vendor_id,
                'reseller_id'         => $item->reseller_id,
                'reseller_commission' => $resellerCommission,
                'quantity'            => $item->quantity,
                'buy_price'           => (float)$item->buy_price,
                'sell_price'          => (float)$item->sell_price,
            ];
        }

        return ['count' => $itemCount, 'data' => $resultData];
    }

    public function get_distribution_data($orderItems, $item_per_discount)
    {
        // Legacy method — kept for compatibility
        return [];
    }
}