<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'color_id', 'color_name', 'size_id', 'size_name', 'quantity', 'buy_price', 'dropshipper_sell_price','dropshipper_profit', 'sell_price', 'vendor_id', 'reseller_id'];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }

    public function product_color()
    {
        return $this->belongsTo(ProductColor::class, 'color_id', 'id');
    }

    public function product_size()
    {
        return $this->belongsTo(ProductSize::class, 'size_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function reseller()
    {
        return $this->belongsTo(User::class, 'reseller_id', 'id');
    }
}
