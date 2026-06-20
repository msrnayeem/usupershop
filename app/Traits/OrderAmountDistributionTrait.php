<?php
namespace App\Traits;

use App\Models\Transaction;
use App\Models\User;
use App\utilities\Constant;
use Helper;

trait OrderAmountDistributionTrait{
    public function order_amount_distribution($orderData){
        // Prevent duplicate commission distribution if order is already processed
        $alreadyProcessed = Transaction::where('from_user_id', $orderData->user_id)
            ->whereIn('tnx_type', [
                Constant::TRANSACTION_TYPE['product_seles'],
                Constant::TRANSACTION_TYPE['admin_sales_commission_amount'],
            ])
            ->whereRaw("description LIKE ?", ['%"order_id":"' . $orderData->id . '"%'])
            ->exists();

        if ($alreadyProcessed) {
            \Illuminate\Support\Facades\Log::info('Commission already distributed for order', ['order_id' => $orderData->id]);
            return true;
        }

        $orderItems = $this->get_order_items($orderData->order_details);
        $item_per_discount = $this->get_per_item_discount($orderData, $orderItems['count']);
        
        $distribution_data = $this->get_distribution_data($orderItems, $item_per_discount);
        $dateTime = time();
        
        $transactionData = [];
        foreach($distribution_data as $data){
            if ($data['vendor_id'] != null) {
                $vendor = User::find($data['vendor_id']);
                if ($vendor) {
                    $vendor->increment('sales_amount', $data['vendor_amount']);
                    $vendor->increment('balance', $data['vendor_amount']);

                    $transactionData[] = [
                        'user_id' => $data['vendor_id'],
                        'from_user_id' => $data['customer_id'],
                        'wallet_type' => Constant::WALLET_TYPE['balance_wallet'],
                        'tnx_type' => Constant::TRANSACTION_TYPE['product_seles'],
                        'credit' => $data['vendor_amount'],
                        'debit' => 0,
                        'note' => $data['vendor_commission'] . '% Product Sales from Order No : ' . $data['order_no'],
                        'description' => json_encode($data, true),
                        'status' => Constant::STATUS['approved'],
                        'in_status' => Constant::IN_STATUS['active'],
                        'date' => $dateTime,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if ($data['reseller_id'] != null) {
                $reseller = User::find($data['reseller_id']);
                if ($reseller) {
                    $reseller->increment('reseller_commission_amount', $data['reseller_commission_amount']);
                    $reseller->increment('balance', $data['reseller_commission_amount']);

                    $transactionData[] = [
                        'user_id' => $data['reseller_id'],
                        'from_user_id' => $data['customer_id'],
                        'wallet_type' => Constant::WALLET_TYPE['balance_wallet'],
                        'tnx_type' => Constant::TRANSACTION_TYPE['reseller_seles_commission'],
                        'credit' => $data['reseller_commission_amount'],
                        'debit' => 0,
                        'note' => $data['reseller_commission'] . '% Product Sales Commission from Order No : ' . $data['order_no'],
                        'description' => json_encode($data, true),
                        'status' => Constant::STATUS['approved'],
                        'in_status' => Constant::IN_STATUS['active'],
                        'date' => $dateTime,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            $transactionData[] = [
                'user_id' => 1,
                'from_user_id' => $data['customer_id'],
                'wallet_type' => Constant::WALLET_TYPE['admin_wallet'],
                'tnx_type' => Constant::TRANSACTION_TYPE['admin_sales_commission_amount'],
                'credit' => $data['admin_commission_amount'],
                'debit' => 0,
                'note' => $data['admin_commission'] . '% Product Sales Commission from Order No : ' . $data['order_no'],
                'description' => json_encode($data, true),
                'status' => Constant::STATUS['approved'],
                'in_status' => Constant::IN_STATUS['active'],
                'date' => $dateTime,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (!empty($transactionData)){
                Transaction::insert($transactionData);
            }
        }
        
        return true;
    }

    public function get_distribution_data($orderItems, $item_per_discount){
        $outputData = [];
        foreach($orderItems['data'] as $i => $item){
            $total_product_amount = ($item['sell_price'] * $item['quantity']) ?? 0;
            $amount_without_admin_commission = ($total_product_amount - $item_per_discount) ?? 0;
            $admin_commission = Constant::COMMISSION['admin_commission'];
            $vendor_commission = (100 - $admin_commission) ?? 0;

            $admin_commission_amount = Helper::percentage($amount_without_admin_commission, $admin_commission);

            $vendor_amount = ($amount_without_admin_commission - $admin_commission_amount) ?? 0;

            $reseller_commission_amount = Helper::percentage($admin_commission_amount, $item['reseller_commission']);

            $admin_commission_amount_after_reseller_commission = ($admin_commission_amount - $reseller_commission_amount) ?? 0;

            $outputData[] = [
                'item_id' => $item['id'],
                'order_id' => $item['order_id'],
                'order_no' => $item['order_no'],
                'product_id' => $item['product_id'],
                'customer_id' => $item['user_id'],
                'vendor_id' => $item['vendor_id'],
                'reseller_id' => $item['reseller_id'],
                'vendor_commission' => $vendor_commission,
                'reseller_commission' => $item['reseller_commission'],
                'admin_commission' => $admin_commission,
                'vendor_amount' => $vendor_amount,
                'reseller_commission_amount' => $reseller_commission_amount,
                'admin_commission_amount' => $admin_commission_amount_after_reseller_commission,
            ];
        }
        return $outputData;
    }

    public function get_per_item_discount($order_data, $item_count){
        if($order_data->coupon_discount > 0){
            return (float) (($order_data->coupon_discount / $item_count) ?? 00);
        }
        else{
            return (float) '0';
        }
    }

    public function get_order_items($orderItems){
        $item_count = 0;
        $result_data = [];
        foreach($orderItems as $item){

            $reseller_commission =  0;
            if($item->reseller_id != NULL){
                $reseller = $item->reseller;
                if($reseller){
                    if($reseller->commission != NULL){
                        $reseller_commission = $reseller->commission;
                    }
                }
            }

            $item_count++;
            $result_data[] = [
                'id' => $item->id,
                'order_id' => $item->order_id,
                'order_no' => $item->order->order_no,
                'product_id' => $item->product_id,
                'user_id' => $item->order->user_id,
                'vendor_id' => $item->vendor_id,
                'reseller_id' => $item->reseller_id,
                'reseller_commission' => $reseller_commission,
                'quantity' => $item->quantity,
                'buy_price' => (float) $item->buy_price,
                'sell_price' => (float) $item->sell_price,
            ];
        }

        return [
            'count' => $item_count,
            'data' => $result_data,
        ];
    }
}