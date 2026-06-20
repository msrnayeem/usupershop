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
        // Rate limit: max 10 login attempts per IP per 5 minutes
        $ipKey = 'login_fail:' . $request->ip();
        if (Cache::get($ipKey, 0) >= 10) {
            return redirect()->back()->with('error', 'Too many login attempts. Please wait 5 minutes.');
        }

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
            return redirect()->back()->with('error', 'Email or Phone Number not found');
        }
        // Verify the password
        if (!password_verify($password, $validData->password)) {
            // Increment failed login counter
            $ipKey = 'login_fail:' . $request->ip();
            $fails = Cache::get($ipKey, 0) + 1;
            Cache::put($ipKey, $fails, now()->addMinutes(5));
            return redirect()->back()->with('error', 'Phone or password does not match');
        }

        if (($validData->code == NULL) && ($validData->status == 1)) {
         
            if (Auth::attempt(credentials: ['email' => $content, 'password' => $password]) || Auth::attempt(['mobile' => $content, 'password' => $password])) {
                // Reset fail counter on successful login
                Cache::forget('login_fail:' . $request->ip());
                if ($validData->usertype === 'customer') {
                    return redirect()->route('dashboard')->with('success', 'Login Successfull.');
                } elseif ($validData->usertype === 'vendor') {
                    return redirect()->route('seller.dashboard')->with('success', 'Login Successfull.');
                } elseif ($validData->usertype === 'seller') {
                    return redirect()->route('seller.dashboard')->with('success', 'Login Successfull.');
                } elseif ($validData->usertype === 'dropshipper') {
                    return redirect()->route('dropshipper.dashboard')->with('success', 'Login Successfull.');
                } else {
                    return redirect()->route('frontend.home')->with('success', 'Login Successfull.');
                }
            } else {
                return redirect()->back()->with('error', 'Login failed. Please try again.');
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
            $mobile = $this->normalizeBangladeshMobileNumber($user->mobile);
            $loginLink = route('customer.login');
            $smsMessage = "Your password has been successfully changed.\n\nIf you did not request this change, please contact our support immediately.\n\nYou can now log in with your new password: https://usuper.shop\n\nClick below to proceed to the login page:\n[Login Here]\n{$loginLink}\n\nThank you for using U Super Shop.";

            try {
                $this->send_rapid_message($mobile, $smsMessage);
            } catch (\Throwable $e) {
                Log::error('Password reset SMS failed', [
                    'user_id' => $user->id,
                    'mobile' => $user->mobile,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Session::forget('verify_content');
        // Delete the reset record
        DB::table('password_resets')->where('email', $request->context)
            ->orWhere('mobile', $request->context)->delete();

        return redirect()->route('customer.login')->with('message', 'Password Change Successfully');
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
}
