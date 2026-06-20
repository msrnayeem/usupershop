<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'color_id', 
        'size_id',
        'additional_price',
        'stock_quantity',
        'sku',
        'status'
    ];

    protected $casts = [
        'additional_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'status' => 'integer',
    ];

    /**
     * Get the product that owns this variant
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the color of this variant
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Get the size of this variant
     */
    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    /**
     * Get the final price for this variant (base price + additional price)
     */
    public function getFinalPriceAttribute()
    {
        return $this->product->price + $this->additional_price;
    }

    /**
     * Get the final trade price for this variant 
     */
    public function getFinalTradePriceAttribute()
    {
        return $this->product->trade_price + $this->additional_price;
    }

    /**
     * Check if variant is in stock
     */
    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Scope for active variants
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope for variants with stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }
}