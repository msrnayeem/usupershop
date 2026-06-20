<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index()
    {
        $baseUrl = 'https://usuper.shop';
        
        // Cache sitemap for 30 minutes to avoid DB overload
        $cacheKey = 'sitemap_xml_v2';
        if (Cache::has($cacheKey)) {
            return response(Cache::get($cacheKey), 200)
                ->header('Content-Type', 'application/xml')
                ->header('Cache-Control', 'public, max-age=1800');
        }
        $now = now()->toAtomString();

        // Static pages
        $staticPages = [
            ['url' => $baseUrl . '/',                      'freq' => 'daily',   'priority' => '1.0'],
            ['url' => $baseUrl . '/product-list',          'freq' => 'daily',   'priority' => '0.9'],
            ['url' => $baseUrl . '/hot-deals',             'freq' => 'daily',   'priority' => '0.9'],
            ['url' => $baseUrl . '/speacial-offers',       'freq' => 'daily',   'priority' => '0.9'],
            ['url' => $baseUrl . '/about-us',              'freq' => 'monthly', 'priority' => '0.7'],
            ['url' => $baseUrl . '/contact-us',            'freq' => 'monthly', 'priority' => '0.7'],
            ['url' => $baseUrl . '/pricing',               'freq' => 'monthly', 'priority' => '0.8'],
            ['url' => $baseUrl . '/privacy-policy',        'freq' => 'yearly',  'priority' => '0.4'],
            ['url' => $baseUrl . '/return-policy',         'freq' => 'yearly',  'priority' => '0.4'],
            ['url' => $baseUrl . '/terms-and-condition',   'freq' => 'yearly',  'priority' => '0.4'],
            ['url' => $baseUrl . '/seller/signup',         'freq' => 'monthly', 'priority' => '0.8'],
            ['url' => $baseUrl . '/customer-signup',       'freq' => 'monthly', 'priority' => '0.6'],
        ];

        // Live products from DB
        $products = Product::select('slug', 'updated_at')
            ->where('status', 1)
            ->whereNotNull('slug')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Live categories from DB
        $categories = Category::select('id', 'updated_at')
            ->where('status', 1)
            ->get();

        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        // Static pages
        foreach ($staticPages as $page) {
            $content .= "  <url>\n";
            $content .= "    <loc>{$page['url']}</loc>\n";
            $content .= "    <lastmod>{$now}</lastmod>\n";
            $content .= "    <changefreq>{$page['freq']}</changefreq>\n";
            $content .= "    <priority>{$page['priority']}</priority>\n";
            $content .= "  </url>\n";
        }

        // Product pages (with image sitemap)
        foreach ($products as $product) {
            $productUrl = $baseUrl . '/product-details/' . urlencode($product->slug);
            $lastmod = $product->updated_at ? $product->updated_at->toAtomString() : $now;
            $content .= "  <url>\n";
            $content .= "    <loc>{$productUrl}</loc>\n";
            $content .= "    <lastmod>{$lastmod}</lastmod>\n";
            $content .= "    <changefreq>weekly</changefreq>\n";
            $content .= "    <priority>0.9</priority>\n";
            if (!empty($product->image)) {
                $imgUrl = $baseUrl . '/upload/product_images/' . $product->image;
                $imgTitle = htmlspecialchars($product->name ?? '');
                $content .= "    <image:image>\n";
                $content .= "      <image:loc>{$imgUrl}</image:loc>\n";
                $content .= "      <image:title>{$imgTitle}</image:title>\n";
                $content .= "    </image:image>\n";
            }
            $content .= "  </url>\n";
        }

        // Category pages
        foreach ($categories as $category) {
            $categoryUrl = $baseUrl . '/category-wise-product/' . $category->id;
            $lastmod = $category->updated_at ? $category->updated_at->toAtomString() : $now;
            $content .= "  <url>\n";
            $content .= "    <loc>{$categoryUrl}</loc>\n";
            $content .= "    <lastmod>{$lastmod}</lastmod>\n";
            $content .= "    <changefreq>weekly</changefreq>\n";
            $content .= "    <priority>0.8</priority>\n";
            $content .= "  </url>\n";
        }

        $content .= '</urlset>';

        Cache::put($cacheKey, $content, 1800); // 30 minutes
        
        return response($content, 200)
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'public, max-age=1800');
    }
}
