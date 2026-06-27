<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Contact;
use App\Models\Division;
use App\Models\Logo;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
        $this->validate($request, [
            'size_id' => 'required',
            'color_id' => 'required'
        ]);
        $product = Product::where('id', $request->id)->first();
        $product_size = Size::where('id', $request->size_id)->first();
        $product_color = Color::where('id', $request->color_id)->first();

        if ($product->discount_type == 1) {
            $productPrice = $product->price - ($product->price * $product->discount) / 100;
        } else {
            $productPrice = $product->price - $product->discount;
        }

        Cart::add([
            'id' => $request->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $productPrice,
            'weight' => 550,
            'options' => [
                'size_id' => $request->size_id,
                'size_name' => $product_size->name,
                'color_id' => $request->color_id,
                'color_name' => $product_color->name,
                'image' => $product->image,
            ],
        ]);
        return redirect()->route('show.cart')->with('success', 'Product Added Successfully');
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $size = $request->size;
        $color = $request->color;
        $sizeId = (int)$size;
        $colorId = (int)$color ?? 0;
        $product_size = Size::where('id',$sizeId)->first();
        $product_color = Color::where('id',$colorId)->first();
        if ($product->discount == NULL) {
            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->price ,
                'weight' => 1,
                'options' => [
                    'image' => $product->image,
                    'size_id' => $sizeId,
                    'size_name' => $product_size->name,
                    'color_name' => $product_color->name,
                    'color_id' => $colorId
                ]
            ]);
            return response()->json(['success' => 'Sucessfully Added On Your Cart']);
        } else {
            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->price-$product->discount,
                'weight' => 1,
                'options' => [
                    'image' => $product->image,
                    'size_id' => $sizeId,
                    'size_name' => $product_size->name,
                    'color_name' => $product_color->name,
                    'color_id' => $colorId
                ]
            ]);
            return response()->json(['success' => 'Sucessfully Added On Your Cart']);
        }
    }

    public function showCart()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $data['divisions'] = Division::all();
        return view('frontend.single_page.shopping-cart', $data);
    }

    public function updateCart(Request $request)
    {
        Cart::update($request->rowId, $request->qty);
        Session()->forget('coupon_discount');
        return redirect()->route('show.cart')->with('success', 'Quantity Updated Successfully');
    }

    public function deleteCart($rowId)
    {
        Cart::remove($rowId);
        Session()->forget('coupon_discount');
        return redirect()->route('show.cart')->with('success', 'Product Deleted Successfully');
    }
    public function addToSellerCart(Request $request,$id)
    {
        $product = Product::findOrFail($id);
        $size = $request->size;
        $color = $request->color;
        $sizeId = (int)$size;
        $colorId = (int)$color;
        $product_size = Size::where('id',$sizeId)->first();
        $product_color = Color::where('id',$colorId)->first();
    
        if ($product->discount == NULL) {
            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->price,
                'weight' => 1,
               'options' => [
                    'image' => $product->image,
                    'size_id' => $sizeId,
                    'size_name' => $product_size->name,
                    'color_name' => $product_color->name,
                    'color_id' => $colorId,
                    'shopID' =>$request->shopID
                ]
            ]);
            return response()->json(['success' => 'Sucessfully Added On Your Cart']);
        } else {
            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->price - $product->discount,
                'weight' => 1,
               'options' => [
                    'image' => $product->image,
                    'size_id' => $sizeId,
                    'size_name' => $product_size->name,
                    'color_name' => $product_color->name,
                    'color_id' => $colorId,
                    'shopID' =>$request->shopID
                ]
            ]);
            return response()->json(['success' => 'Sucessfully Added On Your Cart']);
        }
    }
    // Seller Card History
    public function addSellerCart(Request $request)
    {
        $this->validate($request, [
            'size_id' => 'required',
            'color_id' => 'required'
        ]);
        $product = Product::where('id', $request->id)->first();
        $product_size = Size::where('id', $request->size_id)->first();
        $product_color = Color::where('id', $request->color_id)->first();
        if ($product->discount_type == 1) {
            $productPrice = $product->price - ($product->price * $product->discount) / 100;
        } else {
            $productPrice = $product->price - $product->discount;
        }
        Cart::add([
            'id' => $request->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $productPrice,
            'weight' => 550,
            'options' => [
                'size_id' => $request->size_id,
                'shopID' => $request->shopID,
                'size_name' => $product_size->name,
                'color_id' => $request->color_id,
                'color_name' => $product_color->name,
                'image' => $product->image
            ],
        ]);
        return redirect()->route('show.seller.cart')->with('success', 'Product Added Successfully');
    }

    public function showSellerCart()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $data['divisions'] = Division::all();
        return view('frontend.seller_shop.seller_shopping_cart', $data);
    }

    public function updateSellerCart(Request $request)
    {
        Cart::update($request->rowId, $request->qty);
        Session()->forget('coupon_discount');
        return redirect()->route('show.seller.cart')->with('success', 'Quantity Updated Successfully');
    }

    public function deleteSellerCart($rowId)
    {
        Cart::remove($rowId);
        Session()->forget('coupon_discount');
        return redirect()->route('show.seller.cart')->with('success', 'Product Deleted Successfully');
    }

    // Coupon
  public function saveCoupon(Request $request)
{
    $coupon_code   = trim($request->input('coupon_code'));
    $total_ammount = (float)$request->input('totalAmm', 0);

    if (empty($coupon_code)) {
        return redirect()->route('show.cart')
            ->with('error', '❌ কুপন কোড লিখুন।');
    }

    $coupon = \App\Models\Coupon::where('promoCode', $coupon_code)->first();

    // ── 1. Coupon exists? ─────────────────────────────────────────────
    if (!$coupon) {
        return redirect()->route('show.cart')
            ->with('error', '❌ এই কুপন কোডটি সঠিক নয়।');
    }

    // ── 2. Active? ────────────────────────────────────────────────────
    if ($coupon->status == 0) {
        return redirect()->route('show.cart')
            ->with('error', '❌ এই কুপনটি আর সক্রিয় নেই।');
    }

    // ── 3. Date valid? ────────────────────────────────────────────────
    $today = now()->toDateString();
    if ($today < $coupon->start_date) {
        return redirect()->route('show.cart')
            ->with('error', '❌ এই কুপনটি এখনও শুরু হয়নি। শুরুর তারিখ: ' . \Carbon\Carbon::parse($coupon->start_date)->format('d M Y'));
    }
    if ($today > $coupon->end_date) {
        return redirect()->route('show.cart')
            ->with('error', '❌ এই কুপনটির মেয়াদ শেষ হয়ে গেছে।');
    }

    // ── 4. Available for correct user type? ───────────────────────────
    // availableFor: 0=Customer only, 1=Staff, 2=Both(All), 3=Vendor, 4=Seller, 5=Dropshipper
    $usertype = auth()->check() ? auth()->user()->usertype : 'guest';
    $allowed  = false;

    if ($coupon->availableFor == 2) {
        $allowed = true; // All users
    } elseif ($coupon->availableFor == 0 && in_array($usertype, ['user', 'customer', 'guest'])) {
        $allowed = true; // Customer only
    } elseif ($coupon->availableFor == 4 && $usertype === 'seller') {
        $allowed = true;
    } elseif ($coupon->availableFor == 3 && $usertype === 'vendor') {
        $allowed = true;
    } elseif ($coupon->availableFor == 5 && $usertype === 'dropshipper') {
        $allowed = true;
    } elseif ($coupon->availableFor == 1 && $usertype === 'staff') {
        $allowed = true;
    }

    if (!$allowed) {
        return redirect()->route('show.cart')
            ->with('error', '❌ এই কুপনটি আপনার Account Type-এর জন্য প্রযোজ্য নয়।');
    }

    // ── 5. Minimum amount? ────────────────────────────────────────────
    if ($total_ammount < (float)$coupon->min_amount) {
        return redirect()->route('show.cart')
            ->with('error', '❌ এই কুপন ব্যবহার করতে কমপক্ষে ৳' . number_format($coupon->min_amount, 0) . ' টাকার কেনাকাটা করতে হবে।');
    }

    // ── 6. Usage limit? ───────────────────────────────────────────────
    if ($coupon->available <= 0) {
        return redirect()->route('show.cart')
            ->with('error', '❌ এই কুপনটি সব ব্যবহার হয়ে গেছে।');
    }

    // ── 7. Calculate discount ─────────────────────────────────────────
    if ($coupon->discount_type == 1) {
        $coupon_discount = ($total_ammount * (float)$coupon->discount_amount) / 100;
    } else {
        $coupon_discount = (float)$coupon->discount_amount;
    }

    // Cap discount at order total
    $coupon_discount = min($coupon_discount, $total_ammount);

    Session::put('coupon_discount', $coupon_discount);
    Session::put('coupon_code', $coupon_code);

    // Decrement available count
    $coupon->decrement('available');

    $discountText = $coupon->discount_type == 1
        ? $coupon->discount_amount . '% ছাড়'
        : '৳' . number_format($coupon_discount, 0) . ' ছাড়';

    return redirect()->route('show.cart')
        ->with('success', '✅ কুপন সফলভাবে প্রয়োগ হয়েছে! আপনি পাচ্ছেন ' . $discountText . '।');
}

    public function SellerSaveCoupon(Request $request)
    {
        $coupon_code   = trim($request->input('coupon_code'));
        $total_ammount = (float)$request->input('totalAmm', 0);

        if (empty($coupon_code)) {
            return redirect()->route('show.seller.cart')->with('error', '❌ কুপন কোড লিখুন।');
        }

        $coupon = \App\Models\Coupon::where('promoCode', $coupon_code)->first();

        if (!$coupon) {
            return redirect()->route('show.seller.cart')->with('error', '❌ এই কুপন কোডটি সঠিক নয়।');
        }
        if ($coupon->status == 0) {
            return redirect()->route('show.seller.cart')->with('error', '❌ এই কুপনটি আর সক্রিয় নেই।');
        }

        $today = now()->toDateString();
        if ($today < $coupon->start_date) {
            return redirect()->route('show.seller.cart')->with('error', '❌ এই কুপনটি এখনও শুরু হয়নি।');
        }
        if ($today > $coupon->end_date) {
            return redirect()->route('show.seller.cart')->with('error', '❌ এই কুপনটির মেয়াদ শেষ হয়ে গেছে।');
        }

        // availableFor: 2=All, 4=Seller, 3=Vendor, 5=Dropshipper
        $usertype = auth()->check() ? auth()->user()->usertype : 'guest';
        $allowed  = in_array($coupon->availableFor, [2]) ||
                    ($coupon->availableFor == 4 && $usertype === 'seller') ||
                    ($coupon->availableFor == 3 && $usertype === 'vendor') ||
                    ($coupon->availableFor == 5 && $usertype === 'dropshipper');

        if (!$allowed) {
            return redirect()->route('show.seller.cart')->with('error', '❌ এই কুপনটি আপনার Account Type-এর জন্য প্রযোজ্য নয়।');
        }
        if ($total_ammount < (float)$coupon->min_amount) {
            return redirect()->route('show.seller.cart')->with('error', '❌ কমপক্ষে ৳' . number_format($coupon->min_amount, 0) . ' টাকার কেনাকাটা করুন।');
        }
        if ($coupon->available <= 0) {
            return redirect()->route('show.seller.cart')->with('error', '❌ এই কুপনটি সব ব্যবহার হয়ে গেছে।');
        }

        $coupon_discount = $coupon->discount_type == 1
            ? ($total_ammount * (float)$coupon->discount_amount) / 100
            : (float)$coupon->discount_amount;
        $coupon_discount = min($coupon_discount, $total_ammount);

        Session::put('coupon_discount', $coupon_discount);
        Session::put('coupon_code', $coupon_code);
        $coupon->decrement('available');

        return redirect()->route('show.seller.cart')
            ->with('success', '✅ কুপন সফলভাবে প্রয়োগ হয়েছে! ৳' . number_format($coupon_discount, 0) . ' ছাড় পাচ্ছেন।');
    }
    // Area id save

    public function saveAreaId(Request $request)
    {
        $AId = $request->input('AID');
        $AidUserId = $AId . "-" . Auth::user()->id;
        Session()->put('areaID', $AidUserId);
    }


    ///////////////wishlist
    public function addToWishlist(Request $request, $product_id)
    {
        if (Auth::check()) {
            $exists = Wishlist::where('customer_id', Auth::id())->where('product_id', $product_id)->first();
            if (!$exists) {
                Wishlist::insert([
                    'customer_id' => Auth::id(),
                    'product_id' => $product_id,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json(['success' => 'Sucessfully Added On Your Wishlist']);
            } else {
                return response()->json(['error' => 'The Product Has Already On Your Wishlist']);
            }
        } else {
            return response()->json(['error' => 'At First Login Your Account']);
        }
    }

    /**
     * AJAX coupon apply for payment page
     */
    public function ajaxApplyCoupon(\Illuminate\Http\Request $request)
    {
        $coupon_code   = trim($request->input('coupon_code'));
        $total_ammount = (float)$request->input('total', 0);

        if (empty($coupon_code)) {
            return response()->json(['success' => false, 'message' => 'কুপন কোড লিখুন।']);
        }

        $coupon = \App\Models\Coupon::where('promoCode', $coupon_code)->first();

        if (!$coupon)         return response()->json(['success' => false, 'message' => 'এই কুপন কোডটি সঠিক নয়।']);
        if ($coupon->status == 0) return response()->json(['success' => false, 'message' => 'এই কুপনটি আর সক্রিয় নেই।']);

        $today = now()->toDateString();
        if ($today < $coupon->start_date) return response()->json(['success' => false, 'message' => 'এই কুপনটি এখনও শুরু হয়নি।']);
        if ($today > $coupon->end_date)   return response()->json(['success' => false, 'message' => 'এই কুপনটির মেয়াদ শেষ হয়ে গেছে।']);

        $usertype = auth()->check() ? auth()->user()->usertype : 'guest';
        $allowed  = $coupon->availableFor == 2 ||
                    ($coupon->availableFor == 0 && in_array($usertype, ['user', 'customer', 'guest'])) ||
                    ($coupon->availableFor == 4 && $usertype === 'seller') ||
                    ($coupon->availableFor == 3 && $usertype === 'vendor') ||
                    ($coupon->availableFor == 5 && $usertype === 'dropshipper');

        if (!$allowed) return response()->json(['success' => false, 'message' => 'এই কুপনটি আপনার Account Type-এর জন্য প্রযোজ্য নয়।']);
        if ($coupon->available <= 0) return response()->json(['success' => false, 'message' => 'এই কুপনটি সব ব্যবহার হয়ে গেছে।']);
        if ($total_ammount < (float)$coupon->min_amount) {
            return response()->json(['success' => false, 'message' => 'কমপক্ষে ৳' . number_format($coupon->min_amount, 0) . ' টাকার কেনাকাটা করতে হবে।']);
        }

        $discount = $coupon->discount_type == 1
            ? ($total_ammount * (float)$coupon->discount_amount) / 100
            : (float)$coupon->discount_amount;
        $discount = min($discount, $total_ammount);

        Session::put('coupon_discount', $discount);
        Session::put('coupon_code', $coupon_code);
        $coupon->decrement('available');

        $msg = $coupon->discount_type == 1
            ? $coupon->discount_amount . '% ছাড় — ৳' . number_format($discount, 0) . ' সাশ্রয়!'
            : '৳' . number_format($discount, 0) . ' ছাড় পাচ্ছেন!';

        return response()->json(['success' => true, 'message' => $msg, 'discount' => $discount]);
    }

    /**
     * Remove applied coupon
     */
    public function removeCoupon()
    {
        // Restore available count
        $code = Session::get('coupon_code');
        if ($code) {
            \App\Models\Coupon::where('promoCode', $code)->increment('available');
        }
        Session::forget('coupon_discount');
        Session::forget('coupon_code');

        // Redirect back - could be cart or payment page
        return redirect()->back()->with('success', '✅ কুপন সরানো হয়েছে।');
    }


    /**
     * AJAX coupon check for Seller/Vendor/Dropshipper registration page
     */
    public function ajaxCheckCouponForRegistration(\Illuminate\Http\Request $request)
    {
        $code     = trim($request->input('coupon_code', ''));
        $usertype = $request->input('type', 'registration');

        if (empty($code)) {
            return response()->json(['success' => false, 'message' => 'কুপন কোড লিখুন।']);
        }

        $coupon = \App\Models\Coupon::where('promoCode', $code)->first();

        if (!$coupon)
            return response()->json(['success' => false, 'message' => 'এই কুপন কোডটি সঠিক নয়।']);
        if ($coupon->status == 0)
            return response()->json(['success' => false, 'message' => 'এই কুপনটি আর সক্রিয় নেই।']);

        $today = now()->toDateString();
        if ($today < $coupon->start_date)
            return response()->json(['success' => false, 'message' => 'এই কুপনটি এখনও শুরু হয়নি।']);
        if ($today > $coupon->end_date)
            return response()->json(['success' => false, 'message' => 'এই কুপনটির মেয়াদ শেষ হয়ে গেছে।']);
        if ($coupon->available <= 0)
            return response()->json(['success' => false, 'message' => 'এই কুপনটি সব ব্যবহার হয়ে গেছে।']);

        // Registration coupons: availableFor 2=All, 4=Seller, 3=Vendor, 5=Dropshipper
        if (!in_array($coupon->availableFor, [2, 4, 3, 5]))
            return response()->json(['success' => false, 'message' => 'এই কুপনটি Registration-এর জন্য প্রযোজ্য নয়।']);

        $discText = $coupon->discount_type == 1
            ? $coupon->discount_amount . '% ছাড়'
            : '৳' . number_format($coupon->discount_amount, 0) . ' ছাড়';

        return response()->json([
            'success' => true,
            'message' => 'কুপন সঠিক! আপনি পাবেন ' . $discText . '। Registration-এর সময় apply হবে।',
            'discount' => $coupon->discount_amount,
        ]);
    }

}