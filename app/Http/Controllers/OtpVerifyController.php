<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class OtpVerifyController extends Controller
{
    public function index($id){
        if($id == null || $id == ''){
            return redirect()->back()->with('error', 'Invalid request');
        }
        else{
            $user_id = Crypt::decrypt($id);
            $user = User::findOrFail($user_id);
            if(($user->code != NULL) && ($user->status == 0)){
                $deliveryMethodLabels = [
                    'email' => 'email',
                    'sms' => 'phone number',
                    'both' => 'email and phone number',
                ];
                $deliveryMethod = $deliveryMethodLabels[$user->otp_delivery_method ?? 'both'] ?? 'email and phone number';
                return view('frontend.otp.verify', compact('user', 'id', 'deliveryMethod'));
            }
            elseif(($user->code == NULL) && ($user->status == 1)){
                return redirect()->route('kafi')->with('success', 'Email already verified');
            }
            else{
                return redirect()->route('kafi')->with('error', 'You are suspended');
            }
        }
    }

    public function store(Request $request, $id){
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        if($id == null || $id == ''){
            return redirect()->back()->with('error', 'Invalid request');
        }
        else{
            $user_id = Crypt::decrypt($id);
            $user = User::findOrFail($user_id);

            $request->validate([
                'otp' => [
                    'required',
                    'numeric',
                    'digits:6',
                    function ($attribute, $value, $fail) use ($user) {
                        if ($user->code != $value) {
                            $fail('Invalid OTP! Please enter correct OTP.');
                        }
                    }
                ],
            ]);

            if($user->code == $request->otp){
                $user->status = 1;
                $user->code = null; // Clear the OTP after successful verification
                $user->email_verified_at = now();
                $user->save();
                return redirect()->route('customer.login')->with('success', 'OTP verified successfully');
            } else {
                return redirect()->back()->with('error', 'Invalid OTP');
            }
        }
    }
}
