<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionLedger extends Model
{
    use HasFactory;

    public function shop()
    {
        return $this->belongsTo(User::class, 'reseller_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    static function queryBuild($columns)
    {
        $search = strip_tags(htmlspecialchars(request()->input('search.value', ''), ENT_QUOTES, 'UTF-8'));
        $Query = null;
        $i = 0;

        /* $$1 = strip_tags(request()->input('customFilter.$2', ''));
        if (!empty($accountType)) {
            $Query = self::where('category_id', $accountType);
        } */

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

    /* ->selectRaw("SUM(debit) as total_debit")
    ->selectRaw("SUM(credit) as total_credit")
    ->groupBy('id') */
    static function getResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns);
        if ($Q == null) {
            if ($length != -1){
                return self::limit($length)->offset($start)->get();
            }else{
                return self::get();
            }
        } else {
            //$Q->orderBy("accountHolder", $_GET['order']['0']['dir']);
            if ($length != -1) $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }


    static function getSellerWiseResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns);
        if ($Q == null) {
            if ($length != -1){
                return self::limit($length)->offset($start)->groupBy('reseller_id')->selectRaw('reseller_id, sum(debit_balance) as total_debit, sum(credit_balance) as total_credit')->get();
            }else{
                return self::get();
            }
        } else {
            //$Q->orderBy("accountHolder", $_GET['order']['0']['dir']);
            if ($length != -1) $Q->limit($length)->offset($start);
            return $Q->get();
        }
    }

    static function countResult($columns)
    {
        $Q = self::queryBuild($columns);
        if ($Q == null) {
            return self::count();
        } else {
            return $Q->count();
        }
    }


    static function countSellerWiseResult($columns)
    {
        $Q = self::queryBuild($columns);
        if ($Q == null) {
            return self::count();
        } else {
            return $Q->count();
        }
    }
}