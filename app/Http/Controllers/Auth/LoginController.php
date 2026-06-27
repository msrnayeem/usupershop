<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\SendSmsTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    use SendSmsTrait;
    public function Userlogin(Request $request)
    {
        // ── 1. IP-level rate limit (cache-based) ──────────────────────
        $ipKey = 'login_fail:' . $request->ip();
        if (Cache::get($ipKey, 0) >= 20) {
            return redirect()->back()->with('error', '⛔ অনেকবার ভুল চেষ্টা হয়েছে। ৫ মিনিট পরে আবার চেষ্টা করুন।');
        }

        $request->validate([
            'content'  => 'required',
            'password' => 'required',
        ]);

        $content  = $request->content;
        $password = $request->password;

        $validData = User::where('email', $content)->orWhere('mobile', $content)->first();
        if (!$validData) {
            Cache::put($ipKey, Cache::get($ipKey, 0) + 1, now()->addMinutes(5));
            return redirect()->back()->with('error', '❌ Email বা Phone নম্বর খুঁজে পাওয়া যায়নি।');
        }

        // ── 2. Check if account is login-blocked ──────────────────────
        if ($validData->login_blocked_at && in_array($validData->usertype, ['seller','vendor','dropshipper','customer'])) {
            $reason = $validData->login_blocked_reason ?? 'বারবার ভুল password দেওয়ার কারণে';
            return redirect()->back()->with('error',
                '🚫 আপনার account temporarily blocked হয়েছে। ' . $reason . '। Admin-এর সাথে যোগাযোগ করুন।'
            );
        }

        // ── 3. Verify password ────────────────────────────────────────
        if (!password_verify($password, $validData->password)) {
            // IP cache increment
            Cache::put($ipKey, Cache::get($ipKey, 0) + 1, now()->addMinutes(5));

            // Per-account failed attempt tracking (seller/vendor/dropshipper only)
            if (in_array($validData->usertype, ['seller','vendor','dropshipper','customer'])) {
                $attempts = ($validData->failed_login_attempts ?? 0) + 1;
                $validData->failed_login_attempts = $attempts;

                // Block after 2 wrong attempts
                if ($attempts >= 2) {
                    $validData->login_blocked_at     = now();
                    $validData->login_blocked_reason = 'পরপর ' . $attempts . ' বার ভুল password দেওয়া হয়েছে';
                    $validData->save();

                    // Log for admin
                    \Log::warning('Account auto-blocked due to failed logins', [
                        'user_id'  => $validData->id,
                        'email'    => $validData->email,
                        'attempts' => $attempts,
                        'ip'       => $request->ip(),
                    ]);

                    return redirect()->back()->with('error',
                        '🚫 ২ বার ভুল password দেওয়ার কারণে আপনার account block হয়ে গেছে। Admin-এ যোগাযোগ করুন।'
                    );
                }

                $remaining = 2 - $attempts;
                $validData->save();
                return redirect()->back()->with('error',
                    '❌ Password ভুল হয়েছে। আর মাত্র ' . $remaining . ' বার চেষ্টা করতে পারবেন তারপর account block হবে।'
                );
            }

            return redirect()->back()->with('error', '❌ Phone বা Password মিলছে না।');
        }

        // ── 4. Password correct — reset attempt counter ───────────────
        if ($validData->failed_login_attempts > 0) {
            $validData->failed_login_attempts = 0;
            $validData->save();
        }
        Cache::forget($ipKey);

        if (($validData->code == NULL) && ($validData->status == 1)) {

            if (Auth::attempt(['email' => $content, 'password' => $password]) || Auth::attempt(['mobile' => $content, 'password' => $password])) {
                if ($validData->usertype === 'customer') {
                    return redirect()->route('dashboard')->with('success', 'Login সফল হয়েছে ✅');
                } elseif ($validData->usertype === 'vendor') {
                    return redirect()->route('seller.dashboard')->with('success', 'Login সফল হয়েছে ✅');
                } elseif ($validData->usertype === 'seller') {
                    return redirect()->route('seller.dashboard')->with('success', 'Login সফল হয়েছে ✅');
                } elseif ($validData->usertype === 'dropshipper') {
                    return redirect()->route('dropshipper.dashboard')->with('success', 'Login সফল হয়েছে ✅');
                } else {
                    return redirect()->route('frontend.home')->with('success', 'Login সফল হয়েছে ✅');
                }
            } else {
                return redirect()->back()->with('error', '❌ Login ব্যর্থ হয়েছে। আবার চেষ্টা করুন।');
            }
        } elseif (($validData->code != NULL) && ($validData->status == 0)) {

            $otp = rand(100000, 999999);
            $validData->code = $otp;
            $validData->save();

            $mobile = '88' . $validData->mobile;
            $smsMessage = "Hello Dear $validData->name, Your U SuperShop verification code is: $otp. The code will expire in 5 minutes. Please do NOT share your OTP or PIN with others. 1";
            $this->send_rapid_message($mobile, $smsMessage);

            Mail::send('frontend.emails.verify-email', ['email' => $validData->email, 'code' => $otp], function ($message) use ($validData) {
                $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
                $message->to($validData->email);
                $message->subject(env('APP_NAME') . ' | OTP Verification');
            });

            $encrypted_id = Crypt::encrypt($validData->id);
            return redirect()->route('verify.index', $encrypted_id)->with('success', 'Please verify your OTP');
        } elseif ($validData->status == 2) {
            return redirect()->back()->with('error', 'You are suspended');
        } else {
            return redirect()->back()->with('error', 'Login failed. Please try again.');
        }

    }
    public function Adminlogin(Request $request)
    {
        // Validate the input
        $request->validate([
            'content' => 'required', // Either email or phone number
            'password' => 'required', // Password is required
        ]);
        $content = $request->content;
        $password = $request->password;
        // Check if content is an email or phone
        $validData = User::where('email', $content)->orWhere('mobile', $content)->first();
        if (!$validData) {
            return redirect()->back()->with('message', 'Email or Phone Number not found');
        }
        // Verify the password
        if (!password_verify($password, $validData->password)) {
            return redirect()->back()->with('message', 'Phone or password does not match');
        }
        // Check if the user is verified
        if ($validData->status == '0') {
            return redirect()->back()->with('message', 'Sorry! You are not verified yet');
        }
        // Attempt login using email or mobile
        if (Auth::attempt(['email' => $content, 'password' => $password]) || Auth::attempt(['mobile' => $content, 'password' => $password])) {
            return redirect()->route('home'); // Redirect to dashboard or appropriate route
        }
        return redirect()->back()->with('message', 'Login failed. Please try again.');
    }

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function ForgetEmailID()
    {
        return view('frontend.single_page.forget-email');
    }

    public function forgetEmailVerify(Request $request)
    {
        // Check if the email or mobile exists in the database
        $userOne = User::where('email', $request->content)->Orwhere('mobile', $request->content)->first();
        if (!$userOne) {
            return back()->with('error', 'No user found with provided email or mobile number.');
        }
        // Generate OTP and token
        $otp = rand(100000, 999999);
        $token = Str::random(64);
        // Get common user data
        $mobile = '88' . $userOne->mobile;
        $email = $userOne->email;
        $name = $userOne->name;
        // Store OTP and token
        DB::table('password_resets')->insert([
            'email' => $email,
            'mobile' => $userOne->mobile,
            'token' => $token,
            'otp' => $otp,
            'created_at' => Carbon::now()
        ]);

        $userOne->forget_otp = $otp;
        $userOne->save();

        // Send SMS
        if ($request->content == $userOne->mobile) {
            $smsMessage = "Hello Dear $name, Your " . env('APP_NAME') . " verification code is: $otp.The code will expire in 5 minutes. Please do not share your OTP or PIN with others";
            $smsResponse = $this->send_rapid_message($mobile, $smsMessage);
            if (!isset($smsResponse['status']) || $smsResponse['status'] !== 'success') {
                Log::error('SMS sending failed', ['response' => $smsResponse]);
            }
        }

        if ($request->content == $email) {
            // Send Email
            $data = [
                'name' => $name,
                'email' => $email,
                'mobile' => $mobile,
                'otp' => $otp,
            ];
            Mail::send('frontend.emails.otp-email', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'), '');
                $message->to($data['email']);
                $message->subject('Forgot Password - OTP Verification');
            });
        }
        Session::put('verify_content', $request->content);
        return redirect()->route('forget.verify.otp')->with('success', 'OTP sent to your email and mobile.');
    }

    public function VerifyEmailAndOtp()
    {
        return view('frontend.single_page.verify-otp');
    }
    public function VerifyEmailAndOtpSave(Request $request)
    {
        $request->validate([
            'context' => 'required',
            'otp' => 'required',
        ]);
        $checkOtp = DB::table('password_resets')->where('otp', $request->otp)->first();
        if ($checkOtp == true) {
            DB::table('password_resets')
                ->where('otp', $request->otp)
                ->update(['otp' => null]);
            return redirect()->route('forget_password')->with('message', 'Otp is verified');
        }
    }
    public function VerifyEmailAndPasswordChange()
    {
        return view('frontend.single_page.reset_password');
    }
    public function VerifyEmailAndPasswordChangeSave(Request $request)
    {
        $request->validate([
            'context' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        // Try to find a reset entry where either email or mobile matches the context
        $resetEntry = DB::table('password_resets')->where('email', $request->context)
            ->orWhere('mobile', $request->context)->first();
        if (!$resetEntry) {
            return back()->with('message', 'Sorry! You are not verified yet.');
        }

        // Update the password for the user who has that email or mobile
        $user = User::where('email', $request->context)
            ->orWhere('mobile', $request->context)->first();

        if (!$user) {
            return back()->with('message', 'User not found.');
        }

        $user->forget_otp = NULL;
        $user->password = Hash::make($request->password);
        $user->update();

        if (!empty($user->mobile)) {
            $mobile    = $this->normalizeBangladeshMobileNumber($user->mobile);
            $loginLink = route('customer.login');
            $userName  = $user->name ?? 'Customer';

            // Use DB template if available, fallback to default
            try {
                $smsSetting = \App\Models\Sms::first();
                $tpl = $smsSetting->tpl_password_reset ?? null;
            } catch (\Exception $ex) {
                $tpl = null;
            }

            if ($tpl) {
                $smsMessage = str_replace(
                    ['{name}', '{login_link}'],
                    [$userName, $loginLink],
                    $tpl
                );
            } else {
                $smsMessage = "✅ {$userName}, আপনার পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে।\n\n⚠️ আপনি যদি এই পরিবর্তন না করে থাকেন তাহলে এখনই যোগাযোগ করুন:\nwa.me/8801816622128\n\nU Super Shop ❤️";
            }

            try {
                $this->send_rapid_message($mobile, $smsMessage);
            } catch (\Throwable $e) {
                \Log::error('Password reset SMS failed', [
                    'user_id' => $user->id,
                    'mobile'  => $user->mobile,
                    'error'   => $e->getMessage(),
                ]);
            }
        }

        Session::forget('verify_content');
        // Delete the reset record
        DB::table('password_resets')->where('email', $request->context)
            ->orWhere('mobile', $request->context)->delete();

        return redirect()->route('customer.login')->with('message', 'Password Change Successfully');
    }

    /**
     * Resend Forgot Password OTP
     * Rate limited: max 3 resends per 10 minutes
     */
    public function resendForgotOtp(Request $request)
    {
        $context = Session::get('verify_content');

        if (empty($context)) {
            return response()->json([
                'status'  => false,
                'message' => 'Session expired. Please start again.',
            ], 400);
        }

        // ── Rate limit: max 3 resends per 10 minutes ──────────────────────
        $rateLimitKey = 'otp_resend:' . md5($context . $request->ip());
        $resendCount  = Cache::get($rateLimitKey, 0);

        if ($resendCount >= 3) {
            return response()->json([
                'status'  => false,
                'message' => '১০ মিনিটে সর্বোচ্চ ৩ বার OTP পাঠানো যাবে। একটু পরে আবার চেষ্টা করুন।',
            ], 429);
        }

        // ── Find user ───────────────────────────────────────────────────────
        $user = User::where('email', $context)->orWhere('mobile', $context)->first();
        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'User found হয়নি।',
            ], 404);
        }

        // ── Generate new OTP ────────────────────────────────────────────────
        $newOtp = rand(100000, 999999);

        DB::table('password_resets')
            ->where('email', $context)
            ->orWhere('mobile', $context)
            ->update([
                'otp'        => $newOtp,
                'created_at' => now(),
            ]);

        $user->forget_otp = $newOtp;
        $user->save();

        $name = $user->name ?? 'Customer';
        $sent = false;

        // ── Send SMS ────────────────────────────────────────────────────────
        if (!empty($user->mobile)) {
            try {
                $mobile     = $this->normalizeBangladeshMobileNumber($user->mobile);
                $smsMessage = "🔐 {$name}, আপনার নতুন OTP: {$newOtp}

৫ মিনিটের মধ্যে ব্যবহার করুন।
কারো সাথে শেয়ার করবেন না।

U Super Shop ❤️";
                $result     = $this->send_rapid_message($mobile, $smsMessage);
                $sent       = isset($result['status']) && strtolower((string)$result['status']) === 'success';
            } catch (\Throwable $e) {
                \Log::warning('OTP resend SMS failed: ' . $e->getMessage());
            }
        }

        // ── Send Email (fallback) ────────────────────────────────────────────
        if (!$sent && !empty($user->email)) {
            try {
                $data = ['name' => $name, 'otp' => $newOtp, 'email' => $user->email];
                \Mail::send('frontend.emails.otp-email', $data, function ($message) use ($user) {
                    $message->to($user->email)->subject('U Super Shop — New OTP Code');
                });
                $sent = true;
            } catch (\Throwable $e) {
                \Log::warning('OTP resend email failed: ' . $e->getMessage());
            }
        }

        // ── Increment rate limit counter ─────────────────────────────────────
        Cache::put($rateLimitKey, $resendCount + 1, now()->addMinutes(10));

        $remaining = 3 - ($resendCount + 1);

        return response()->json([
            'status'    => $sent,
            'message'   => $sent
                ? "নতুন OTP পাঠানো হয়েছে! (আরও {$remaining} বার পাঠাতে পারবেন)"
                : 'OTP পাঠাতে সমস্যা হয়েছে। একটু পরে আবার চেষ্টা করুন।',
            'remaining' => $remaining,
        ]);
    }

    // laravel socialite login
    //google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    //google callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $this->registerOrLoginUser($user);
        return redirect()->route('dashboard');
    }

    //facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    //facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $this->registerOrLoginUser($user);
        return redirect()->route('dashboard');
    }

    //socialite login
    protected function registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->usertype = 'customer';
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->image = $data->avatar;
            $user->save();
        }

        Auth::login($user);
    }

    public function AdminLogout()
    {
        \Illuminate\Support\Facades\Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('adminlogin')->with('success', 'Successfully logged out.');
    }

}
