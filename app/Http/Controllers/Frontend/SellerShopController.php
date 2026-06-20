<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\About;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Communication;
use App\Models\Contact;
use App\Models\Division;
use App\Models\Logo;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductSubImage;
use App\Models\Slider;
use App\Models\MyShop;
use Illuminate\Support\Facades\DB;

class SellerShopController extends Controller
{
    public function shop(Request $request){
        $shopID=$request->segment(2);
        $data['shop_user'] = \App\Models\User::find($shopID);
        $data['refercode'] = $data['shop_user']->code ?? '';
        $data['shopID'] = $shopID;
        $data['sellershopcats'] =  DB::table('my_shops')->join('products', 'products.id', '=',
        'my_shops.product_id')->where('my_shops.user_id', $shopID)
        ->join('categories', 'products.category_id', '=', 
        'categories.id')->select('categories.name', 'categories.id', 
        'categories.name_bn', 'categories.cat_icon')->groupBy('categories.name', 
        'categories.id', 'categories.name_bn', 'categories.cat_icon')->distinct()->get();
        $data['allData'] = DB::table('my_shops')
        ->join('products', 'products.id', '=', 'my_shops.product_id')
        ->where('my_shops.user_id', $shopID)
        ->orderBy('my_shops.id', 'DESC')
        ->paginate(10);
        // dd($data['allData']);
        return view('frontend.seller_shop.seller_shop_view',$data);
       
    }

    public function sellerProductDetails($slug, $shopID){
        $data['shopID'] =  $shopID;
        //$data['hot_deals'] = Product::where('hot_deals', 1)->where('status', 1)->orderBy('id', 'DESC')->get();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $data['productDetails'] = Product::where('slug', $slug)->first();
        $brand_id = $data['productDetails']->brand_id;

        $data['hot_deals'] = DB::table('my_shops')
        ->join('products', 'products.id', '=', 'my_shops.product_id')
        ->where('my_shops.user_id', $shopID)
        ->inRandomOrder()
        ->where('products.hot_deals', 1)
        ->get();

        $data['relatedProduct'] = DB::table('my_shops')
        ->join('products', 'products.id', '=', 'my_shops.product_id')
        ->where('my_shops.user_id', $shopID)
        ->inRandomOrder()
        ->get();
        $data['product_sub_image'] = ProductSubImage::where('product_id', $data['productDetails']->id)->get();
        $data['product_color'] = ProductColor::where('product_id', $data['productDetails']->id)->get();
        $data['product_size'] = ProductSize::where('product_id', $data['productDetails']->id)->get();
        return view('frontend.seller_shop.seller_product_details', $data);
    }
    public function homepageShop($shopID)
    {
        $data['sliders'] = Slider::select('id', 'name', 'image')->orderBy('id', 'desc')->get();
        $data['shopID'] = $shopID;
        $data['shop_user'] = \App\Models\User::find($shopID);
        // If a shop ID is provided, include shop-specific data
        if (!empty($shopID)) {
            $data['shopCategories'] = DB::table('my_shops')->join('products', 'products.id', '=',
            'my_shops.product_id')->where('my_shops.user_id', $shopID)
            ->join('categories', 'products.category_id', '=', 
            'categories.id')->select('categories.name', 'categories.id', 
            'categories.name_bn', 'categories.cat_icon')->groupBy('categories.name', 
            'categories.id', 'categories.name_bn', 'categories.cat_icon')->distinct()->get();
            $data['hot_deals'] = DB::table('my_shops')
            ->join('products', 'products.id', '=', 'my_shops.product_id')
            ->where('my_shops.user_id', $shopID)
            ->where('products.hot_deals', 1)
            ->where('products.status', 1)
            ->orderBy('products.id', 'DESC') // Specify the table for the "id" column
            ->get();
            $data['featureds'] = DB::table('my_shops')
            ->join('products', 'products.id', '=', 'my_shops.product_id')
            ->where('my_shops.user_id', $shopID)
            ->where('products.featured', 1)
            ->where('products.status', 1)
            ->orderBy('products.id', 'DESC') // Specify the table for "id" here
            ->get();
         
            $data['special_offers'] =  DB::table('my_shops')->join('products', 'products.id',
            '=', 'my_shops.product_id')->where('products.special_offer', 1)->where('products.status', 1)
            ->where('my_shops.user_id', $shopID)->orderBy('products.id', 'DESC')->get();
        
            $data['special_deals'] = DB::table('my_shops')->join('products', 'products.id',
            '=', 'my_shops.product_id')->where('products.special_deals', 1)->where('products.status', 1)
            ->where('my_shops.user_id', $shopID)->orderBy('products.id', 'DESC')->get();
          
            $data['shopProducts'] = DB::table('my_shops')->join('products', 'products.id',
             '=', 'my_shops.product_id')->where('my_shops.user_id', $shopID)
             ->orderBy('products.id', 'DESC')->get();

             $data['allProducts'] = DB::table('my_shops')->join('products','products.id','=','my_shops.product_id')
             ->where('my_shops.user_id', $shopID)->select('products.id','products.category_id','products.brand_id',
            'products.name','products.name_bn','products.slug','products.country_id','products.price','products.discount_type',
            'products.discount','products.image')
            ->orderBy('products.id', 'DESC')->take(10)->get();
            return view('frontend.seller_shop.seller_shop_home', $data);
        }
       
      
    }
    public function ShopCategoryPage($shopID, $category_id) {
        // Both $shopID and $category_id are passed dynamically
        $data['category'] = Category::find($category_id);
        $data['shopID'] = request()->segment(2); 
        $data['shop_user'] = \App\Models\User::find($shopID);
        $data['products'] = DB::table('my_shops')
            ->join('products', 'products.id', '=', 'my_shops.product_id')
            ->where('products.category_id', '=', $category_id)
            ->where('my_shops.user_id', $shopID)
            ->orderBy('products.id', 'DESC')
            ->paginate(20);
        return view('frontend.single_page.shop-category-wise-product', $data);
    }
    
   
}
