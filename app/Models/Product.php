<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'brand_id',
        'quantity',
        'user_id',
        'name',
        'name_bn',
        'sku',
        'slug',
        'unit',
        'country_id',
        'trade_price',
        'price',
        'discount_type',
        'discount',
        'short_desc',
        'short_desc_bn',
        'long_desc',
        'image',
        'hot_deals',
        'featured',
        'sale_price',
        'special_offer',
        'special_deals',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function origin()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    static function queryBuild($columns)
    {
        $search = request()->input('search.value', '') ?? null; // safe access
        $accountType = request()->input('customFilter.category_id', '') ?? null;

        // Start query
        $Query = self::query();

        // Filter by category if provided
        if (!empty($accountType)) {
            $Query->where('category_id', $accountType);
        }

        // Search filter
        if (!empty($search)) {
            $Query->where(function ($q) use ($columns, $search) {
                $i = 0;
                foreach ($columns as $item) {
                    if (isset($item['searchable']) && $item['searchable'] === 'true') {
                        if ($i === 0) {
                            $q->where($item['name'], 'LIKE', '%' . $search . '%');
                        } else {
                            $q->orWhere($item['name'], 'LIKE', '%' . $search . '%');
                        }
                        $i++;
                    }
                }
            });
        }

        return $Query;
    }


    static function getPendingResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns)->where('status', 2);
        if ($length > 0) {
            $Q->skip($start)->take($length);
        }
        return $Q->get();
    }

    static function getInactiveResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns)->where('status', 0);
        if ($length > 0) {
            $Q->skip($start)->take($length);
        }
        return $Q->get();
    }


    static function queryBuildVEndor($columns)
    {
        // Use null coalescing operator to safely access array keys
        $search = request()->input('search.value', '') ?? null;
        $accountType = request()->input('customFilter.category_id', '') ?? null;

        $Query = self::where('user_id', auth()->user()->id); // Always filter by user_id

        if (!empty($accountType)) {
            $Query->where('category_id', $accountType);
        }

        if (!empty($search)) {
            $Query->where(function ($q) use ($columns, $search) {
                $i = 0;
                foreach ($columns as $item) {
                    if (isset($item['searchable']) && $item['searchable'] === 'true') {
                        if ($i === 0) {
                            $q->where($item['name'], 'LIKE', '%' . $search . '%');
                        } else {
                            $q->orWhere($item['name'], 'LIKE', '%' . $search . '%');
                        }
                        $i++;
                    }
                }
            });
        }

        return $Query;
    }


    static function getResult($start, $length, $columns)
    {
        $Q = self::queryBuild($columns);

        // Apply pagination only if length is positive
        if ($length > 0) {
            $Q->skip($start)->take($length); // skip = offset, take = limit
        }

        return $Q->get();
    }



    static function getvendorResult($start, $length, $columns)
    {
        $Q = self::queryBuildVEndor($columns);

        if (!$Q) {
            $Q = self::query(); // fallback query
        }

        // Apply pagination only if $length > 0
        if ($length > 0) {
            $Q = $Q->skip($start)->take($length); // skip = offset, take = limit
        }

        return $Q->get();
    }

    static function countResult($columns, $status = null)
    {
        $Q = self::queryBuild($columns);
        if ($status !== null) {
            $Q->where('status', $status);
        }
        return $Q->count();
    }

    public function product_colors()
    {
        return $this->hasMany(ProductColor::class, 'product_id', 'id');
    }
    public function product_sizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_product');
    }



    /**
     * Get active variants of this product
     */
    public function activeVariants()
    {
        return $this->hasMany(ProductVariant::class)->where('status', 1);
    }

    /**
     * Get variants that are in stock
     */
    public function inStockVariants()
    {
        return $this->hasMany(ProductVariant::class)->where('stock_quantity', '>', 0);
    }

    /**
     * Get the cheapest variant price
     */
    public function getCheapestVariantPriceAttribute()
    {
        $cheapestVariant = $this->variants()->orderBy('additional_price', 'asc')->first();
        return $cheapestVariant ? ($this->price + $cheapestVariant->additional_price) : $this->price;
    }

    /**
     * Get the most expensive variant price
     */
    public function getMostExpensiveVariantPriceAttribute()
    {
        $expensiveVariant = $this->variants()->orderBy('additional_price', 'desc')->first();
        return $expensiveVariant ? ($this->price + $expensiveVariant->additional_price) : $this->price;
    }

    /**
     * Get total stock from all variants
     */
    public function getTotalVariantStockAttribute()
    {
        return $this->variants()->sum('stock_quantity');
    }

    /**
     * Check if product has any variant in stock
     */
    public function hasVariantsInStock()
    {
        return $this->variants()->where('stock_quantity', '>', 0)->exists();
    }

    /**
     * Get variant by color and size
     */
    public function getVariant($colorId, $sizeId)
    {
        return $this->variants()->where('color_id', $colorId)->where('size_id', $sizeId)->first();
    }

    /**
     * Get available colors for this product (from variants)
     */
    public function getAvailableColors()
    {
        return $this->variants()->with('color')->get()->pluck('color')->unique('id');
    }

    /**
     * Get available sizes for this product (from variants)
     */
    public function getAvailableSizes()
    {
        return $this->variants()->with('size')->get()->pluck('size')->unique('id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

}
