<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddDefaultCategories extends Migration
{
    public function up()
    {
        $existing = DB::table('categories')->count();
        if ($existing >= 10) return; // Already has enough categories

        $now = now();
        $categories = [
            // ── Fashion & Clothing ──────────────────────────
            ['name'=>'Fashion',        'name_bn'=>'ফ্যাশন',          'cat_slug'=>'fashion',        'cat_icon'=>'👗'],
            ['name'=>'Men\'s Fashion',  'name_bn'=>'পুরুষ পোশাক',     'cat_slug'=>'mens-fashion',   'cat_icon'=>'👔'],
            ['name'=>'Kids Fashion',   'name_bn'=>'শিশু পোশাক',      'cat_slug'=>'kids-fashion',   'cat_icon'=>'👶'],
            // ── Beauty & Health ──────────────────────────────
            ['name'=>'Beauty',         'name_bn'=>'বিউটি',            'cat_slug'=>'beauty',         'cat_icon'=>'💄'],
            ['name'=>'Health',         'name_bn'=>'স্বাস্থ্য',         'cat_slug'=>'health',         'cat_icon'=>'💊'],
            ['name'=>'Perfume',        'name_bn'=>'পারফিউম',          'cat_slug'=>'perfume',        'cat_icon'=>'🌸'],
            // ── Electronics ─────────────────────────────────
            ['name'=>'Electronics',   'name_bn'=>'ইলেকট্রনিক্স',     'cat_slug'=>'electronics',    'cat_icon'=>'📱'],
            ['name'=>'Accessories',   'name_bn'=>'এক্সেসরিজ',        'cat_slug'=>'accessories',    'cat_icon'=>'⌚'],
            // ── Home & Living ────────────────────────────────
            ['name'=>'Home & Living', 'name_bn'=>'হোম ও লিভিং',    'cat_slug'=>'home-living',    'cat_icon'=>'🏠'],
            ['name'=>'Kitchen',       'name_bn'=>'কিচেন',            'cat_slug'=>'kitchen',        'cat_icon'=>'🍳'],
            // ── Footwear ─────────────────────────────────────
            ['name'=>'Footwear',      'name_bn'=>'ফুটওয়্যার',        'cat_slug'=>'footwear',       'cat_icon'=>'👟'],
            // ── Bags & Jewelry ───────────────────────────────
            ['name'=>'Bags',          'name_bn'=>'ব্যাগ',             'cat_slug'=>'bags',           'cat_icon'=>'👜'],
            ['name'=>'Jewelry',       'name_bn'=>'গহনা',              'cat_slug'=>'jewelry',        'cat_icon'=>'💍'],
            // ── Books & Education ────────────────────────────
            ['name'=>'Books',         'name_bn'=>'বই',               'cat_slug'=>'books',          'cat_icon'=>'📚'],
            ['name'=>'Stationery',    'name_bn'=>'স্টেশনারি',         'cat_slug'=>'stationery',     'cat_icon'=>'✏️'],
            // ── Sports & Toys ────────────────────────────────
            ['name'=>'Sports',        'name_bn'=>'স্পোর্টস',          'cat_slug'=>'sports',         'cat_icon'=>'⚽'],
            ['name'=>'Toys & Games',  'name_bn'=>'খেলনা',            'cat_slug'=>'toys-games',     'cat_icon'=>'🧸'],
            // ── Food & Grocery ───────────────────────────────
            ['name'=>'Food & Grocery','name_bn'=>'খাদ্যপণ্য',         'cat_slug'=>'food-grocery',   'cat_icon'=>'🍎'],
            ['name'=>'Organic Food',  'name_bn'=>'অর্গানিক ফুড',     'cat_slug'=>'organic-food',   'cat_icon'=>'🥦'],
            // ── Other ────────────────────────────────────────
            ['name'=>'Automotive',    'name_bn'=>'অটোমোটিভ',         'cat_slug'=>'automotive',     'cat_icon'=>'🚗'],
            ['name'=>'Pet Supplies',  'name_bn'=>'পোষা প্রাণী',       'cat_slug'=>'pet-supplies',   'cat_icon'=>'🐾'],
            ['name'=>'Office',        'name_bn'=>'অফিস সামগ্রী',      'cat_slug'=>'office',         'cat_icon'=>'🖥️'],
            ['name'=>'Garden',        'name_bn'=>'গার্ডেন',           'cat_slug'=>'garden',         'cat_icon'=>'🌱'],
            ['name'=>'Travel',        'name_bn'=>'ট্রাভেল',           'cat_slug'=>'travel',         'cat_icon'=>'✈️'],
            ['name'=>'Baby & Mom',    'name_bn'=>'শিশু ও মা',        'cat_slug'=>'baby-mom',       'cat_icon'=>'🍼'],
        ];

        foreach ($categories as $cat) {
            // Skip if slug already exists
            if (DB::table('categories')->where('cat_slug', $cat['cat_slug'])->exists()) continue;

            DB::table('categories')->insert([
                'name'       => $cat['name'],
                'name_bn'    => $cat['name_bn'],
                'cat_slug'   => $cat['cat_slug'],
                'cat_icon'   => $cat['cat_icon'],
                'is_show'    => 1,
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down()
    {
        $slugs = ['fashion','mens-fashion','kids-fashion','beauty','health','perfume',
                  'electronics','accessories','home-living','kitchen','footwear','bags',
                  'jewelry','books','stationery','sports','toys-games','food-grocery',
                  'organic-food','automotive','pet-supplies','office','garden','travel','baby-mom'];
        DB::table('categories')->whereIn('cat_slug', $slugs)->delete();
    }
}
