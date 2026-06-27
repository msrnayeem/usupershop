<?php

return [

    /*
    |──────────────────────────────────────────────────────────────────
    | U Super Shop — Performance Configuration
    |──────────────────────────────────────────────────────────────────
    |
    | These settings control caching, pagination, and load management.
    | Adjust based on your hosting plan.
    |
    */

    // ── Cache TTLs (seconds) ───────────────────────────────────────
    'cache' => [
        'homepage'        => env('HOMEPAGE_CACHE_TTL', 300),   // 5 min
        'product_detail'  => env('PRODUCT_CACHE_TTL', 3600),   // 1 hour
        'category_list'   => env('CATEGORY_CACHE_TTL', 1800),  // 30 min
        'settings'        => env('SETTINGS_CACHE_TTL', 86400), // 24 hours
        'slider'          => env('SLIDER_CACHE_TTL', 3600),    // 1 hour
    ],

    // ── Pagination Limits ──────────────────────────────────────────
    'pagination' => [
        'products_per_page'   => env('PRODUCTS_PER_PAGE', 20),
        'homepage_products'   => env('HP_PRODUCTS', 40),
        'hp_section_products' => env('HP_SECTION', 20), // hot deals etc
        'admin_per_page'      => env('ADMIN_PER_PAGE', 50),
        'orders_per_page'     => env('ORDERS_PER_PAGE', 30),
    ],

    // ── Image Settings ─────────────────────────────────────────────
    'images' => [
        'lazy_loading'     => true,
        'webp_support'     => true,
        'max_upload_size'  => env('MAX_IMAGE_MB', 2),  // MB
        'thumbnail_width'  => 400,
        'thumbnail_height' => 400,
    ],

    // ── Query Optimization ─────────────────────────────────────────
    'query' => [
        'slow_threshold_ms' => 100,   // log queries slower than 100ms
        'max_products_load' => 10000, // safety limit
    ],

];
