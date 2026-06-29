<?php

namespace App\Http\Controllers\Frontend;
use Carbon\Carbon;
use App\Models\Logo;
use App\Models\User;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Shipping;
use App\Traits\SendSmsTrait;
use App\Rules\BdPhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    use SendSmsTrait;
    public function customerLogin()
    {
        if (auth()->user()) {
            if (auth()->user()->usertype === 'customer') {
                return redirect()->route('kafi');
            }
            if (auth()->user()->usertype === 'vendor') {
                return redirect()->route('seller.dashboard');
            }
            if (auth()->user()->usertype === 'seller') {
                return redirect()->route('seller.dashboard');
            }
        }
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        return view('frontend.single_page.customer-login', $data);
    }

    public function customerSignup()
    {
        if (auth()->user()) {
            if (auth()->user()->usertype === 'customer') {
                return redirect()->route('kafi');
            }
            if (auth()->user()->usertype === 'vendor') {
                return redirect()->route('seller.dashboard');
            }
            if (auth()->user()->usertype === 'seller') {
                return redirect()->route('seller.dashboard');
            }
        }
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        return view('frontend.single_page.customer-signup', $data);
    }

    public function signupStore(Request $request)
    {
        $mobileRules = ['required', 'unique:users,mobile', new BdPhoneNumber()];
        if (in_array($request->input('otp_delivery_method'), ['sms', 'both'])) {
            $mobileRules[] = 'regex:/^(\+?88|0088)?01[0-9]{9}$/';
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'mobile' => $mobileRules,
            'password' => 'min:9|required_with:confirmation_password|same:confirmation_password',
            'confirmation_password' => 'min:9',
            'otp_delivery_method' => 'required|in:email,sms,both',
        ]);

        do {
            $refer_code = Str::upper(Str::random(8));
        } while (User::where('refer_code', $refer_code)->exists());

        $code = rand(100000, 999999);
        $user = new User();
        $user->refer_code = $refer_code;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = Hash::make($request->password);
        $user->code = $code;
        $user->status = 0; // 0 means inactive and 1 means active and 2 means suspended
        $user->usertype = 'customer';
        $user->otp_delivery_method = $request->otp_delivery_method;
        $user->mobile = preg_replace('/\D+/', '', $request->mobile);
        $user->email_verified_at = NULL;
        $user->save();

        $smsMessage = "Hello Dear $user->name, Your U SuperShop verification code is: $code. The code will expire in 5 minutes. Please do NOT share your OTP or PIN with others.";

        if (in_array($user->otp_delivery_method, ['sms', 'both'])) {
            $mobile = $this->normalizeBangladeshMobileNumber($user->mobile);
            $smsResponse = $this->send_rapid_message($mobile, $smsMessage);
            if (!isset($smsResponse['status']) || strtolower((string) $smsResponse['status']) !== 'success') {
                Log::error('Customer OTP SMS failed', [
                    'user_id' => $user->id,
                    'mobile' => $mobile,
                    'response' => $smsResponse,
                ]);
                
                if (!empty($user->email)) {
                    Mail::send('frontend.emails.verify-email', ['email' => $user->email, 'code' => $code], function ($message) use ($user) {
                        $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
                        $message->to($user->email);
                        $message->subject(env('APP_NAME') . ' | OTP Verification');
                    });
                    
                    Session::flash('warning', 'SMS delivery is currently unavailable, so we sent the OTP to your email instead.');
                }
            }
        }

        if (in_array($user->otp_delivery_method, ['email', 'both'])) {
            Mail::send('frontend.emails.verify-email', ['email' => $user->email, 'code' => $code], function ($message) use ($user) {
                $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
                $message->to($user->email);
                $message->subject(env('APP_NAME') . ' | OTP Verification');
            });
        }

        $encrypted_id = Crypt::encrypt($user->id);
        return redirect()->route('verify.index', $encrypted_id)->with('success', 'You have successfully signed up, Please verify your OTP');
    }

    public function emailVerify()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        return view('frontend.single_page.email-verify', $data);
    }
    public function SendCustomerOtp()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        return view('frontend.single_page.send-otp', $data);
    }
    public function SendCustomerOtpSubmit(Request $request)
    {
        $this->validate($request, ['context' => 'required']);
        $checkData = User::where('email', $request->context)->orWhere('mobile', $request->context)->first();
        if (!$checkData) {
            return redirect()->back()->with('error', 'User not found with the given email or mobile.');
        }
        $code = rand(000000, 999999);
        Session::put('verify_context', $request->context);
        if ($request->context === $checkData->mobile) {
            $mobile = $this->normalizeBangladeshMobileNumber($checkData->mobile);
            $smsMessage = "Hello Dear $checkData->name, Your U SuperShop verification code is: $code. The code will expire in 5 minutes. Please do NOT share your OTP or PIN with others.";
            $smsResponse = $this->send_rapid_message($mobile, $smsMessage);
            if (!isset($smsResponse['status']) || $smsResponse['status'] !== 'success') {
                Log::error('SMS sending failed', ['response' => $smsResponse]);
            }
        }
        if ($request->context === $checkData->email) {
            try {
                Mail::send('frontend.emails.verify-email', ['email' => $checkData->email, 'code' => $code], function ($message) use ($checkData) {
                    $message->from(env('MAIL_USERNAME'), 'usupershop');
                    $message->to($checkData->email);
                    $message->subject('Please verify your email address');
                });
            } catch (\Exception $e) {
                Log::error('Email sending failed', ['error' => $e->getMessage()]);
            }
        }
        $checkData->status = 1;
        $checkData->code = $code;
        $checkData->email_verified_at = Carbon::now()->addMinutes(5); // Optional, for real expiry
        $checkData->save();
        return redirect()->route('email.verify')->with('success', 'Verification code sent.
         Please check your email or phone.');
    }

    public function verifyStore(Request $request)
    {
        $this->validate($request, [
            'context' => 'required',
            'code' => 'required',
        ]);
        $checkData = User::where('email', $request->context)->orWhere('mobile', $request->context)->first();
        if ($checkData) {
            $checkData->status = 1;
            $checkData->email_verified_at = Carbon::now();
            $checkData->save();
            return redirect()->route('customer.login')->with('success', 'You have successfully verified, Please login now');
        } else {
            return redirect()->back()->with('error', 'Sorry! email or verification code does not match !!!');
        }
    }

    public function logout2(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }


    public function checkOut()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        
        // Fetch Cart Data for new Checkout UI
        $cookie_id = request()->cookie('customer_cookie_id');
        $cart_data = \App\Models\Cart::with(['product', 'product_color.color', 'product_size.size', 'product.variants'])->where('cookie_id', $cookie_id)->get();
        
        if ($cart_data->isEmpty()) {
            return redirect()->route('shopping.cart')->with('error', 'Your cart is empty!');
        }

        $order_total_amount = 0;
        foreach ($cart_data as $cart) {
            $product = $cart->product;
            if (!$product) continue;
            
            $variantPrice = $product->price;
            if ($cart->color_id || $cart->size_id) {
                $prductColor = \App\Models\ProductColor::find($cart->color_id);
                $productSize = \App\Models\ProductSize::find($cart->size_id);
                $variant = \App\Models\ProductVariant::where('product_id', $product->id)
                    ->when($cart->color_id, fn($q) => $q->where('color_id', $prductColor?->color_id))
                    ->when($cart->size_id, fn($q) => $q->where('size_id', $productSize?->size_id))
                    ->first();
                if ($variant && $variant->additional_price) {
                    $variantPrice += $variant->additional_price;
                }
            }
            if (!empty($product->discount)) {
                if ($product->discount_type == 1) {
                    $variantPrice -= ($variantPrice * $product->discount / 100);
                } else {
                    $variantPrice -= $product->discount;
                }
            }
            if (auth()->check() && auth()->user()->usertype == 'dropshipper' && $cart->drop_selling_price > 0) {
                $variantPrice = $cart->drop_selling_price;
            }
            $order_total_amount += ($variantPrice * $cart->qty);
        }

        $data['cart_data'] = $cart_data;
        $data['order_total_amount'] = $order_total_amount;

        return view('frontend.single_page.customer-checkout', $data);
    }

    public function checkoutStore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'mobile' => ['required', new BdPhoneNumber()],
            'address' => 'required',
        ]);

        Log::info('Checkout Store Request', [
            'user_id' => Auth::id(),
            'name' => $request->name,
            'mobile' => $request->mobile,
            'delivery_charge' => $request->delivery_charge
        ]);

        $checkout = new Shipping();
        $checkout->user_id = Auth::id() ?? 0;
        $checkout->name = $request->name;
        $checkout->email = $request->email;
        $checkout->mobile = $request->mobile;
        $checkout->address = $request->address;
        $checkout->save();
        
        Session::put('shipping_id', $checkout->id);
        // Set default delivery charge if not provided
        $deliveryCharge = $request->delivery_charge ?? 60; // Default 60 BDT
        Session::put('delivery_charge', $deliveryCharge);
        
        Log::info('Shipping created', [
            'shipping_id' => $checkout->id,
            'delivery_charge' => $deliveryCharge
        ]);
        
        return redirect()->route('customer.payment')->with('success', 'Shipping inserted successfully !!!');
    }

    //Seller Customer Login Here........................

    public function sellerCustomerLogin(Request $request)
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        return view('frontend.seller_shop.seller-customer-login', $data);
    }

    public function sellerCustomerSignup()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        return view('frontend.seller_shop.seller-customer-signup', $data);
    }

    public function sellerSignupStore(Request $request)
    {
        DB::transaction(function () use ($request) {
            $mobileRules = ['required', 'unique:users,mobile', new BdPhoneNumber()];
            if (in_array($request->input('otp_delivery_method'), ['sms', 'both'])) {
                $mobileRules[] = 'regex:/^(\+?88|0088)?01[0-9]{9}$/';
            }

            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'mobile' => $mobileRules,
                'password' => 'min:9|required_with:confirmation_password|same:confirmation_password',
                'confirmation_password' => 'min:9',
                'otp_delivery_method' => 'required|in:email,sms,both',
            ]);

            $code = rand(000000, 999999);
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = preg_replace('/\D+/', '', $request->mobile);
            $user->password = Hash::make($request->password);
            $user->code = $code;
            $user->status = 0;
            $user->usertype = 'customer';
            $user->otp_delivery_method = $request->otp_delivery_method;
            $user->save();
            $smsMessage = "Hello Dear $user->name ,Your U SuperShop verification code is: $user->code .The code will expire in 5 minutes. Please do not share your OTP or PIN with others";

            if (in_array($user->otp_delivery_method, ['sms', 'both'])) {
                $mobile = $this->normalizeBangladeshMobileNumber($user->mobile);
                $smsResponse = $this->send_rapid_message($mobile, $smsMessage);
                if (!isset($smsResponse['status']) || $smsResponse['status'] !== 'success') {
                    Log::error('Seller OTP SMS failed', [
                        'user_id' => $user->id,
                        'mobile' => $mobile,
                        'response' => $smsResponse,
                    ]);
                    
                    if (!empty($user->email)) {
                        Mail::send('frontend.emails.verify-email', ['email' => $user->email, 'code' => $otp], function ($message) use ($user) {
                            $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
                            $message->to($user->email);
                            $message->subject(env('APP_NAME') . ' | OTP Verification');
                        });
                        
                        Session::flash('warning', 'SMS delivery is currently unavailable, so we sent the OTP to your email instead.');
                    }
                }
            }

            if (in_array($user->otp_delivery_method, ['email', 'both'])) {
                $data = [
                    'email' => $request->email,
                    'code' => $code,
                ];

                Mail::send('frontend.emails.verify-email', $data, function ($message) use ($data) {
                    $message->from(env('MAIL_USERNAME'), 'usupershop');
                    $message->to($data['email']);
                    $message->subject('Please verify your email address');
                });
            }
        });

        return redirect()->route('seller.email.verify')->with('success', 'You have successfully signed up, Please verify your email');
    }

    public function sellerOtpVerify()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        return view('frontend.seller_shop.seller-otp-verify', $data);
    }
    public function sellerVerify()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        return view('frontend.seller_shop.seller-verify', $data);
    }
    public function sellerVerifyOtp(Request $request)
    {
        $code = rand(000000, 999999);
        $user = User::where('email', $request->content)->orWhere('mobile', $request->content)->first();
        if (!$user) {
            return back()->with('error', 'User not found with provided email or mobile.');
        }
        Session::put('seller_verify', $request->content);
        // Send SMS if content is mobile number
        if ($request->content == $user->mobile) {
            $mobile = $this->normalizeBangladeshMobileNumber($user->mobile);
            $smsMessage = "Hello Dear $user->name, Your U SuperShop verification code is: $code . The code will expire in 5 minutes. Please do not share your OTP or PIN with others";
            $smsResponse = $this->send_rapid_message($mobile, $smsMessage);

            if (!isset($smsResponse['status']) || $smsResponse['status'] !== 'success') {
                Log::error('SMS sending failed', ['response' => $smsResponse]);
            }
        }
        // Save verification code and update user
        $user->status = 1;
        $user->code = $code;
        $user->email_verified_at = Carbon::now();
        $user->save();
        return redirect()->route('seller.kafi.verify')->with('success', 'You have successfully verified. Please login now.');
    }

    public function sellerVerifyKafi(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'code' => 'required',
        ]);
        // Find user by email or mobile
        $checkData = User::where('email', $request->email)->orWhere('mobile', $request->email)->first();

        // Check if user exists and code matches
        if ($checkData && $checkData->code === $request->code) {
            $checkData->email_verified_at = Carbon::now();
            $checkData->update();
            DB::table('password_resets')->insert([
                'email' => $checkData->email,
                'mobile' => $checkData->mobile,
                'otp' => $checkData->code,
                'created_at' => Carbon::now(),
            ]);
            return redirect()->route('seller.login')->with('success', 'You have successfully verified, Please login now');
        } else {
            return redirect()->back()->with('error', 'Sorry! Email or verification code does not match.');
        }
    }
    public function sellerCheckOut()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();
        return view('frontend.seller_shop.customer-checkout', $data);
    }

    public function sellerCheckoutStore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'mobile' => ['required', new BdPhoneNumber()],
            'address' => 'required',
        ]);

        $checkout = new Shipping();
        $checkout->user_id = Auth::user()->id;
        $checkout->name = $request->name;
        $checkout->email = $request->email;
        $checkout->mobile = $request->mobile;
        $checkout->address = $request->address;
        $checkout->save();
        Session::put('shipping_id', $checkout->id);
        Session::put('areaID', $request->area_id);
        Session::put('delivery_charge', $request->delivery_charge);
        return redirect()->route('seller.customer.payment')->with('success', 'Shipping inserted successfully !!!');
    }
}
