<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\File; 

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file manually';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $baseUrl = 'https://usupershop.com';
        // Ensure trailing slash is handled or cleaned
        $baseUrl = rtrim($baseUrl, '/');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<?xml-stylesheet type="text/xsl" href="sitemap.xsl"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Helper to add url
        $addUrl = function($path, $priority = '0.8', $freq = 'daily') use (&$xml, $baseUrl) {
            $url = $baseUrl . $path;
            $date = date('Y-m-d\TH:i:sP');
            $xml .= '<url>';
            $xml .= "<loc>{$url}</loc>";
            $xml .= "<lastmod>{$date}</lastmod>";
            $xml .= "<changefreq>{$freq}</changefreq>";
            $xml .= "<priority>{$priority}</priority>";
            $xml .= '</url>';
        };

        // Static Pages
        $addUrl('/', '1.0', 'daily');
        $addUrl('/about-us', '0.8', 'monthly');
        $addUrl('/contact-us', '0.8', 'monthly');
        $addUrl('/product-list', '0.9', 'daily');
        $addUrl('/hot-deals', '0.9', 'daily');
        $addUrl('/speacial-offers', '0.9', 'daily');
        $addUrl('/seller/signup', '0.8', 'monthly'); // Reach more sellers

        // Products
        $this->info('Adding products...');
        Product::where('status', 1)->chunk(100, function ($products) use ($addUrl) {
            foreach ($products as $product) {
                $addUrl("/product-details/{$product->slug}", '0.9', 'weekly');
            }
        });

        // Categories
        $this->info('Adding categories...');
        Category::all()->each(function (Category $category) use ($addUrl) {
           $addUrl("/category-wise-product/{$category->id}", '0.8', 'weekly');
        });

        // Brands
        $this->info('Adding brands...');
        Brand::all()->each(function (Brand $brand) use ($addUrl) {
           $addUrl("/brand-wise-product/{$brand->id}", '0.7', 'weekly');
        });
        
         // Dynamic Pages (Privacy Policy, Return Policy, Terms)
        $addUrl('/privacy-policy', '0.5', 'yearly');
        $addUrl('/return-policy', '0.5', 'yearly');
        $addUrl('/terms-and-condition', '0.5', 'yearly');

        $xml .= '</urlset>';

        File::put(base_path('sitemap.xml'), $xml);
        File::put(public_path('sitemap.xml'), $xml);

        $this->info('Sitemap generated successfully at ' . base_path('sitemap.xml') . ' and ' . public_path('sitemap.xml'));
        return 0;
    }
}
