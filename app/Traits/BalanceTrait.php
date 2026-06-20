<?php
namespace App\Traits;

use App\Models\Transaction;
use App\Models\User;
use App\utilities\Constant;
use Helper;
use Illuminate\Support\Facades\DB;


trait BalanceTrait {
    public function get_user_balance($data) {
        return $data->balance ?? 0;
    }
    public function get_user_refer_commission($data) {
        return $data->refer_commission ?? 0;
    }

    public function get_vendor_product_sales_commission($data){
        return $data->sales_amount ?? 0;
    }
    public function get_reseller_sales_commission($data){
        return $data->reseller_commission_amount ?? 0;
    }

    public function get_vendor_status_wise_order_item_count($user_id, $status){
        $count = DB::table('order_details')
            ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.order_payment', 'Paid')
            ->where('orders.status', $status)
            ->where('order_details.vendor_id', $user_id)
            ->count();

        return $count ?? 0;
    }
    public function get_reseller_status_wise_order_item_count($user_id, $status){
        $count = DB::table('order_details')
            ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.order_payment', 'Paid')
            ->where('orders.status', $status)
            ->where('order_details.reseller_id', $user_id)
            ->count();

        return $count ?? 0;
    }
    // public function get_vendor_status_wise_order_item_count($data){
    //     $data = DB::table('order_details')
    //         ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
    //         ->where('orders.status', 'delivered')
    //         ->where('order_details.vendor_id', 4)
    //         ->select(
    //             'order_details.order_id as order_id',
    //             'order_details.product_id as product_id',
    //             'order_details.quantity as quantity',
    //             'order_details.sell_price as sell_price',
    //             'order_details.buy_price as buy_price',
    //             'order_details.vendor_id as vendor_id',
    //             'order_details.reseller_id as reseller_id',
    //             'orders.status as status'
    //         )
    //         ->get();
    // }
    
}
