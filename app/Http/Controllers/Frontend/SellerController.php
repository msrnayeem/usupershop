<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Logo;
use App\Models\Product;
use App\Models\SellerEmail;
use App\Models\Slider;
use App\Models\User;
use App\Rules\BdPhoneNumber;
use App\Traits\SendSmsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt; 

class SellerController extends Controller
{
    use SendSmsTrait;
    public function sellerLogin()
    {
        if(auth()->user()){
            if(auth()->user()->usertype === 'customer'){
                return redirect()->route('kafi');
            }
            if(auth()->user()->usertype === 'vendor'){
                return redirect()->route('seller.dashboard');
            }
            if(auth()->user()->usertype === 'seller'){
                return redirect()->route('seller.dashboard');
            }
            if(auth()->user()->usertype === 'dropshipper'){
                return redirect()->route('seller.dashboard');
            }
        }
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        return view('frontend.seller.seller-login', $data);
    }

    public function sellerSignup()
    {
        if(auth()->user()){
            if(auth()->user()->usertype === 'customer'){
                return redirect()->route('kafi');
            }
            if(auth()->user()->usertype === 'vendor'){
                return redirect()->route('seller.dashboard');
            }
            if(auth()->user()->usertype === 'seller'){
                return redirect()->route('seller.dashboard');
            }
        }
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        return view('frontend.seller.seller-signup', $data);
    }

    public function sellerStore(Request $request)
    {
        $mobileRules = ['required', 'unique:users,mobile', new BdPhoneNumber()];
        if (in_array($request->input('otp_delivery_method'), ['sms', 'both'])) {
            $mobileRules[] = 'regex:/^(\+?88|0088)?01[0-9]{9}$/';
        }

        $this->validate($request, [
            'name' => 'required',
            'account_type' => 'required',
            'subscription_plan' => 'required',
            'shop_name' => 'required',
            'email'                 => 'required|unique:users,email',
            'mobile'                => $mobileRules,
            'password'              => 'min:6|required_with:confirmation_password|same:confirmation_password',
            'confirmation_password' => 'min:6',
            'otp_delivery_method'   => 'required|in:email,sms,both',
            'address'               => 'required',
            'terms'                 => 'required',
            'refer_code'            => ['nullable', 'exists:users,refer_code'],
            'coupon_code'           => ['nullable'],
        ], [
            'refer_code.exists'  => '❌ এই Refer Code-টি সঠিক নয়। আবার চেক করুন।',
            'coupon_code.exists' => '❌ কুপন কোড সঠিক নয়।',
        ]);

        try {

            DB::beginTransaction();

            do {
                $refer_code = Str::upper(Str::random(8));
            } while (User::where('refer_code', $refer_code)->exists());

            $otp = rand(100000, 999999);
            $user = new User();
            $user->refer_code = $refer_code;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->subscription_plan = strtotime($request->subscription_plan);
            $user->mobile = preg_replace('/\D+/', '', $request->mobile);
            $user->password = Hash::make($request->password);
            $user->code = $otp;
            $user->status = 0;  // 0 means inactive and 1 means active and 2 means suspended
            $user->payment_status = 0; // 0 unpaid and 1 paid
            $user->account_type = $request->account_type;
            $user->shop_name = $request->shop_name;
            $user->terms = $request->terms;
            $user->usertype = $user->account_type;
            $user->otp_delivery_method = $request->otp_delivery_method;
            $user->address = $request->address;
            $user->email_verified_at = NULL;

            // ── Refer Code: find referrer ──────────────────────────────
            // Form sends 'refer_code' — fix consistent field name
            $referCode = trim($request->refer_code ?? $request->code ?? '');
            if (!empty($referCode)) {
                $reseller = User::where('refer_code', $referCode)
                    ->whereIn('usertype', ['seller', 'vendor', 'dropshipper'])
                    ->where('status', 1)           // referrer must be active
                    ->where('payment_status', 1)   // referrer must have paid
                    ->first();

                if ($reseller) {
                    $user->reseller_id = $reseller->id;
                    $reseller->is_reseller = 1;
                    $reseller->save();
                    Log::info('Refer code accepted', [
                        'new_user'  => $request->email,
                        'referrer'  => $reseller->id,
                        'code'      => $referCode,
                    ]);
                } else {
                    Log::info('Refer code not valid/active', ['code' => $referCode]);
                }
            }

            // ── Coupon Code (Optional) ─────────────────────────────────
            $couponDiscount = 0;
            $couponCode     = trim($request->coupon_code ?? '');
            if (!empty($couponCode)) {
                $coupon = \App\Models\Coupon::where('promoCode', $couponCode)->first();
                $today  = now()->toDateString();
                $usertype = $request->account_type;

                $couponValid = $coupon
                    && $coupon->status == 1
                    && $today >= $coupon->start_date
                    && $today <= $coupon->end_date
                    && $coupon->available > 0
                    && in_array($coupon->availableFor, [2, 4, 3, 5]); // All, Seller, Vendor, Dropshipper

                if ($couponValid) {
                    // Store coupon info in session to use after payment
                    \Session::put('reg_coupon_code', $couponCode);
                    \Session::put('reg_coupon_id',   $coupon->id);
                    $coupon->decrement('available');
                    Log::info('Registration coupon applied', ['code' => $couponCode, 'user' => $request->email]);
                }
            }

            $user->save();

            Session::put('seller_verify', $request->mobile);

            SellerEmail::updateOrCreate(['seller_email' => $user->email], ['code' => $refer_code]);

            $smsMessage = "Hello Dear $user->name, Your U SuperShop verification code is: $otp. The code will expire in 5 minutes. Please do NOT share your OTP or PIN with others.";

            if (in_array($user->otp_delivery_method, ['sms', 'both'])) {
                $mobile = $this->normalizeBangladeshMobileNumber($user->mobile);
                $smsResponse = $this->send_rapid_message($mobile, $smsMessage);
                if (!isset($smsResponse['status']) || strtolower((string) $smsResponse['status']) !== 'success') {
                    Log::error('Seller registration OTP SMS failed', [
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
                Mail::send('frontend.emails.verify-email', ['email' => $user->email, 'code' => $otp], function ($message) use ($user) {
                    $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
                    $message->to($user->email);
                    $message->subject(env('APP_NAME').' | OTP Verification');
                });
            }


            DB::commit();

            $encrypted_id = Crypt::encrypt($user->id);
            return redirect()->route('verify.index', $encrypted_id)->with('success', 'You have successfully signed up, Please verify your OTP');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Registration failed. Please try again.');
        }
    }

    public function sellerAccountVerifyCode()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        return view('frontend.seller.seller-email-verify', $data);
    }
    public function sellerForgetPassword()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        return view('frontend.seller.forget_password', $data);
    }
    public function sellerOtp()
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        return view('frontend.seller.send-seller-otp', $data);
    }
    public function sellerEmailVerifyCodeSave(Request $request)
    {
        $code = rand(000000, 999999);
        $user = User::where('email', $request->input('content'))->orWhere('mobile', $request->input('content'))->first();
        if (!$user) {
            return back()->with('error', 'User not found with provided email or mobile.');
        }
        Session::put('seller_verify', $request->input('content'));
        // Send SMS if verifying via mobile
        if ($request->input('content') == $user->mobile) {
            $mobile = $this->normalizeBangladeshMobileNumber($user->mobile);
            $smsMessage = "Hello Dear $user->name, Your U SuperShop verification code is: $code. The code will expire in 5 minutes. Please do not share your OTP or PIN with others";
            $smsResponse = $this->send_rapid_message($mobile, $smsMessage);
            if (!isset($smsResponse['status']) || $smsResponse['status'] !== 'success') {
                Log::error('SMS sending failed', ['response' => $smsResponse]);
            }
        }
        // Update user status
        $user->status = 1;
        $user->code = $code;
        $user->email_verified_at = Carbon::now();
        $user->save();
        return redirect()->route('seller_email.get')->with('success', 'You have successfully verified. Please login now.');
    }

    public function sellerVerifyStore(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'code' => 'required',
        ]);
        // Find user by email or mobile
        $checkData = User::where('email', $request->input('content'))->orWhere('mobile', $request->input('content'))->first();

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
            return redirect()->route('seller.forget_password')->with('success', 'You have successfully verified');
        } else {
            return redirect()->back()->with('error', 'Sorry! Email or verification code does not match.');
        }
    }

    public function seller_forget_passwordSave(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        // Find the user by email or mobile
        $user = User::where('email', $request->input('content'))->orWhere('mobile', $request->input('content'))->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // ── Send password reset confirmation SMS ────────────────────────
        if (!empty($user->mobile)) {
            try {
                $mobile    = $this->normalizeBangladeshMobileNumber($user->mobile);
                $userName  = $user->name ?? 'User';
                $loginLink = route('seller.login');

                $smsSetting = \App\Models\Sms::first();
                $tpl = $smsSetting->tpl_password_reset ?? null;
                if ($tpl) {
                    $smsMessage = str_replace(['{name}', '{login_link}'], [$userName, $loginLink], $tpl);
                } else {
                    $smsMessage = "🔐 {$userName}, আপনার password পরিবর্তন হয়েছে ✅\n\nযদি আপনি এই পরিবর্তন না করে থাকেন:\nwa.me/8801816622128\n\n🔑 Login: {$loginLink}\n\nU Super Shop ❤️";
                }
                $this->send_rapid_message($mobile, $smsMessage);
            } catch (\Throwable $e) {
                \Log::warning('Seller password reset SMS failed: ' . $e->getMessage());
            }
        }

        Session::forget('seller_verify');
        // Delete password reset record
        DB::table('password_resets')->where('email', $request->input('content'))->orWhere('mobile', $request->input('content'))->delete();

        return redirect()->route('seller.login')->with('success', 'Password reset successful. Please login now!');
    }

    public function sellerLoginSave(Request $request)
    {
        // Validate input
        $this->validate($request, [
            'account_type' => 'required',
            'text_content' => 'required',
            'password' => 'required',
        ]);
        $emialcredentials = ['email' => $request->text_content, 'password' => $request->password];
        $mobilecredentials = ['mobile' => $request->text_content, 'password' => $request->password];

        // Attempt login based on input type
        $loggedIn = Auth::attempt($emialcredentials) || Auth::attempt($mobilecredentials);

        if ($loggedIn) {
            $user = Auth::user();

            // Check if suspended
            if ($user->status == 2) {
                Auth::logout();
                return redirect()->back()->with('error', 'Your account is suspended. Please renew your subscription.');
            }

            // Check subscription expiry (subscription_plan is a Unix timestamp)
            if (!empty($user->subscription_plan) && (int)$user->subscription_plan < time()) {
                // Expired — suspend and redirect
                $user->status = 2;
                $user->payment_status = 0;
                $user->save();
                Auth::logout();
                return redirect()->back()->with('error', 'Your subscription has expired. Please renew to continue.');
            }

            return redirect()->route('seller.dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->back()->with('message', 'Invalid email/mobile number or password.');
        }
    }
}
