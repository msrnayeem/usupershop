<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AddToCartController extends Controller
{
    public function customerCartStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'exists:products,id'],
            'qty' => ['required', 'integer', 'min:1'],
            'color_id' => ['nullable', 'exists:product_colors,id'],
            'size_id' => ['nullable', 'exists:product_sizes,id']
        ]);

        // Stop here if basic validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'validation error'
            ]);
        }

        // Retrieve product after basic validation
        $product = Product::findOrFail($request->product_id);

        // Conditionally require color_id
        if ($product->product_colors->isNotEmpty() && !$request->filled('color_id')) {
            $validator->getMessageBag()->add('color_id', 'The color field is required for this product.');
        }

        // Conditionally require size_id
        if ($product->product_sizes->isNotEmpty() && !$request->filled('size_id')) {
            $validator->getMessageBag()->add('size_id', 'The size field is required for this product.');
        }


        // Dropshipper selling price validation
        if (auth()->check() && auth()->user()->usertype == 'dropshipper') {
            if (!$request->filled('drop_selling_price')) {
                $validator->getMessageBag()->add('drop_selling_price', 'Your selling price is required.');
            } else {
                $sellingPrice = floatval($request->drop_selling_price);
                $minPrice = floatval($product->min_price);
                $maxPrice = floatval($product->max_price);
                
                // Check if selling price is within allowable range
                if ($sellingPrice < $minPrice) {
                    $validator->getMessageBag()->add('drop_selling_price', "Selling price cannot be less than ৳{$minPrice}. Please enter a valid price.");
                }
                
                if ($sellingPrice > $maxPrice) {
                    $validator->getMessageBag()->add('drop_selling_price', "Selling price cannot exceed ৳{$maxPrice}. Order will not be accepted.");
                }
            }
        }


        // Final check after conditional validation
        if ($validator->errors()->any()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'validation error'
            ]);
        } else {
            if ($request->hasCookie('customer_cookie_id')) {
                $cookie_id = $request->cookie('customer_cookie_id');
            } else {
                $cookie_id = time() . Str::random(10);
                Cookie::queue('customer_cookie_id', $cookie_id, 14400);
            }

            if (Cart::where(['cookie_id' => $cookie_id])->exists()) {
                if (Cart::where(['cookie_id' => $cookie_id, 'product_id' => $request->product_id, 'color_id' => $request->color_id, 'size_id' => $request->size_id])->exists()) {
                    Cart::where(['cookie_id' => $cookie_id, 'product_id' => $request->product_id, 'color_id' => $request->color_id, 'size_id' => $request->size_id])->increment('qty', $request->qty);
                    return response()->json([
                        'status' => true,
                        'type' => 'increase',
                        'message' => 'Product Quantity Increased.'
                    ]);
                } else {
                    $cart = new Cart;
                    $cart->cookie_id = $cookie_id;
                    $cart->product_id = $request->product_id;
                    $cart->qty = $request->qty;
                    $cart->color_id = $request->color_id;
                    $cart->size_id = $request->size_id;
                    $cart->drop_selling_price = $request->drop_selling_price ?? 0;
                    $cart->save();
                    return response()->json([
                        'status' => true,
                        'type' => 'success',
                        'message' => 'Add to Cart Successfull.'
                    ]);
                }
            } else {
                $cart = new Cart;
                $cart->cookie_id = $cookie_id;
                $cart->product_id = $request->product_id;
                $cart->qty = $request->qty;
                $cart->color_id = $request->color_id;
                $cart->size_id = $request->size_id;
                $cart->drop_selling_price = $request->drop_selling_price ?? 0;
                $cart->save();

                return response()->json([
                    'status' => true,
                    'type' => 'success',
                    'message' => 'Add to Cart Successfull.'
                ]);
            }

            return response()->json([
                'status' => false,
                'type' => 'error',
                'message' => 'Something Wrong."'
            ]);
        }

    }

    public function customerCartData()
    {
        $cookie_id = request()->cookie('customer_cookie_id');
        if (empty($cookie_id)) {
            return response()->json([]);
        }

        $cartItems = Cart::with([
            'product',
            'product_color.color',
            'product_size.size',
        ])->where('cookie_id', $cookie_id)->get();

        $responseData = [];

        foreach ($cartItems as $value) {

            $product = $value->product;
            if (!$product)
                continue; // skip invalid records

            // Base price
            $basePrice = $product->price;

            $productColor = ProductColor::find($value->color_id);
            $productSize = ProductSize::find($value->size_id);

            // === Variant additional price ===
            $variant = ProductVariant::where('product_id', $product->id)
                ->when($value->color_id, fn($q) => $q->where('color_id', $productColor?->color_id ?? null))
                ->when($value->size_id, fn($q) => $q->where('size_id', $productSize?->size_id ?? null))
                ->first();

            if ($variant && $variant->additional_price) {
                $basePrice += $variant->additional_price;
            }

            // === Discount calculation ===
            if (!empty($product->discount)) {
                $finalPrice = $product->discount_type == 1
                    ? $basePrice - ($basePrice * $product->discount / 100)
                    : $basePrice - $product->discount;
            } else {
                $finalPrice = $basePrice;
            }

            if (auth()->check() && auth()->user()->usertype == 'dropshipper' && $value->drop_selling_price > 0) {
                $finalPrice = $value->drop_selling_price;
                if ($finalPrice < 1) {
                    $finalPrice = $basePrice;   
                }
            }

            // === Structured response ===
            $responseData[] = [
                'id' => $value->id,
                'product_id' => $value->product_id,
                'qty' => $value->qty,
                'size_id' => $value->size_id,
                'size_name' => $value->product_size ? $value->product_size->size->name : '',
                'color_id' => $value->color_id,
                'color_name' => $value->product_color ? $value->product_color->color->name : '',
                'product' => [
                    'id' => $product->id,
                    'slug' => $product->slug,
                    'name' => $product->name,
                    'name_bn' => $product->name_bn,
                    'image' => asset('upload/product_images') . '/' . $product->image,
                    'stock_qty' => $product->quantity,
                    'price' => $finalPrice,
                    'original_price' => $basePrice,
                    'discount' => $product->discount,
                    'discount_type' => $product->discount_type,
                    'srate' => $product->srate,
                    'status' => $product->status,
                ],
            ];
        }

        return response()->json($responseData);
    }


    public function customerCartDestroy($cart_id)
    {
        $cookieId = request()->cookie('customer_cookie_id');

        $cartQuery = Cart::query()->where('id', $cart_id);
        if (!empty($cookieId)) {
            $cartQuery->where('cookie_id', $cookieId);
        }
        $cart = $cartQuery->first();

        // Fallback for clients that lost the cookie while still holding cart item id in UI.
        if (!$cart && empty($cookieId)) {
            $cart = Cart::find($cart_id);
            if ($cart && !empty($cart->cookie_id)) {
                Cookie::queue('customer_cookie_id', $cart->cookie_id, 14400);
            }
        }

        if ($cart) {
            $cart->forceDelete();
            return response()->json([
                'status' => true,
                'message' => 'Cart Item Remove Successfully'
            ]);
        }

        if (empty($cookieId)) {
            return response()->json([
                'status' => false,
                'message' => 'Cookie Not Found'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Cart Item Remove Unsuccessfully'
        ]);
    }

    public function customerCartUpdate(Request $request)
    {
        $cookieId = request()->cookie('customer_cookie_id');

        $cartQuery = Cart::query()->where('id', $request->cart_id);
        if (!empty($cookieId)) {
            $cartQuery->where('cookie_id', $cookieId);
        }
        $cart = $cartQuery->first();

        if (!$cart && empty($cookieId)) {
            $cart = Cart::find($request->cart_id);
        }

        if ($cart == true) {
            $cart->qty = $request->qty;
            $cart->save();
            return response()->json('success');
        }
        return response()->json('error');
    }
}
