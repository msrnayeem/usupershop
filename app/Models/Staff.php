<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'user_id', 'role', 'permissions', 'is_active', 'created_by',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    // ── Available permission modules ───────────────────────────────────
    public const MODULES = [
        'orders'       => ['label' => '📋 Order Management',     'routes' => ['orders.']],
        'products'     => ['label' => '📦 Product Management',   'routes' => ['products.']],
        'wallets'      => ['label' => '💰 Wallet Management',    'routes' => ['wallets.']],
        'sellers'      => ['label' => '🏪 Seller Management',    'routes' => ['sellers.']],
        'vendors'      => ['label' => '🏭 Vendor Management',    'routes' => ['vendors.']],
        'dropshippers' => ['label' => '🚀 Dropshipper Management','routes' => ['dropshippers.']],
        'customers'    => ['label' => '👥 Customer Management',  'routes' => ['customers.', 'users.']],
        'categories'   => ['label' => '🏷️ Category Management',  'routes' => ['categories.', 'subcategories.', 'brands.', 'colors.', 'sizes.']],
        'coupons'      => ['label' => '🎟️ Coupon Management',    'routes' => ['coupons.']],
        'reports'      => ['label' => '📊 Reports & Analytics',  'routes' => ['reports.']],
        'sliders'      => ['label' => '🖼️ Slider & Banner',      'routes' => ['sliders.', 'banners.']],
        'settings'     => ['label' => '⚙️ Site Settings',         'routes' => ['settings.', 'smsgateways.', 'logos.']],
    ];

    // ── Relationships ──────────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ── Check if staff has permission for a module ─────────────────────
    public function hasPermission(string $module): bool
    {
        if (empty($this->permissions)) return false;
        return in_array($module, $this->permissions);
    }

    // ── Check if staff can access a route ─────────────────────────────
    public function canAccessRoute(string $routeName): bool
    {
        if (empty($this->permissions)) return false;
        foreach ($this->permissions as $module) {
            if (!isset(self::MODULES[$module])) continue;
            foreach (self::MODULES[$module]['routes'] as $prefix) {
                if (str_starts_with($routeName, $prefix)) return true;
            }
        }
        // Always allow dashboard home
        if (in_array($routeName, ['home', 'adminlogin.logout', 'profiles.'])) return true;
        return false;
    }
}
