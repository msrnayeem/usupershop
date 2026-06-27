<?php

namespace App\Models;

use App\Models\DeliveryZone;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'shipping_id',
        'payment_id',
        'area_id',
        'order_no',
        'coupon_discount',
        'order_total',
        'grand_total',
        'delivery_charge',
        'status',
        'confirmed_at',
        'packaging_at',
        'shipment_at',
        'delivered_at',
        'returned_at',
        'canceled_at',
        'shop_id',
        'invoice_no',
        'order_payment',
        'tran_id',
        'pay_method',
        'courier_id',
        'courier_id',
        'courier_priority',
        'courier_notes',
        'courier_tracking_id',
        'courier_response',
        'courier_assigned_at',
        'courier_assigned_by',
        'dropshipper_id',
        'dropshipper_profit'
    ];
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id', 'id');
    }
    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
    public function area()
    {
        return $this->belongsTo(DeliveryZone::class, 'area_id', 'id');
    }

    public function shop()
    {
        return $this->belongsTo(User::class, 'shop_id', 'id');
    }

    static function queryBuild($columns)
    {
        $search = strip_tags(htmlspecialchars(request()->input('search.value', ''), ENT_QUOTES, 'UTF-8'));
        $Query = null;
        $i = 0;
        $src_from = preg_replace('/[^0-9\-]/', '', request()->input('customFilter.src_from', ''));
        $src_to = preg_replace('/[^0-9\-]/', '', request()->input('customFilter.src_to', ''));
        if (!empty($src_from) && !empty($src_to)) {
            $Query = self::whereBetween('created_at', [$src_from . " 00:00:00", $src_to . " 23:59:59"]);
        }
        $status = strip_tags(request()->input('customFilter.status', ''));
        if (!empty($status)) {
            $Query = self::where('status', $status);
        }
        if (!empty($search)) {
            foreach ($columns as $item) {
                if ($item['searchable'] == "true") {
                    if ($i === 0) // first loop
                    {
                        $Query = self::where($item['name'], 'LIKE', '%' . $search . '%');
                    } else {
                        $Query->orWhere($item['name'], 'LIKE', '%' . $search . '%');
                    }
                    $i++;
                }
            }
        }
        return $Query;
    }

    static function queryBuild2($columns)
    {
        $search = strip_tags(htmlspecialchars(request()->input('search.value', ''), ENT_QUOTES, 'UTF-8'));
        $Query = null;
        $i = 0;
        if (!empty($search)) {
            foreach ($columns as $item) {
                if ($item['searchable'] == "true") {
                    if ($i === 0) // first loop
                    {
                        $Query = self::where($item['name'], 'LIKE', '%' . $search . '%');
                    } else {
                        $Query->orWhere($item['name'], 'LIKE', '%' . $search . '%');
                    }
                    $i++;
                }
            }
        }
        return $Query;
    }
    static function queryBuild3($columns)
    {
        $search = strip_tags(htmlspecialchars(request()->input('search.value', ''), ENT_QUOTES, 'UTF-8'));
        $Query = null;
        $i = 0;
        if (!empty($search)) {
            foreach ($columns as $item) {
                if ($item['searchable'] == "true") {
                    if ($i === 0) // first loop
                    {
                        $Query = self::where($item['name'], 'LIKE', '%' . $search . '%');
                    } else {
                        $Query->orWhere($item['name'], 'LIKE', '%' . $search . '%');
                    }
                    $i++;
                }
            }
        }
        return $Query;
    }
    static function queryBuildSeller($columns)
    {
        $search = strip_tags(htmlspecialchars(request()->input('search.value', ''), ENT_QUOTES, 'UTF-8'));
        $Query = null;
        $i = 0;

        $src_from = preg_replace('/[^0-9\-]/', '', request()->input('customFilter.src_from', ''));
        /* if (!empty($src_from)) {
            $Query = self::where('created_at', $src_from);
        } */

        $src_to = preg_replace('/[^0-9\-]/', '', request()->input('customFilter.src_to', ''));
        /* if (!empty($src_to)) {
            $Query = self::where('created_at', $src_to);
        } */

        if (!empty($src_from) && !empty($src_to)) {
            $Query = self::whereBetween('created_at', [$src_from . " 00:00:00", $src_to . " 23:59:59"]);
        }

        $d_status = strip_tags(request()->input('customFilter.d_status', ''));
        if (!empty($d_status)) {
            $Query = self::where('status', $d_status);
        }

        $shop_name = strip_tags(htmlspecialchars(request()->input('customFilter.shop_name', ''), ENT_QUOTES, 'UTF-8'));
        if (!empty($shop_name)) {
            $Query = self::where('shop_id', $shop_name);
        }

        if (!empty($search)) {
            foreach ($columns as $item) {

                if ($item['searchable'] == "true") {
                    if ($i === 0) // first loop
                    {
                        $Query = self::where($item['name'], 'LIKE', '%' . $search . '%');
                    } else {
                        $Query->orWhere($item['name'], 'LIKE', '%' . $search . '%');
                    }
                    $i++;
                }
            }
        }

        return $Query;
    }

    static function getPendingResult($start, $length, $columns)
    {
        $Q = self::queryBuild2($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)->where('status', 'pending')->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }
    static function getDropshipperPendingResult($start, $length, $columns)
    {
        $Q = self::queryBuild2($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)->where('dropshipper_id', auth()->id())->where('status', 'pending')->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }
    static function getDropshipperDeliveredResult($start, $length, $columns)
    {
        $Q = self::queryBuild2($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)->where('dropshipper_id', auth()->id())->where('status', 'delivered')->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }
    static function getDeliveredResult($start, $length, $columns)
    {
        $Q = self::queryBuild2($columns);
        if ($Q == null) {
            return self::limit($length)->offset($start)->where('status', 'delivered')->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }

    static function getResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns);
        if ($Q == null) {
            if ($length != -1) {
                return self::limit($length)->offset($start)->where('status', '!=', 'delivered')->get();
            } else {
                return self::get();
            }
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }

    static function getSellerPendingResult($start, $length, $columns)
    {
        $Q = self::queryBuild2($columns);
        if ($Q == null) {
            return self::limit($length)->offset($start)->where('status', 'pending')->where('shop_id', '!=', 'null')->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }
    static function getSellerDeliveredResult($start, $length, $columns)
    {
        $Q = self::queryBuild2($columns);
        if ($Q == null) {
            return self::limit($length)->offset($start)->where('status', 'delivered')->where('shop_id', '!=', 'null')->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }

    static function getSellerApprovedResult($start, $length, $columns)
    {
        $Q = self::queryBuild2($columns);
        if ($Q == null) {
            return self::limit($length)->offset($start)->where('status', 'delivered')->where('shop_id', '!=', 'null')->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }

    static function getSellerCancelResult($start, $length, $columns)
    {
        $Q = self::queryBuild2($columns);
        if ($Q == null) {
            return self::limit($length)->offset($start)->where('status', 'canceled')->where('shop_id', '!=', 'null')->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }

    static function getSellerReturnResult($start, $length, $columns)
    {
        $Q = self::queryBuild2($columns);
        if ($Q == null) {
            return self::limit($length)->offset($start)->where('status', 'return')->where('shop_id', '!=', 'null')->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }

    static function countResult($columns)
    {
        $Q = self::queryBuild2($columns);
        if ($Q == null) {
            return self::where('status', 'pending')->count();
        } else {
            return $Q->where('status', 'pending')->count();
        }
    }

    static function countResultTotal($columns)
    {
        $Q = self::queryBuild($columns);
        if ($Q == null) {
            return self::count();
        } else {
            return $Q->count();
        }
    }

    /**
     * Get the user who assigned the courier
     */
    public function courierAssignedBy()
    {
        return $this->belongsTo(User::class, 'courier_assigned_by');
    }

    /**
     * Get courier display name
     */
    public function getCourierDisplayNameAttribute()
    {
        if (!$this->courier_id) {
            return null;
        }

        $couriers = [
            'steadfast' => 'Steadfast',
            'pathao' => 'Pathao',
            'redx' => 'RedX',
            'sa_paribahan' => 'SA Paribahan',
            'sundarban' => 'Sundarban',
            'karatoa' => 'Karatoa'
        ];

        return $couriers[$this->courier_id] ?? ucfirst(str_replace('_', ' ', $this->courier_id));
    }

    /**
     * Check if order is assigned to courier
     */
    public function isAssignedToCourier()
    {
        return !empty($this->courier_id);
    }

    /**
     * Scope for orders assigned to courier
     */
    public function scopeAssignedToCourier($query)
    {
        return $query->whereNotNull('courier_id');
    }

    /**
     * Scope for orders not assigned to courier
     */
    public function scopeNotAssignedToCourier($query)
    {
        return $query->whereNull('courier_id');
    }

    public function dropshipper()
    {
        return $this->belongsTo(User::class, 'dropshipper_id');
    }

    public function dropshipperProfit()
    {
        return $this->hasOne(DropshipperProfit::class, 'order_id');
    }

    /**
     * Get dropshipper orders by status
     */
    static function getDropshipperOrderList($start, $length, $columns, $status)
    {
        $Q = self::queryBuild2($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)
                ->where('dropshipper_id', auth()->id())
                ->where('status', $status)
                ->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->where('dropshipper_id', auth()->id())
                ->where('status', $status)
                ->get();
        }
    }

    /**
     * Get seller orders by status
     */
    static function getSellerOrderList($start, $length, $columns, $status)
    {
        $Q = self::queryBuild2($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)
                ->where('shop_id', auth()->id())
                ->where('status', $status)
                ->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->where('shop_id', auth()->id())
                ->where('status', $status)
                ->get();
        }
    }

    /**
     * Get dropshipper cancelled orders
     */
    static function getDropshipperCancelResult($start, $length, $columns)
    {
        $Q = self::queryBuild2($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)
                ->where('dropshipper_id', auth()->id())
                ->where('status', 'cancel')
                ->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->where('dropshipper_id', auth()->id())
                ->where('status', 'cancel')
                ->get();
        }
    }

    /**
     * Get dropshipper returned orders
     */
    static function getDropshipperReturnResult($start, $length, $columns)
    {
        $Q = self::queryBuild2($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)
                ->where('dropshipper_id', auth()->id())
                ->where('status', 'return')
                ->get();
        } else {
            if ($length != -1)
                $Q->limit($length)->offset($start);
            return $Q->where('dropshipper_id', auth()->id())
                ->where('status', 'return')
                ->get();
        }
    }

}