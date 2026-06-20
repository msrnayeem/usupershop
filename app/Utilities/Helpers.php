<?php

use App\Models\BannerImage;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Logo;
use App\Models\Product;
use App\Models\Setting;
use FontLib\Table\Type\fpgm;
use Illuminate\Support\Facades\DB;

class Helper
{
    //Get Product minimum value
    public static function minPrice()
    {
        return  floor(Product::where('status', 1)->min('price'));
    }

    //Get Product miximum value
    public static function maxPrice()
    {
        return  floor(Product::where('status', 1)->max('price'));
    }

    // Get Logo
    public static function getLogo()
    {
        return Logo::first();
    }

    // Get All Categories
    public static function getCategories()
    {
        return Product::select('category_id')->groupBy('category_id')->get();
    }
    public static function get_categories()
    {
        return Category::orderBy('id', 'DESC')->get();
    }

    // Get All Brands
    public static function getBrands()
    {
        return Product::select('brand_id')->groupBy('brand_id')->get();
    }
    public static function getdeliveryZone()
    {
        return DB::table('delivery_zones')->get();
    }
    public static function getfootercontacts()
    {
        return Contact::first();
    }
    public static function bannerImage(){
        return BannerImage::first();
    }

    public static function get_setting_data(){
        return Setting::find(1);
    }

    public static function percentage_amount($percentage, $type, $amount){
        if($type == 1){
            $amount = (($amount * $percentage) / 100);
        }
        else{
            $amount = $percentage;
        }

        return $amount;
    }

    public static function percentage($amount, $percentage){
        return (($amount * $percentage) / 100) ?? 0;
    }
    
   
   
}
