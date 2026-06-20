<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DeliveryZone;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\Shipping;
use App\Rules\BdPhoneNumber;
use App\Traits\BkashPaymentTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;

class CustomerCheckoutController extends Controller
{
    use BkashPaymentTrait;

    private function generateOrderNumber()
    {
        $time = time();
        $lastOrder = Order::orderBy('id', 'DESC')->first();
        $order_no = $lastOrder ? $lastOrder->id + 1 : 1;
        return $time . $order_no;
    }

    public function CustomerOrderCheckout(Request $request)
    {
        $user = Auth::user();
        // Guest checkout is always allowed — no login required to order
        $guestCheckout = !$user || $request->boolean('guest_checkout');

        if ($guestCheckout) {
            $user = null;
        }

        if ($user && $user->usertype !== 'customer' && $user->usertype !== 'dropshipper') {
            return response()->json([
                'status' => false,
                'type' => 'user_type',
                'message' => $user->usertype . ' cannot place an order!'
            ]);
        }

        // Validate request
        $request->validate([
            'name' => ['required'],
            'email' => ['nullable', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
            'mobile' => ['required', new BdPhoneNumber()],
            'address' => ['required'],
            'delivery_area' => ['required'],
            'payment_method' => ['required'],
        ]);

        // Get delivery charge
        $deliveryArea = DeliveryZone::find($request->delivery_area);
        if (!$deliveryArea) {
            return response()->json([
                'status' => false,
                'type' => 'delivery_area',
                'message' => 'Delivery Area Not Found!'
            ]);
        }
        $delivery_charge = $deliveryArea->zone_charge ?? 0;
        $checkoutUserId = $user?->id ?? 0;

        if (!$request->hasCookie('customer_cookie_id')) {
            return response()->json([
                'status' => false,
                'type' => 'cart',
                'message' => 'Cart data not found!'
            ]);
        }

        $cookie_id = $request->cookie('customer_cookie_id');
        $cart_data = Cart::with(['product', 'product_color.color', 'product_size.size', 'product.variants'])->where('cookie_id', $cookie_id)->get();

        if ($cart_data->isEmpty()) {
            return response()->json([
                'status' => false,
                'type' => 'cart',
                'message' => 'Cart is empty!'
            ]);
        }

        $order_total_amount = 0;
        $dropshipper_profit_total = 0;
        $orderItemsData = [];

        foreach ($cart_data as $cart) {
            $product = $cart->product;

            if (!$product)
                continue;

            // Determine variant price
            $variantPrice = $product->price; // base price

            if ($cart->color_id || $cart->size_id) {
                $prductColor = ProductColor::find($cart->color_id);
                $productSize = ProductSize::find($cart->size_id);
                $variant = ProductVariant::where('product_id', $product->id)
                    ->when($cart->color_id, fn($q) => $q->where('color_id', $prductColor?->color_id))
                    ->when($cart->size_id, fn($q) => $q->where('size_id', $productSize?->size_id))
                    ->first();

                if ($variant && $variant->additional_price) {
                    $variantPrice += $variant->additional_price;
                }
            }

            // Apply discount
            if (!empty($product->discount)) {
                if ($product->discount_type == 1) {
                    $variantPrice -= ($variantPrice * $product->discount / 100);
                } else {
                    $variantPrice -= $product->discount;
                }
            }

            // Check stock
            if ($product->quantity < $cart->qty) {
                return response()->json([
                    'status' => false,
                    'type' => 'stock',
                    'message' => "Product '{$product->name}' is out of stock or insufficient quantity."
                ]);
            }

            $line_total = $variantPrice * $cart->qty;
            $dropshipper_profit = 0;

            if (auth()->check() && $user->usertype == 'dropshipper' && $cart->drop_selling_price > 0) {

                // Validate selling price is within allowable range
                $minPrice = floatval($product->min_price);
                $maxPrice = floatval($product->max_price);
                $sellingPrice = floatval($cart->drop_selling_price);
                
                if ($sellingPrice < $minPrice || $sellingPrice > $maxPrice) {
                    return response()->json([
                        'status' => false,
                        'type' => 'price_validation',
                        'message' => "Product '{$product->name}' selling price must be between ৳{$minPrice} and ৳{$maxPrice}. Please update your cart."
                    ]);
                }

                // cost price (default)
                $cost_price = $variantPrice;

                // selling price (dropshipper)
                $selling_price = $cart->drop_selling_price;

                // calculate profit
                $dropshipper_profit = ($selling_price - $cost_price) * $cart->qty;

                // update variant price to selling price
                $variantPrice = $selling_price;

                // now calculate line total using updated price
                $line_total = $variantPrice * $cart->qty;
            }


            $order_total_amount += $line_total;
            $dropshipper_profit_total += $dropshipper_profit;

            $orderItemsData[] = [
                'product_id' => $product->id,
                'color_id' => $cart->color_id ?? 0,
                'color_name' => $cart->product_color ? $cart->product_color->color->name : null,
                'size_id' => $cart->size_id ?? 0,
                'size_name' => $cart->product_size ? $cart->product_size->size->name : null,
                'quantity' => $cart->qty,
                'buy_price' => $product->trade_price ?? 0,
                'sell_price' => $variantPrice,
                'vendor_id' => $product->user_id ?? null,
                'reseller_id' => null,
                'dropshipper_sell_price' => ($user && $user->usertype == 'dropshipper') ? $variantPrice : 0,
                'dropshipper_profit' => ($user && $user->usertype == 'dropshipper') ? $dropshipper_profit : 0,
                'created_at' => now(),
            ];
        }

        $grand_total_amount = $order_total_amount + $delivery_charge;

        // Enforce: delivery charge must be paid for ALL orders (COD & bKash)
        if ($delivery_charge <= 0) {
            return response()->json([
                'status' => false,
                'message' => 'Delivery area not selected or delivery charge is missing. Please select your delivery area.'
            ], 422);
        }

        $selectedPaymentMethod = strtolower((string) $request->payment_method);

        // Payment method mapping
        $payment_method = match ($selectedPaymentMethod) {
            'bkash' => 1,
            'cod' => 3,
            default => 0,
        };
        $payment_amount = ($payment_method === 3) ? $delivery_charge : $grand_total_amount;

        $order_status = $payment_method < 1 ? 'confirmed' : 'pending';
        $order_payment_status = $payment_method < 1 ? 'Paid' : 'Unpaid';

        DB::beginTransaction();
        try {
            // Shipping
            $shipping = Shipping::create([
                'user_id' => $checkoutUserId,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
            ]);

            // Payment
            $payment = Payment::create(['payment_method' => $selectedPaymentMethod]);

            // Order
            $order = Order::create([
                'user_id' => $checkoutUserId,
                'dropshipper_id' => ($user && $user->usertype == 'dropshipper') ? $user->id : null,
                'shipping_id' => $shipping->id,
                'payment_id' => $payment->id,
                'invoice_no' => 'USP_TEMP', // will be updated after order save
                'order_no' => $this->generateOrderNumber(),
                'delivery_charge' => $delivery_charge,
                'coupon_discount' => 0,
                'order_total' => $order_total_amount,
                'grand_total' => $grand_total_amount,
                'status' => $order_status,
                'order_payment' => $order_payment_status,
                'pay_method' => $payment_method,
                'dropshipper_profit' =>  ($user && $user->usertype == 'dropshipper') ? $dropshipper_profit_total : 0,
            ]);

            // Update invoice
            $order->update(['invoice_no' => $this->generateInvoiceNo($order->id)]);

            // Insert order items
            if (!empty($orderItemsData)) {
                foreach ($orderItemsData as &$item) {
                    $item['order_id'] = $order->id;
                }
                OrderDetail::insert($orderItemsData);

                // Decrement stock
                foreach ($cart_data as $cart) {
                    $product = $cart->product;
                    if ($product)
                        $product->decrement('quantity', $cart->qty);
                }
            }

            // Commit transaction BEFORE payment processing
            // This ensures order is saved even if payment gateway fails
            DB::commit();

            // Clear cart only after successful commit
            Cart::where('cookie_id', $cookie_id)->delete();
            Cookie::queue(Cookie::forget('customer_cookie_id'));

            // Process payment AFTER order is saved
            $payment_url = null;
            $redirectMessage = 'Redirecting to payment gateway.';

            try {
                if (($selectedPaymentMethod === 'bkash' || $selectedPaymentMethod === 'cod') && $payment_amount > 0) {
                    $payment_url = $this->processBkashPayment($payment_amount, $order->id);
                    if ($selectedPaymentMethod === 'cod') {
                        $redirectMessage = 'Redirecting to bKash to pay delivery charge.';
                    }
                }
                
                // If payment gateway returns a redirect URL, use it
                if ($payment_url && is_array($payment_url) && $payment_url['status'] === true) {
                    return response()->json([
                        'status' => true,
                        'type' => 'redirect_payment',
                        'url' => $payment_url['url'],
                        'message' => $redirectMessage
                    ]);
                }
            } catch (\Exception $paymentError) {
                // Log payment error but don't fail the order
                \Log::warning('Payment gateway error (order still saved): ' . $paymentError->getMessage(), [
                    'order_id' => $order->id,
                    'payment_method' => $request->payment_method
                ]);
            }

            // Return success with order details page URL
            if ($user && $user->usertype == 'dropshipper') {
                return response()->json([
                    'status' => true,
                    'url' => route('dropshipper.orders.details', ['id' => $order->id]),
                    'message' => 'Order placed successfully!'
                ]);
            }
            
            if ($user && $user->usertype == 'customer') {
                return response()->json([
                    'status' => true,
                    'url' => route('customer.order.details', ['id' => $order->id]),
                    'message' => 'Order placed successfully!'
                ]);
            }

            return response()->json([
                'status' => true,
                'type' => 'guest_confirmation',
                'url' => URL::temporarySignedRoute(
                    'guest.order.confirmation',
                    now()->addMinutes(60),
                    ['order' => $order->id]
                ),
                'message' => 'Order placed successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the error for debugging
            \Log::error('Order Checkout Error: ' . $e->getMessage(), [
                'user_id' => $user?->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => false,
                'type' => 'error',
                'message' => 'Something went wrong during checkout. Please try again.',
                'error_msg' => config('app.debug') ? $e->getMessage() : 'An error occurred'
            ]);
        }
    }

    public function guestOrderConfirmation(Request $request, Order $order)
    {
        abort_unless($request->hasValidSignature(), 403);

        $data['order'] = Order::with(['shipping', 'order_details.product'])->findOrFail($order->id);

        return view('frontend.single_page.guest-order-confirmation', $data);
    }



    public function getDiscountPrice($price, $discount, $discountType)
    {
        $finalPrice = $price;
        if (is_numeric($discount) && $discount > 0) {
            if ($discountType == 1) {
                $finalPrice = $price - ($price * $discount) / 100;
            } else {
                $finalPrice = $price - $discount;
            }
        }

        return $finalPrice;
    }

    private function processBkashPayment($payment_amount, $orderID)
    {
        $grantToken = $this->grantToken();
        if (isset($grantToken['id_token'])) {
            $data = [
                'amount' => $payment_amount,
                'merchantInvoiceNumber' => $orderID . '-' . time(),
                'token_id' => $grantToken['id_token'],
                'callback_url' => route('bkash.callback'),
            ];
            $paymentCreate = $this->paymentCreate($data);
            if ($paymentCreate['status']) {
                if (isset($paymentCreate['data']['bkashURL'])) {
                    return [
                        'status' => true,
                        'url' => $paymentCreate['data']['bkashURL'],
                        'paymentID' => $paymentCreate['data']['paymentID'],
                    ];
                }
            }
        }
        return [
            'status' => false,
            'url' => '',
            'paymentID' => '',
        ];
    }


    public function DropshipperOrderCheckout(Request $request)
    {

        $user = Auth::user();
        $selectedPaymentMethod = strtolower((string) $request->payment_method);

        // nly dropshippers can place this type of order
        if (!$user || $user->usertype !== 'dropshipper') {
            return back()->with('error', 'Only dropshippers can order!');
        }

        // Request validation
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'selling_price' => 'required|numeric|min:1',
            'name' => 'required|string',
            'mobile' => ['required', new BdPhoneNumber()],
            'address' => 'required',

            'payment_method' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Price validation (selling price must be within min–max range)
        if ($request->selling_price < $product->min_price || $request->selling_price > $product->max_price) {
            return back()->with('error', "Selling price must be between {$product->min_price} and {$product->max_price}");
        }

        // Check stock availability
        if ($product->quantity < $request->qty) {
            return back()->with('error', 'Not enough stock available.');
        }

        // etch delivery zone charge
        $deliveryArea = DeliveryZone::find($request->delivery_area);
        $deliveryCharge = $deliveryArea->zone_charge ?? 0;

        // Calculate totals
        $orderTotal = $request->selling_price * $request->qty;
        $grandTotal = $orderTotal + $deliveryCharge;

        DB::beginTransaction();
        try {
            //Save shipping info
            $shipping = Shipping::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'address' => $request->address,
            ]);

            //Save payment info
            $payment = Payment::create([
                'payment_method' => $selectedPaymentMethod,
            ]);

            $payMethod = match ($selectedPaymentMethod) {
                'bkash' => 1,
                'cod' => 3,
                default => 0,
            };

            // ave order
            $order = Order::create([
                'user_id' => $user->id,
                'shipping_id' => $shipping->id,
                'dropshipper_id' => auth()->id(),
                'payment_id' => $payment->id,
                'order_no' => $this->generateOrderNumber(),
                'delivery_charge' => $deliveryCharge,
                'order_total' => $orderTotal,
                'grand_total' => $grandTotal,
                'status' => 'pending',
                'order_payment' => 'Unpaid',
                'pay_method' => $payMethod,
                'invoice_no' => 'USP_TEMP',
            ]);
            $order->update(['invoice_no' => $this->generateInvoiceNo($order->id)]);

            // save order details
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $request->qty,
                'buy_price' => $product->trade_price,     // Buy from vendor
                'sell_price' => $request->selling_price,   // Reseller selling price
                'dropshipper_profit' => $request->selling_price - $product->sale_price,
                'dropshipper_sell_price' => $request->selling_price,
                'vendor_id' => $product->user_id,
                'reseller_id' => $user->id,
                'color_id' => $request->color_id ?? null,
                'size_id' => $request->size_id ?? null,
            ]);
            // Reduce product stock
            $product->decrement('quantity', $request->qty);

            DB::commit();

            $paymentAmount = ($selectedPaymentMethod === 'cod') ? $deliveryCharge : $grandTotal;
            if (($selectedPaymentMethod === 'bkash' || $selectedPaymentMethod === 'cod') && $paymentAmount > 0) {
                $paymentUrl = $this->processBkashPayment($paymentAmount, $order->id);
                if (is_array($paymentUrl) && ($paymentUrl['status'] ?? false) === true && !empty($paymentUrl['url'])) {
                    return redirect()->away($paymentUrl['url']);
                }
            }

            return redirect()->route('customer.order.details', $order->id)->with('success', 'Order placed successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // Generate invoice no: USP + zero-padded order ID (e.g. USP00044)
    private function generateInvoiceNo(int $orderId = 0): string
    {
        $num = $orderId > 0 ? $orderId : (Order::max('id') ?? 0) + 1;
        return 'USP' . str_pad($num, 5, '0', STR_PAD_LEFT);
    }




}
