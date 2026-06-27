<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Logo;
use App\Rules\BdPhoneNumber;

use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use App\Models\DeliveryZone;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Traits\BkashPaymentTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class DashboardController extends Controller
{
    use BkashPaymentTrait;
    
    public function dashboard()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $data['user'] = Auth::user();
        return view('frontend.single_page.customer-dashboard', $data);
    }

    public function editProfile()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $data['editData'] = User::find(Auth::user()->id);
        return view('frontend.single_page.customer-edit-profile', $data);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $this->validate($request, [
            'name'  => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ── Phone & Email are READONLY — never update ────────────────────
        $user->name    = $request->name;
        $user->address = $request->address;
        $user->gender  = $request->gender;

        // Profile image
        if ($request->file('image')) {
            $file = $request->file('image');
            if (!empty($user->image)) {
                @unlink(public_path('upload/user_images/' . $user->image));
            }
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $user->image = $filename;
        }
        $user->save();
        return redirect()->route('dashboard')->with('success', 'Profile সফলভাবে আপডেট হয়েছে!');
    }

    public function passwordChange()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        return view('frontend.single_page.customer-password-change', $data);
    }

    public function passwordUpdate(Request $request)
    {
        if (Auth::attempt(['id' => Auth::user()->id, 'password' => $request->current_password])) {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->route('dashboard')->with('success', 'Your password changed successfully !!!');
        } else {
            return redirect()->back()->with('error', 'Sorry! Your current password does not match !!!');
        }
    }

    public function payment()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        return view('frontend.single_page.customer-payment', $data);
    }

    public function paymentStore(Request $request)
    {
        // Log incoming request for debugging
        Log::info('Payment Store Request', [
            'product_id' => $request->product_id,
            'payment_method' => $request->payment_method,
            'order_total' => $request->order_total,
            'user_id' => Auth::id(),
            'cart_count' => Cart::count()
        ]);

        if (is_null($request->product_id)) {
            Log::warning('No product_id in payment request');
            return redirect()->back()->with('error', 'Please add any product for payment!');
        }

        $request->validate([
            'payment_method' => 'required',
        ]);

        $orderID = null;

        try {
            $deliverycharge = Session::get('delivery_charge', 0);
            $del = intval($deliverycharge);

            // Check if cart is empty
            if (Cart::count() == 0) {
                Log::warning('Cart is empty during payment');
                return redirect()->route('product.list')->with('error', 'Your cart is empty!');
            }

            // Validate stock before starting transaction
            foreach (Cart::content() as $content) {
                $product = Product::find($content->id);
                if (!$product || $product->quantity < $content->qty) {
                    Log::warning('Product out of stock', ['product_id' => $content->id, 'required' => $content->qty, 'available' => $product->quantity ?? 0]);
                    return redirect()
                        ->route('product.list')
                        ->with('error', "Product '{$content->name}' is out of stock or has insufficient quantity.");
                }
            }

            DB::beginTransaction();

            // Create Payment
            $payment = new Payment();
            $payment->payment_method = $request->payment_method;
            $payment->save();

            Log::info('Payment created', ['payment_id' => $payment->id]);

            // Create Order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->shipping_id = Session::get('shipping_id');
            $order->payment_id = $payment->id;
            $order->delivery_charge = $del;
            $order->order_no = $this->generateOrderNumber();
            $order->coupon_discount = Session::get('coupon_discount', 0);
            $order->order_total = $request->order_total;
            $order->grand_total = $request->order_total + $del - Session::get('coupon_discount', 0);
            $order->status = ($request->payment_method == 'Cash on Delivery') ? 'pending' : 'initiated';
            $order->area_id = $this->getAreaID();
            $order->save();

            $orderID = $order->id;
            $invoice = 'USP' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
            $order->update(['invoice_no' => $invoice]);

            Log::info('Order created', ['order_id' => $orderID, 'order_no' => $order->order_no]);

            // Create Order Details
            foreach (Cart::content() as $content) {
                $product = Product::find($content->id);

                if ($product && $product->quantity >= $content->qty) {
                    
                    // Vendor commission logic
                    $productOwner = User::find($product->user_id);
                    if ($productOwner && $productOwner->usertype == 'vendor' && $productOwner->payment_status == 2) {
                        $orderAmt = $request->order_total - $del;
                        $sellerCommission = $orderAmt * 0.2;
                        $vendorAmt = $orderAmt - $sellerCommission;
                        $productOwner->balance = ($productOwner->balance ?? 0) + $vendorAmt;
                        $productOwner->save();
                    }

                    // Update stock
                    $product->quantity -= $content->qty;
                    $product->save();

                    // Save order detail
                    $orderDetail = OrderDetail::create([
                        'order_id' => $orderID,
                        'product_id' => $content->id,
                        'color_id' => $content->options->color_id ?? 0,
                        'color_name' => $content->options->color_name ?? 'N/A',
                        'size_id' => $content->options->size_id ?? 0,
                        'size_name' => $content->options->size_name ?? 'N/A',
                        'quantity' => $content->qty,
                        'buy_price' => $product->trade_price ?? 0,
                        'sell_price' => $content->price,
                        'vendor_id' => $product->user_id ?? null,
                    ]);

                    Log::info('Order detail created', ['order_detail_id' => $orderDetail->id, 'product_id' => $content->id]);
                }
            }

            DB::commit();

            Log::info('Order transaction committed successfully', ['order_id' => $orderID]);

            $coupon = Session::get('coupon_discount', 0);

            // Handle Payment
            $amount = $request->order_total + $del - $coupon;
            
            if ($request->payment_method == 'Bkash') {
                $payment_url = $this->processBkashPayment($amount, $orderID);
                
                if (isset($payment_url['status']) && $payment_url['status'] === true) {
                    return redirect($payment_url['url']);
                } else {
                    return redirect()->route('product.list')->with('error', $payment_url['message'] ?? 'Payment gateway error!');
                }
            } elseif ($request->payment_method == 'Cash on Delivery') {
                // For COD, redirect to success page directly
                $this->clearCartAndSession();
                Log::info('COD order completed', ['order_id' => $orderID]);
                return redirect()->route('success.page')->with('success', 'Order placed successfully! Order ID: ' . $orderID);
            } else {
                DB::rollBack();
                Log::error('Invalid payment method', ['method' => $request->payment_method]);
                return redirect()->back()->with('error', 'Invalid payment method selected!');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Processing Failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'request' => $request->all()
            ]);
            return redirect()->route('product.list')->with('error', 'Something went wrong during order processing: ' . $e->getMessage());
        }
    }

    private function clearCartAndSession()
    {
        Cart::destroy();
        Session::forget(['coupon_discount', 'shipping_id', 'delivery_charge', 'areaID']);
    }
    public function sellerPaymentStore(Request $request)
    {
        if ($request->product_id == null) {
            return redirect()->back()->with('message', 'Please add any product for payment !!!');
        } else {
            $this->validate($request, [
                'payment_method' => 'required',
            ]);
            try {
                $deliverycharge = Session::get('delivery_charge', 0);
                $del = intval($deliverycharge);
                foreach (Cart::content() as $content) {
                    $product = Product::find($content->id);
                    if (!$product || $product->quantity < $content->qty) {
                        return redirect()
                            ->route('product.list')
                            ->with('error', "Product '{$product->name}' is out of stock or has insufficient quantity.");
                    }
                }
                DB::transaction(function () use ($request, &$orderID, &$del) {
                    $payment = new Payment();
                    $payment->payment_method = $request->payment_method;
                    $payment->save();
                    $order = new Order();
                    $order->user_id = Auth::id(); // null for guests - OK
                    $order->shipping_id = Session::get('shipping_id');
                    $order->payment_id = $payment->id;
                    $order->delivery_charge = $del;
                    $order_data = Order::orderBy('id', 'DESC')->first();
                    if ($order_data == null) {
                        $firstReg = '0';
                        $order_no = $firstReg + 1;
                    } else {
                        $order_data = Order::orderBy('id', 'DESC')->first()->order_no;
                        $order_no = $order_data + 1;
                    }
                    $order->order_no = $order_no;
                    $order->coupon_discount = Session::get('coupon_discount', 0);
                    $order->order_total = $request->order_total;
                    $order->status = ($request->payment_method == 'Bkash') ? 'initiated' : 'pending';
                    $order->save();
                    $orderID = $order->id;
                    $contents = Cart::content();
                    foreach ($contents as $content) {
                        $product = Product::find($content->id);
                        if ($product && $product->quantity >= $content->qty) {
                            $userId = $product->user_id;
                            $user = User::where('id', $userId)->first();
                            if ($user && $user->usertype == 'vendor') {
                                $orderAmt = $request->order_total - $del;
                                $sellerCommission = $orderAmt * 0.2; // 20% commission
                                $vendorAmt = $orderAmt - $sellerCommission;
                                // Ensure balance is initialized
                                $user->balance = ($user->balance ?? 0) + $vendorAmt;
                                $user->save();
                            }
                        }
                        // Update stock
                        $product->quantity -= $content->qty;
                        $product->save();
                        $shop_id = $content->options->shopID;
                        OrderDetail::create([
                            'order_id' => $orderID,
                            'product_id' => $content->id,
                            'color_id' => $content->options->color_id,
                            'color_name' => $content->options->color_name,
                            'size_id' => $content->options->size_id,
                            'size_name' => $content->options->size_name,
                            'quantity' => $content->qty,
                        ]);
                        $orderShopSaveData = Order::find($orderID);
                        $orderShopSaveData->update([
                            'shop_id' => $shop_id,
                        ]);
                    }
                });
                DB::commit();
                $coupon = Session::get('coupon_discount', 0);
                // Handle Payment Methods
                if ($request->payment_method == 'Bkash') {
                    $payment_url = $this->processBkashPayment($request->order_total + $del - $coupon, $orderID);
                    if ($payment_url['status'] == true) {
                         return redirect($payment_url['url']);
                    } else {
                         // Cancel order if payment method failed
                         $createdOrder = Order::find($orderID);
                         if($createdOrder) {
                             $createdOrder->status = 'canceled';
                             $createdOrder->save();
                         }
                         return redirect()->route('product.list')->with('error', $payment_url['message'] ?? 'Payment initiation failed.');
                    }
                } else {
                    $this->clearCartAndSession(); // For COD or others
                    $payment_url = $this->processBkashPayment($del, $orderID);
                     if ($payment_url['status'] == true) {
                         return redirect($payment_url['url']);
                    } else {
                        return redirect()->route('product.list')->with('error', 'Something error!');
                    }
                }
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
                Log::error('Order Processing Failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Something went wrong during order processing. Please try again.');
            }
        }
    }
    private function getAreaID()
    {
        $string = Session::get('areaID');
        if ($string) {
            $exString = explode('-', $string);
            return isset($exString[0]) && is_numeric($exString[0]) ? (int) $exString[0] : 4;
        }
        return 4; // Default value
    }

    /**
     * Generate the next order number
     */
    private function generateOrderNumber()
    {
        $lastOrder = Order::orderBy('id', 'DESC')->first();
        return $lastOrder ? $lastOrder->order_no + 1 : 1;
    }

    /**
     * Process Bkash Payment
     */
    private function processBkashPayment($orderTotal, $orderID)
    {
        // Fetch Grant Token
        $grantToken = $this->grantToken();
        if (isset($grantToken['id_token'])) {
            $data = [
                'amount' => $orderTotal,
                'merchantInvoiceNumber' => $orderID . '-' . time(),
                'token_id' => $grantToken['id_token'],
                'callback_url' => route('bkash.callback'),
            ];
            // Create Payment Request
            $paymentCreate = $this->paymentCreate($data);
            if ($paymentCreate['status']) {
                if (isset($paymentCreate['data']['bkashURL'])) {
                    // Redirect to Bkash Payment Page
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

    public function orderList()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $data['orders'] = Order::where('user_id', Auth::user()->id)
            ->where('status', '!=', 'initiated')
            ->orderBy('id', 'DESC')
            ->get();

        return view('frontend.single_page.customer-order', $data);
    }

    public function orderDetails($id)
    {
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $orderData = Order::find($id);
        $data['orders'] = Order::where('id', $orderData->id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if ($data['orders'] == false) {
            return redirect()->back()->with('error', 'Do not try to be over smart !!!');
        } else {
            $data['logo'] = Logo::first();
            $data['contact'] = Contact::first();
            $data['order'] = Order::with(['order_details'])
                ->where('id', $orderData->id)
                ->where('user_id', Auth::user()->id)
                ->first();
            return view('frontend.single_page.customer-order-details', $data);
        }
    }

    // Seller Code here................
    public function sellerDashboard()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $data['user'] = Auth::user();
        return view('frontend.seller_shop.seller-customer-dashboard', $data);
    }

    public function sellerEditProfile()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $data['editData'] = User::find(Auth::user()->id);
        return view('frontend.seller_shop.seller-customer-edit-profile', $data);
    }

    public function sellerUpdateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'mobile' => ['required', 'unique:users,mobile,' . $user->id, new BdPhoneNumber()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->gender = $request->gender;
        if ($request->file('image')) {
            $file = $request->file('image');
            @unlink(public_path('upload/user_images/' . $user->image));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $user['image'] = $filename;
        }
        $user->save();
        return redirect()->route('seller.customer.dashboard')->with('success', 'Profile update successfully !!!');
    }

    public function sellerPasswordChange()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        return view('frontend.seller_shop.seller-customer-password-change', $data);
    }

    public function sellerPasswordUpdate(Request $request)
    {
        if (Auth::attempt(['id' => Auth::user()->id, 'password' => $request->current_password])) {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->route('seller.customer.dashboard')->with('success', 'Your password changed successfully !!!');
        } else {
            return redirect()->back()->with('error', 'Sorry! Your current password does not match !!!');
        }
    }

    public function sellerPayment()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        return view('frontend.seller_shop.seller-customer-payment', $data);
    }

    public function sellerOrderList()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $data['orders'] = Order::where('user_id', Auth::user()->id)
            ->where('status', '!=', 'initiated')
            ->orderBy('id', 'DESC')
            ->get();
        return view('frontend.seller_shop.seller-customer-order', $data);
    }

    public function sellerOrderDetails($id)
    {
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        $orderData = Order::find($id);
        $data['orders'] = Order::where('id', $orderData->id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if ($data['orders'] == false) {
            return redirect()->back()->with('error', 'Do not try to be over smart !!!');
        } else {
            $data['logo'] = Logo::first();
            $data['contact'] = Contact::first();
            $data['order'] = Order::with(['order_details'])
                ->where('id', $orderData->id)
                ->where('user_id', Auth::user()->id)
                ->first();
            return view('frontend.seller_shop.seller-customer-order-details', $data);
        }
    }
}
