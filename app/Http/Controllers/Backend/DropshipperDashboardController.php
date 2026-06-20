<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProfileVerify;
use App\Models\DropshipperFee;
use App\Models\SubscriptionFee;
use App\Models\User;
use App\Models\Wallet;
use App\Traits\BalanceTrait;
use App\Traits\BkashPaymentTrait;
use Illuminate\Http\Request;
use App\Utilities\FileUploadHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DropshipperDashboardController extends Controller
{
    use BkashPaymentTrait, BalanceTrait;

    // ============ DROPSHIPPER DASHBOARD ============
    public function dropshipperDashboard()
    {


        $user = Auth::user();
        $dropshipperFees = DropshipperFee::get();

        $data = [
            'user_balance' => $this->get_user_balance($user),
            'user_refer_commission' => $this->get_user_refer_commission($user),
        ];

        if ($user->usertype === 'vendor') {
            $data['vendor_product_sales_commission'] = $this->get_vendor_product_sales_commission($user);
            $data['active_product_count'] = Product::where('user_id', $user->id)->count() ?? 0;

            $data['pending_order_item_count'] = $this->get_vendor_status_wise_order_item_count($user->id, 'pending');
            $data['delivered_order_item_count'] = $this->get_vendor_status_wise_order_item_count($user->id, 'delivered');
            $data['return_order_item_count'] = $this->get_vendor_status_wise_order_item_count($user->id, 'return');
            $data['canceled_order_item_count'] = $this->get_vendor_status_wise_order_item_count($user->id, 'canceled');
        }

        if ($user->usertype === 'dropshipper') {
            $data['dropshipper_sales_commission'] = $this->get_reseller_sales_commission($user);

            $data['pending_order_item_count'] = $this->get_reseller_status_wise_order_item_count($user->id, 'pending');
            $data['delivered_order_item_count'] = $this->get_reseller_status_wise_order_item_count($user->id, 'delivered');
            $data['return_order_item_count'] = $this->get_reseller_status_wise_order_item_count($user->id, 'return');
            $data['canceled_order_item_count'] = $this->get_reseller_status_wise_order_item_count($user->id, 'canceled');
        }

        return view('backend.dropshipper.dropshipper-home', compact('data', 'dropshipperFees'));
    }

    // ============ SUBSCRIPTION FEE ============
    public function dropshipperSubscriptionFee(Request $request)
    {
        $dropshipperFee = DropshipperFee::where('account_type_of_dropshipper', $request->seller_type)->first();
        if ($dropshipperFee) {
            return response()->json([
                'status' => 'success',
                'dropshipperFee' => $dropshipperFee,
                'message' => 'Dropshipper fee retrieved successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No fee found for the selected type.',
            ]);
        }
    }

    // ============ PAYMENT PROCESS ============
    public function dropshipperProcessPayment(Request $request)
    {
        $this->validate($request, [
            'seller_type' => 'required',
            'subscription_fee' => 'required',
        ]);

        $user = auth()->user();
        $time = time();

        $subscriptionFeeAmount = $request->input('subscription_fee');
        $transactionMode = 'Bkash';

        $grantToken = $this->grantToken();

        if (isset($grantToken['id_token'])) {
            $subscription = SubscriptionFee::create([
                'seller_id' => $user->id,
                'referral_no' => rand(1000000, 9999999),
                'seller_type' => $request->input('seller_type'),
                'transction_mode' => $transactionMode,
                'subscription_fee' => $subscriptionFeeAmount,
                'date' => $time,
                'status' => 0,
            ]);

            $subscription_id = $subscription->id;
            $data = [
                'amount' => $subscriptionFeeAmount,
                'merchantInvoiceNumber' => $subscription_id . '-' . $time,
                'token_id' => $grantToken['id_token'],
                'success_url' => '?payment_type=dropshipper_subscription',
            ];

            $paymentCreate = $this->paymentCreate($data);
            if ($paymentCreate['status']) {
                return redirect($paymentCreate['data']['bkashURL'])->send();
            } else {
                SubscriptionFee::where('id', $subscription_id)->delete();
                return redirect()->route('dropshipper.dashboard')->with('error', 'Payment creation failed');
            }
        } else {
            return redirect()->route('dropshipper.dashboard')->with('error', 'Payment token not created');
        }
    }

    // ============ PROFILE VIEW / UPDATE ============
    public function dropshipperViewProfile()
    {
        $user = User::find(Auth::user()->id);
        return view('backend.dropshipper.user.view-profile', compact('user'));
    }

    public function dropshipperEditProfile()
    {
        $editData = User::find(Auth::user()->id);
        return view('backend.dropshipper.user.edit-profile', compact('editData'));
    }

    public function dropshipperUpdateProfile(Request $request)
    {
        $data = User::find(Auth::user()->id);
        $data->name = $request->name;
        $data->shop_name = $request->shop_name;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->address = $request->address;
        $data->gender = $request->gender;

        if ($request->file('image')) {
            $file = $request->file('image');
            @unlink(public_path('upload/user_images/' . $data->image));
            $filename = FileUploadHelper::saveImage($file, 'upload/user_images', $data->image ?? null);
            if ($filename) $data['image'] = $filename;
        }

        if ($request->file('logo')) {
            $file = $request->file('logo');
            @unlink(public_path('upload/user_images/' . $data->logo));
            $filename = FileUploadHelper::saveImage($file, 'upload/user_images', $data->logo ?? null);
            if ($filename) $data['logo'] = $filename;
        }

        $data->save();

        return redirect()->route('dropshipper.view.profile')->with('success', 'Profile updated successfully!');
    }

    // ============ PASSWORD UPDATE ============
    public function dropshipperPasswordView()
    {
        return view('backend.dropshipper.user.edit-password');
    }

    public function dropshipperPasswordUpdate(Request $request)
    {
        if (Auth::attempt(['id' => Auth::user()->id, 'password' => $request->current_password])) {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->route('dropshipper.view.profile')->with('success', 'Password changed successfully!');
        } else {
            return redirect()->back()->with('error', 'Current password does not match!');
        }
    }

    // ============ PROFILE VERIFICATION ============
    public function dropshipperVerifyProfile(Request $request)
    {
        $validatedData = $request->validate(
            [
                'nid_no' => 'required|unique:profile_verifies,nid_no|max:11',
                'user_id' => 'required|integer|exists:users,id',
                'birthdate' => 'required|date',
                'front_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'back_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]
        );

        $uploadPath = public_path('upload/profile_verify/');
        $frontImageName = $this->saveImage($request->file('front_image'), $uploadPath);
        $backImageName = $this->saveImage($request->file('back_image'), $uploadPath);

        $user = User::find($validatedData['user_id']);
        $user->is_profile_verify = 1;
        $user->save();

        ProfileVerify::create([
            'user_id' => $validatedData['user_id'],
            'nid_no' => $validatedData['nid_no'],
            'birthdate' => $validatedData['birthdate'],
            'front_image' => $frontImageName,
            'back_image' => $backImageName,
        ]);

        return redirect()->back()->with('success', 'Profile verified successfully!');
    }

    private function saveImage($image, $path)
    {
        $fileName = FileUploadHelper::saveImage($image, ltrim($path, '/'), null);
        return $fileName;
    }

    // ============ WALLET REQUEST ============
    public function saveWallet(Request $request)
    {
        $request->validate(
            [
                'mobile_no' => 'required|numeric',
                'payment_type' => 'required',
                'amount' => 'required|numeric|min:1',
            ],
            [
                'mobile_no.required' => 'The Mobile Number is required',
                'mobile_no.numeric' => 'Input only number',
                'payment_type.required' => 'The Payment Type is required',
                'transaction_balance.required' => 'The Payment Type is required',
            ],
        );
        $balance = auth()->user()->balance ?? 0;
        
        if ($balance < 200) {
            return redirect()->back()->with('error', 'Your balance is below 200. You cannot make a withdrawal request.');
        }

        if ($request->amount > $balance) {
            return redirect()->back()->with('error', 'Withdrawal amount cannot exceed your current balance.');
        }

        $statusChecked = Wallet::where('transaction_status', 'waiting')
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($statusChecked) {
            return redirect()->back()->with('success', 'You already have a pending request!');
        }

        Wallet::create([
            'user_id' => Auth::user()->id,
            'mobile_no' => $request->mobile_no,
            'payment_type' => $request->payment_type,
            'transaction_balance' => $request->amount,
            'transaction_status' => 'waiting',
        ]);

        return redirect()->back()->with('success', 'Wallet request submitted successfully!');
    }

    // ============ ADMIN SIDE (Subscription Management) ============
    public function viewSubscription()
    {
        $data['countDropshipperFee'] = DropshipperFee::count();
        $data['allData'] = DropshipperFee::select('id', 'account_type_of_shop', 'subscription_fees')
            ->orderBy('id', 'DESC')->get();

        return view('backend.subscription.view-subscription', $data);
    }

    public function addSubscription()
    {
        return view('backend.subscription.add-subscription');
    }

    public function storeSubscription(Request $request)
    {
        DB::transaction(function () use ($request) {
            $this->validate($request, [
                'account_type_of_shop' => 'required',
                'subscription_fees' => 'required',
            ]);

            $data = new DropshipperFee();
            $data->account_type_of_shop = $request->account_type_of_shop;
            $data->subscription_fees = $request->subscription_fees;
            $data->save();
        });

        return redirect()->route('subscriptions.view')->with('success', 'Data inserted successfully');
    }

    public function editSubscription($id)
    {
        $data['editData'] = DropshipperFee::find($id);
        return view('backend.subscription.add-subscription', $data);
    }

    public function updateSubscription(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $data = DropshipperFee::find($id);
            $data->account_type_of_shop = $request->account_type_of_shop;
            $data->subscription_fees = $request->subscription_fees;
            $data->save();
        });

        return redirect()->route('subscriptions.view')->with('success', 'Data updated successfully');
    }

    public function deleteSubscription($id)
    {
        $data = DropshipperFee::find($id);
        $data->delete();
        return redirect()->route('subscriptions.view')->with('success', 'Data deleted successfully');
    }
}
