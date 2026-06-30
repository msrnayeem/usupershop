<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Logo;
use App\Models\Page;
use App\Models\About;
use App\Models\Brand;
use App\Models\Slider;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Division;
use App\Models\BannerImage;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductVariant;
use App\Models\SellerFee;
use App\Rules\BdPhoneNumber;
use Illuminate\Http\Request;
use App\Models\Communication;
use App\Models\ProductSubImage;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    public function index()
    {
        // ── Cache homepage data for 10 minutes ───────────────────────
        // This prevents 20,000 users from each hitting the DB separately
        $cacheKey = 'homepage_data_v1';
        $data = \Illuminate\Support\Facades\Cache::remember($cacheKey, 600, function () {
            return $this->buildHomepageData();
        });
        return view('frontend.layouts.home', $data);
    }

    /**
     * Build homepage data — called once, then cached
     */
    private function buildHomepageData(): array
    {
        // ── All queries cached individually ─────────────────────────
        // Each cache key = 1 DB query shared across ALL concurrent users
        $ttl = (int)env('HOMEPAGE_CACHE_TTL', 300); // 5 min default


        $data['hot_deals'] = \Cache::remember('hp_hot_deals', $ttl, fn() => 
                Product::select('id','name','name_bn','slug','price','discount','discount_type','image')
                ->where('hot_deals', 1)->where('status', 1)->orderBy('id', 'DESC')->limit(20)->get());
        $data['featureds'] = \Cache::remember('hp_featured', $ttl, fn() => 
                Product::select('id','name','name_bn','slug','price','discount','discount_type','image')
                ->where('featured', 1)->where('status', 1)->orderBy('id', 'DESC')->limit(20)->get());
        $data['special_offers'] = \Cache::remember('hp_special_offers', $ttl, fn() => 
                Product::select('id','name','name_bn','slug','price','discount','discount_type','image')
                ->where('special_offer', 1)->where('status', 1)->orderBy('id', 'DESC')->limit(20)->get());
        $data['special_deals'] = \Cache::remember('hp_special_deals', $ttl, fn() => 
                Product::select('id','name','name_bn','slug','price','discount','discount_type','image')
                ->where('special_deals', 1)->where('status', 1)->orderBy('id', 'DESC')->limit(20)->get());

        // Sliders
        $data['sliders'] = Slider::select('id', 'name', 'image')->orderBy('id', 'desc')->get();

        // Latest products
        $data['allData'] = Product::select('id','status','category_id','name','name_bn','slug','price','discount_type','discount','image')
                ->where('status', 1)->orderBy('id', 'DESC')->limit(40)->get();

        // Categories with active products
        $categories = DB::table('categories')->select('categories.id', 'categories.name', 'categories.name_bn')->join('products', 'products.category_id', '=', 'categories.id')->where('products.status', 1)->groupBy('categories.id', 'categories.name', 'categories.name_bn')->orderBy('categories.id', 'DESC')->get();

        // Top selling products
        $top_sales = DB::table('products')->leftJoin('order_details', 'products.id', '=', 'order_details.product_id')->selectRaw('products.id, SUM(order_details.quantity) as total')->where('status', 1)->groupBy('products.id')->orderBy('total', 'desc')->get();

        $topProducts = [];
        foreach ($top_sales as $s) {
            $p = Product::findOrFail($s->id);
            $p->totalQty = $s->total;
            $topProducts[] = $p;
        }

        // Category-wise products
        $categoryproducts = [];

        foreach ($categories as $category) {
            $products = DB::table('products')->select(
                'id',
                'name',
                'name_bn',
                'slug',
                'image',
                'price',
                'discount',
                'discount_type',
                'category_id',
                'status'
            )
                ->where('status', 1)
                ->where('category_id', $category->id)
                ->orderBy('id', 'DESC')->take(50)->get();

            $categoryproducts[] = [
                'category' => $category,
                'products' => $products,
            ];
        }

        $data['categoryproducts'] = $categoryproducts;

        $data['topProducts'] = $topProducts;

        return $data;
    }

    public function productList()
    {
        $data['pageTitle'] = 'Shop Products';
        $products = Product::query();

        //category filter
        if (!empty(request()->input('category'))) {
            $slugs = explode(',', strip_tags(request()->input('category')));
            $catIds = Category::select('id')->whereIn('name', $slugs)->pluck('id')->toArray();
            $data['allData'] = $products->whereIn('category_id', $catIds);
        }

        //brand filter
        if (!empty(request()->input('brand'))) {
            $slugs = explode(',', strip_tags(request()->input('brand')));
            $brandIds = Brand::select('id')->whereIn('name', $slugs)->pluck('id')->toArray();
            $data['allData'] = $products->whereIn('brand_id', $brandIds)->paginate(20);
        }

        //price range product
        if (!empty(request()->input('price'))) {
            $price = explode('-', request()->input('price', ''));
            $data['allData'] = $products->whereBetween('price', $price);
        }
        //sortByProduct
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'priceLowtoHigh') {
                $data['allData'] = $products
                    ->where(['status' => 1])
                    ->orderBy('price', 'ASC')
                    ->paginate(20);
            } elseif ($_GET['sortBy'] == 'priceHightoLow') {
                $data['allData'] = $products
                    ->where(['status' => 1])
                    ->orderBy('price', 'DESC')
                    ->paginate(20);
            } elseif ($_GET['sortBy'] == 'nameAtoZ') {
                $data['allData'] = $products
                    ->where(['status' => 1])
                    ->orderBy('name', 'ASC')
                    ->paginate(20);
            } elseif ($_GET['sortBy'] == 'nameZtoA') {
                $data['allData'] = $products
                    ->where(['status' => 1])
                    ->orderBy('name', 'DESC')
                    ->paginate(20);
            } else {
                $data['allData'] = $products->where('status', 1)->orderBy('id', 'DESC')->paginate(20);
            }
        } else {
            $data['allData'] = $products->where('status', 1)->orderBy('id', 'DESC')->paginate(20);
        }
        return view('frontend.single_page.product-list', $data);
    }

    //shopFilter
    public function shopFilter(Request $request)
    {
        // dd($request->all());
        $data = $request->all();

        // filter category
        $catUrl = '';
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catUrl)) {
                    $catUrl .= '&category=' . $category;
                } else {
                    $catUrl .= ',' . $category;
                }
            }
        }

        //filter brand
        $brandUrl = '';
        if (!empty($data['brand'])) {
            foreach ($data['brand'] as $brand) {
                if (empty($brandUrl)) {
                    $brandUrl .= '&brand=' . $brand;
                } else {
                    $brandUrl .= ',' . $brand;
                }
            }
        }

        //filter sortBy
        $sortByUrl = '';
        if (!empty($data['sortBy'])) {
            $sortByUrl .= '&sortBy=' . $data['sortBy'];
        }

        //filter sortBy
        $priceRangeUrl = '';
        if (!empty($data['price_range'])) {
            $priceRangeUrl .= '&price=' . $data['price_range'];
        }

        return redirect()->route('product.list', $catUrl . $brandUrl . $sortByUrl . $priceRangeUrl);
    }

    public function categoryWiseProduct($category_id)
    {
        $data['category'] = Category::where('id', $category_id)->first();
        $data['products'] = Product::where('category_id', $category_id)->where('status', 1)->orderBy('id', 'DESC')->paginate(20);
        return view('frontend.single_page.category-wise-product', $data);
    }

    public function subcategoryWiseProduct($subcategory_id)
    {
        $subcategory = Subcategory::where('id', $subcategory_id)->first();
        if (!$subcategory) {
            abort(404);
        }
        $category = Category::where('id', $subcategory->category_id)->first();
        if ($category) {
            $category->name = $subcategory->name; // Override name so the view displays subcategory title
        }
        $data['category'] = $category;
        $data['products'] = Product::where('subcategory_id', $subcategory_id)->where('status', 1)->orderBy('id', 'DESC')->paginate(20);
        return view('frontend.single_page.category-wise-product', $data);
    }

    public function hotDeals()
    {
        $data['products'] = Product::where('hot_deals', 1)->orderBy('id', 'ASC')->paginate(20);
        return view('frontend.single_page.hot-deals', $data);
    }

    public function speacialOffers()
    {
        $data['products'] = Product::where('special_offer', 1)->orderBy('id', 'ASC')->paginate(20);
        $data['pageTitle'] = 'Special Offers';
        return view('frontend.single_page.speacial-offers', $data);
    }

    public function pricingCards()
    {
        $data['plans'] = SellerFee::select('id', 'account_type_of_myshop', 'subscription_fees', 'duration', 'plan_features')
            ->orderBy('subscription_fees', 'ASC')
            ->get();
        $data['pageTitle'] = 'Pricing Plans';
        return view('frontend.single_page.pricing-card', $data);
    }

    public function brandWiseProduct($brand_id)
    {
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $data['brands'] = Product::select('brand_id')->groupBy('brand_id')->get();
        $data['brand'] = Brand::find($brand_id);
        $data['products'] = Product::where('brand_id', $brand_id)->orderBy('id', 'DESC')->paginate(10);
        return view('frontend.single_page.brand-wise-product', $data);
    }

    public function productDetails($slug)
    {
        //dd($slug);
        $ttl = (int)env('HOMEPAGE_CACHE_TTL', 300);
        $data['hot_deals'] = \Cache::remember('hp_hot_deals', $ttl, fn() => 
                Product::select('id','name','name_bn','slug','price','discount','discount_type','image')
                ->where('hot_deals', 1)->where('status', 1)->orderBy('id', 'DESC')->limit(20)->get());
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $data['productDetails'] = Product::with([
            'product_colors.color',
            'product_sizes.size',
            'activeVariants.color',
            'activeVariants.size'
        ])->where('slug', $slug)->first();
        $brand_id = $data['productDetails']->brand_id;
        $data['relatedProduct'] = Product::where('brand_id', $brand_id)->inRandomOrder()->get();
        $data['product_sub_image'] = ProductSubImage::where('product_id', $data['productDetails']->id)->get();
        $data['product_color'] = ProductColor::where('product_id', $data['productDetails']->id)->get();
        $data['product_size'] = ProductSize::where('product_id', $data['productDetails']->id)->get();

        // Product variants data
        $data['product_variants'] = ProductVariant::where('product_id', $data['productDetails']->id)->get();

        return view('frontend.single_page.product-details', $data);
    }
    public function getVariantPrice(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $product_color_id = $request->color_id;
            $product_size_id = $request->size_id;

            $product = Product::find($product_id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ]);
            }

            // Get the actual color_id and size_id from ProductColor and ProductSize tables
            $productColor = ProductColor::find($product_color_id);
            $productSize = ProductSize::find($product_size_id);

            if (!$productColor || !$productSize) {
                return response()->json([
                    'success' => false,
                    'message' => 'Color or Size not found'
                ]);
            }

            $color_id = $productColor->color_id;
            $size_id = $productSize->size_id;

            $isDropshipper = auth()->check() && auth()->user()->usertype === 'dropshipper';
            $hasWholesalePrice = $isDropshipper && !empty($product->sale_price) && $product->sale_price > 0;
            $base_price = $hasWholesalePrice ? floatval($product->sale_price) : floatval($product->price);
            $discount = floatval($product->discount ?? 0);
            $discount_type = $product->discount_type ?? 0;

            // Find variant using actual color_id and size_id
            $variant = ProductVariant::where('product_id', $product_id)
                ->where('color_id', $color_id)
                ->where('size_id', $size_id)
                ->where('status', 1)
                ->first();

            $additional_price = 0;
            if ($variant) {
                $additional_price = floatval($variant->additional_price);
            }

            // Calculate price including selected variant additional price
            $final_price = $base_price + $additional_price;

            // Apply discount if exists
            $discounted_price = $final_price;
            $has_discount = false;
            if (!$hasWholesalePrice && $discount > 0) {
                if ($discount_type == 1) {
                    $discounted_price = $final_price - ($final_price * $discount / 100);
                } else {
                    $discounted_price = $final_price - $discount;
                }
                $has_discount = true;
            }

            return response()->json([
                'success' => true,
                'original_price' => round($final_price),
                'discounted_price' => round($discounted_price),
                'has_discount' => $has_discount,
                'variant_found' => ($variant ? true : false),
                'additional_price' => $additional_price,
                'base_price' => $base_price,
                'is_wholesale_price' => $hasWholesalePrice,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function aboutUs()
    {
        /* $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();*/
        $data['aboutUs'] = About::first();
        return view('frontend.single_page.about-us', $data);
    }

    public function privacyPlicy()
    {
        $page = Page::where('page-slug', 'privacy-policy')->first();
        return view('frontend.single_page.privacy-policy', compact('page'));
    }

    public function returnPlicy()
    {
        return view('frontend.return-policy');
    }

    public function termsAndCondition()
    {
        $page = Page::where('page-slug', 'terms-and-condition')->first();
        return view('frontend.single_page.terms-condition', compact('page'));
    }

    public function userGuide()
    {
        return view('frontend.single_page.user-guide');
    }

    public function contactUs()
    {
        /* $data['logo'] = Logo::first();
         $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();*/
        $data['contact'] = Contact::first();
        return view('frontend.single_page.contact-us', $data);
    }

    public function communicationStore(Request $request)
    {
        DB::transaction(function () use ($request) {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'mobile' => ['required', new BdPhoneNumber()],
                'message' => 'required|min:10|max:200',
            ]);
            $code = rand(000000, 999999);
            $user = new Communication();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->message = $request->message;
            $user->save();
            $mobile = $this->normalizeBangladeshMobileNumber($user->mobile);
            $smsMessage = "Hello Dear $user->name, Your U SuperShop verification code is: $code.The code will expire in 5 minutes. Please do not share your OTP or PIN with others";
            $smsResponse = $this->send_rapid_message($mobile, $smsMessage);
            if (!isset($smsResponse['status']) || $smsResponse['status'] !== 'success') {
                \Illuminate\Support\Facades\Log::error('SMS sending failed', ['response' => $smsResponse]);
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'msg' => $request->message,
            ];

            Mail::send('frontend.emails.contact-email', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'), 'Usupershop');
                $message->to($data['email']);
                $message->subject('Thanks for contact with us');
            });
        });

        return redirect()->route('contact.us')->with('success', 'You have successfully contact with administrator !');
    }

    public function shoppingCart()
    {
        /* $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get(); */
        $data['divisions'] = Division::all();
        return view('frontend.single_page.shopping-cart', $data);
    }

    // Product view with ajax
    public function productViewAjax($product_id)
    {
        $product = Product::with('category', 'brand')->findOrFail($product_id);
        $product_color = ProductColor::with('color')->where('product_id', $product_id)->get();
        $produt_size = ProductSize::with('size')->where('product_id', $product_id)->get();

        return response()->json([
            'product' => $product,
            'color' => $product_color,
            'size' => $produt_size,
        ]);
    }
    public function SuccessPage()
    {
        return view('frontend.sucess');
    }
    public function CancelPage()
    {
        return view('frontend.cancel');
    }
    public function FaildPage()
    {
        return view('frontend.failed');
    }

    public function getPrice(Request $request)
    {

        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'color_id' => 'nullable|integer',
            'size_id' => 'nullable|integer',
        ]);


        $product = Product::findOrFail($request->product_id);


        $variantQuery = ProductVariant::where('product_id', $product->id);

        if ($request->filled('color_id')) {
            $color = ProductColor::find($request->color_id);
            if ($color) {
                $variantQuery->where('color_id', $color->color_id);
            }
        }

        if ($request->filled('size_id')) {
            $size = ProductSize::find($request->size_id);
            if ($size) {
                $variantQuery->where('size_id', $size->size_id);
            }
        }

        $variant = $variantQuery->first();


        $isDropshipper = auth()->check() && auth()->user()->usertype === 'dropshipper';
        $hasWholesalePrice = $isDropshipper && !empty($product->sale_price) && $product->sale_price > 0;

        $effectiveBasePrice = $hasWholesalePrice ? $product->sale_price : $product->price;
        $basePrice = $effectiveBasePrice + ($variant->additional_price ?? 0);

        $finalPrice = $basePrice;
        $discount = $product->discount ?? 0;
        $discountType = $product->discount_type ?? null;
        $showDiscount = false;

        if (!$hasWholesalePrice && $discount > 0) {
            $finalPrice = $discountType == 1
                ? $basePrice - ($basePrice * $discount / 100)
                : $basePrice - $discount;
            $showDiscount = true;
        }

        return response()->json([
            'price' => number_format(max($finalPrice, 0), 2),
            'original_price' => number_format($basePrice, 2),
            'discount' => $showDiscount ? $discount : 0,
            'variant_id' => $variant->id ?? null,
            'has_variant' => $variant ? true : false,
            'is_wholesale_price' => $hasWholesalePrice,
        ]);
    }



    /**
     * Update delivery charge in session when zone is selected
     */
    public function updateDeliveryCharge(\Illuminate\Http\Request $request)
    {
        $zoneId = $request->zone_id;
        $zone   = \App\Models\DeliveryZone::find($zoneId);
        if ($zone) {
            \Session::put('delivery_charge', $zone->zone_charge);
            \Session::put('delivery_zone_id', $zoneId);
            \Session::put('delivery_zone_name', $zone->zone_area);
            return response()->json(['status' => true, 'charge' => $zone->zone_charge]);
        }
        return response()->json(['status' => false]);
    }

}