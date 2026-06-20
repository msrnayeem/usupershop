<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropshipperProfit extends Model
{
    protected $fillable = [
        'dropshipper_id',
        'order_id',
        'total_profit',
        'status',   // pending | paid | reversed
        'paid_at'
    ];

    protected $dates = ['paid_at'];

    public function dropshipper()
    {
        return $this->belongsTo(User::class, 'dropshipper_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
