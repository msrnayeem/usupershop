<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    static function queryBuild($columns)
    {
        $search = strip_tags(htmlspecialchars(request()->input('search.value', ''), ENT_QUOTES, 'UTF-8'));
        $Query = null;
        $i = 0;

        $$1 = strip_tags(request()->input('customFilter.$2', ''));
        if (!empty($accountType)) {
            $Query = self::where('promoCode', $accountType);
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

    static function getResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns);

        if ($Q == null) {
            return self::limit($length)->offset($start)->get();
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
    
     public function products()
    {
        return $this->belongsToMany(Product::class, 'coupon_product');
    }
}