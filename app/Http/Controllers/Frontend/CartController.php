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
    $coupon_code = $request->input('coupon_code');

    if ($coupon_code != null) {
        $total_ammount = $request->input('totalAmm');

        $coupon_info = DB::table('coupons')->where('promoCode', $coupon_code)->first();

        if ($coupon_info && $coupon_info->status != 0 && $coupon_info->availableFor == 0) {
            if ($total_ammount >= $coupon_info->min_amount) {
                if ($coupon_info->discount_type == 1) {
                    // percentage discount
                    $coupon_discount = ($total_ammount * $coupon_info->discount_amount) / 100;
                } else {
                    // fixed discount
                    $coupon_discount = $coupon_info->discount_amount;
                }

                Session()->put('coupon_discount', $coupon_discount);

                return redirect()->route('show.cart')->with('success', 'Coupon Added Successfully');
            } else {
                return redirect()->route('show.cart')->with('error', 'Amount is not enough');
            }
        } else {
            return redirect()->route('show.cart')->with('error', 'Invalid Coupon');
        }
    } else {
        return redirect()->route('show.cart')->with('error', 'Coupon not yet set');
    }
}

    public function SellerSaveCoupon(Request $request)
    {
        $coupon_code = $request->input('coupon_code');
        if ($coupon_code != '') {
            $total_ammount = $request->input('totalAmm');

            $coupon_info = DB::table('coupons')->where('promoCode', $coupon_code)->get();
            if ($coupon_info[0]->status != 0) {
                if ($total_ammount >= $coupon_info[0]->min_amount) {
                    if ($coupon_info[0]->discount_type == 1) {
                        $coupon_discount = ($total_ammount  * $coupon_info[0]->discount_amount) / 100;
                        //echo $coupon_discount;
                        Session()->put('coupon_discount', $coupon_discount);
                        return redirect()->route('show.seller.cart')->with('success', 'Coupon Added Successfully');
                    } else {
                        $coupon_discount = $coupon_info[0]->discount_amount;
                        Session()->put('coupon_discount', $coupon_discount);
                        return redirect()->route('show.seller.cart')->with('success', 'Coupon Added Successfully');
                    }
                } else {
                    return redirect()->route('show.seller.cart')->with('error', 'Amount is not enough');
                }
            } else {
                return redirect()->route('show.seller.cart')->with('error', 'Invalid Coupon');
            }
        } else {
            return redirect()->route('show.seller.cart')->with('error', 'Coupon not yet set');
        }
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
}