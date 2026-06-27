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
use App\Traits\WhatsAppNotifyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;

class CustomerCheckoutController extends Controller
{
    use BkashPaymentTrait, WhatsAppNotifyTrait;

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
            // For guests, name/mobile come from form
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
            'name'          => ['required'],
            'email'         => ['nullable', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
            'mobile'        => ['required', new BdPhoneNumber()],
            'address'       => ['required'],
            'delivery_zone' => ['required', 'exists:delivery_zones,id'],
            'payment_method'=> ['required'],
        ], [
            'delivery_zone.required' => 'Delivery Area অবশ্যই বেছে নিতে হবে।',
            'delivery_zone.exists'   => 'সঠিক Delivery Area বেছে নিন।',
        ]);

        // Get delivery charge — form sends delivery_zone (zone id)
        $deliveryArea = \App\Models\DeliveryZone::find($request->delivery_zone ?? $request->delivery_area);
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
                        'message' => "❌ '{$product->name}' পণ্যের দাম ৳{$minPrice} থেকে ৳{$maxPrice}-এর মধ্যে হতে হবে। Cart আপডেট করুন।"
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

        // ── FREE DELIVERY THRESHOLD ───────────────────────────────────────
        // Orders ≥ 1,000 BDT → delivery is FREE
        // Orders < 1,000 BDT → delivery charge must be paid upfront (bKash)
        //                       regardless of payment method chosen
        $FREE_DELIVERY_THRESHOLD = 1000;
        $free_delivery = ($order_total_amount >= $FREE_DELIVERY_THRESHOLD);

        if ($free_delivery) {
            // Free delivery — no delivery charge
            $delivery_charge   = 0;
            $grand_total_amount = $order_total_amount;
        }

        $selectedPaymentMethod = strtolower((string) $request->payment_method);

        // ── PAYMENT METHOD & AMOUNT ───────────────────────────────────────
        // < 1,000 BDT: delivery charge MUST be paid via bKash (even for COD)
        // ≥ 1,000 BDT: free delivery — pay full amount via bKash OR COD
        if (!$free_delivery) {
            // Sub-threshold: must pay delivery charge upfront via bKash
            $payment_method = 1; // Force bKash
            $payment_amount = $delivery_charge;
            $forced_payment = true;
        } else {
            // Free delivery: normal payment flow
            $payment_method = match ($selectedPaymentMethod) {
                'bkash' => 1,
                'cod'   => 3,
                default => 0,
            };
            $payment_amount = $grand_total_amount;
            $forced_payment = false;
        }

        $order_status         = ($payment_method === 3) ? 'pending' : 'pending';
        // COD + free delivery = 'COD' (will collect product price on delivery)
        // COD + paid delivery = 'Delivery Paid' (delivery paid via bKash, product price on delivery)
        // bKash full = 'Paid'
        if ($free_delivery && $payment_method === 3) {
            $order_payment_status = 'COD';           // Free delivery, collect product price at door
        } elseif (!$free_delivery && $payment_method === 3) {
            $order_payment_status = 'Delivery Paid'; // Delivery paid, collect product price at door
        } else {
            $order_payment_status = 'Unpaid';        // Will be updated to 'Paid' after bKash callback
        }

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

            // ── Seller Share Link tracking ────────────────────────────
            $sellerRefId = session('seller_ref_id');

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
                'seller_ref_id' => $sellerRefId ?? null,
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

            // ── PAYMENT PROCESSING ────────────────────────────────────────
            $payment_url     = null;
            $redirectMessage = '';

            try {
                if ($free_delivery && $selectedPaymentMethod === 'cod') {
                    // FREE DELIVERY + COD → no payment needed, confirm immediately
                    $order->update([
                        'status'         => 'confirmed',
                        'order_payment'  => 'COD',
                    ]);

                    // ── SMS: Order Confirmed (COD + Free Delivery) ──────────
                    try {
                        $this->sendOrderConfirmedSms($order);
                    } catch (\Exception $smsErr) {
                        \Log::warning('COD order SMS failed: ' . $smsErr->getMessage(), [
                            'order_id' => $order->id,
                        ]);
                    }

                    // ── WhatsApp: Notify Admin (COD order) ─────────────────
                    try {
                        $this->notifyAdminNewOrder($order);
                    } catch (\Exception $waErr) {
                        \Log::warning('COD admin WhatsApp failed: ' . $waErr->getMessage());
                    }

                    return response()->json([
                        'status'  => true,
                        'type'    => 'success',
                        'url'     => route('order.track') . '?invoice=' . $order->invoice_no,
                        'message' => 'অর্ডার সফলভাবে সম্পন্ন হয়েছে! আপনার Invoice: ' . $order->invoice_no,
                    ]);
                }

                // Must pay via bKash (full amount for bKash orders, delivery charge for sub-threshold)
                if ($payment_amount > 0) {
                    $payment_url     = $this->processBkashPayment($payment_amount, $order->id);
                    $redirectMessage = $forced_payment
                        ? '১,০০০ টাকার কম অর্ডারে ডেলিভারি চার্জ আগে পরিশোধ করতে হবে।'
                        : 'bKash-এ পেমেন্ট করুন।';
                }

                if ($payment_url && is_array($payment_url) && $payment_url['status'] === true) {
                    return response()->json([
                        'status'  => true,
                        'type'    => 'redirect_payment',
                        'url'     => $payment_url['url'],
                        'message' => $redirectMessage,
                    ]);
                }

                // Payment gateway failed — cancel order and redirect home
                $order->update(['status' => 'canceled']);
                return response()->json([
                    'status'  => false,
                    'type'    => 'payment_failed',
                    'url'     => route('frontend.home'),
                    'message' => 'পেমেন্ট ব্যর্থ হয়েছে। অর্ডারটি বাতিল হয়ে গেছে।',
                ]);

            } catch (\Exception $paymentError) {
                \Log::warning('Payment gateway error: ' . $paymentError->getMessage(), [
                    'order_id'       => $order->id,
                    'payment_method' => $request->payment_method,
                ]);

                // Cancel order on exception
                $order->update(['status' => 'canceled']);
                return response()->json([
                    'status'  => false,
                    'type'    => 'payment_failed',
                    'url'     => route('frontend.home'),
                    'message' => 'পেমেন্ট সম্পন্ন হয়নি। অর্ডারটি বাতিল হয়ে গেছে।',
                ]);
            }

            // Fallback success → order tracking
            return response()->json([
                'status'  => true,
                'type'    => 'success',
                'url'     => route('order.track') . '?invoice=' . $order->invoice_no,
                'message' => 'অর্ডার সফলভাবে সম্পন্ন হয়েছে!',
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
            return back()->with('error', "❌ Selling price ৳{$product->min_price} থেকে ৳{$product->max_price}-এর মধ্যে হতে হবে।");
        }

        // Check stock availability
        if ($product->quantity < $request->qty) {
            return back()->with('error', 'Not enough stock available.');
        }

        // ── Delivery Zone ──────────────────────────────────────────────
        $deliveryArea   = DeliveryZone::find($request->delivery_area);
        $deliveryCharge = $deliveryArea ? (float)$deliveryArea->zone_charge : 0;

        // Calculate totals
        $orderTotal = (float)$request->selling_price * (int)$request->qty;

        // ── FREE DELIVERY (same rule as customer — ≥৳1,000) ──────────
        $FREE_DELIVERY_THRESHOLD = 1000;
        $isFreeDelivery = ($orderTotal >= $FREE_DELIVERY_THRESHOLD);
        if ($isFreeDelivery) {
            $deliveryCharge = 0;
        }

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

    // Generate invoice no from DB settings (e.g. USP00044)
    private function generateInvoiceNo(int $orderId = 0): string
    {
        $num = $orderId > 0 ? $orderId : (Order::max('id') ?? 0) + 1;

        try {
            $setting = \App\Models\Setting::first();
            $prefix = strtoupper(trim($setting->invoice_prefix ?? 'USP'));
            $digits = (int)($setting->invoice_digits ?? 5);
            $startNo = (int)($setting->invoice_start_no ?? 1);
            // Add start offset so invoice numbers don't restart from 1
            $invoiceNum = $num + $startNo - 1;
        } catch (\Exception $e) {
            $prefix = 'USP';
            $digits = 5;
            $invoiceNum = $num;
        }

        return $prefix . str_pad($invoiceNum, $digits, '0', STR_PAD_LEFT);
    }




}
