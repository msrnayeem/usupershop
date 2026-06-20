<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropshipperProductPrice extends Model
{
    protected $fillable = [
        'dropshipper_id',
        'product_id',
        'selling_price'
    ];

    public function dropshipper()
    {
        return $this->belongsTo(User::class, 'dropshipper_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}