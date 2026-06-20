<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProfileVerify;
use App\Models\SellerFee;
use App\Models\SubscriptionFee;
use App\Models\User;
use App\Models\Wallet;
use App\Traits\BalanceTrait;
use App\Traits\BkashPaymentTrait;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use App\Utilities\FileUploadHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
//use Auth;

class SellerDashboardController extends Controller
{
    use BkashPaymentTrait, BalanceTrait;
    public function sellerDashboard()
    {
        $user = Auth::user();

        $sellerfees = SellerFee::get();
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
        if ($user->usertype === 'seller') {
            $data['reseller_sales_commission'] = $this->get_reseller_sales_commission($user);

            $data['pending_order_item_count'] = $this->get_reseller_status_wise_order_item_count($user->id, 'pending');
            $data['delivered_order_item_count'] = $this->get_reseller_status_wise_order_item_count($user->id, 'delivered');
            $data['return_order_item_count'] = $this->get_reseller_status_wise_order_item_count($user->id, 'return');
            $data['canceled_order_item_count'] = $this->get_reseller_status_wise_order_item_count($user->id, 'canceled');

        }
        return view('backend.seller.seller-home', compact('data', 'sellerfees'));
    }
    public function sellerSubscriptionFee(Request $request)
    {
        $sellerfees = SellerFee::where('account_type_of_myshop', $request->seller_type)->first();
        if ($sellerfees) {
            return response()->json([
                'status' => 'success',
                'sellerfees' => $sellerfees,
                'message' => 'Get Seller Fee Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No seller fee found for the selected type.',
            ]);
        }
    }
    public function sellerProcessPayment(Request $request)
    {

        $this->validate($request, [
            'seller_type' => 'required',
            'subscription_fee' => 'required'
        ]);
        $user = auth()->user();
        $time = time();

        $subcription_fee_amount = $request->input('subscription_fee');
        $tasactionMode = 'Bkash';

        $grantToken = $this->grantToken();
        if (isset($grantToken['id_token'])) {
            $subcription = SubscriptionFee::create([
                'seller_id' => $user->id,
                'referral_no' => rand(1000000, 9999999),
                'seller_type' => $request->input('seller_type'),
                'transction_mode' => $tasactionMode,
                'subscription_fee' => $subcription_fee_amount,
                'date' => $time,
                'status' => 0 // 0 = unpaid, 1 = paid
            ]);

            $subcription_id = $subcription->id;
            $data = [
                'amount' => $subcription_fee_amount,
                'merchantInvoiceNumber' => $subcription_id . '-' . $time,
                'token_id' => $grantToken['id_token'],
                'success_url' => '?payment_type=user_subscription'
            ];

            $paymentCreate = $this->paymentCreate($data);
            if ($paymentCreate['status']) {
                return redirect($paymentCreate['data']['bkashURL'])->send();
            } else {
                SubscriptionFee::where('id', $subcription_id)->delete();
                return redirect()->route('seller.dashboard')->with('error', 'Payment Create Failed');
            }
        } else {
            return redirect()->route('seller.dashboard')->with('error', 'Payment Token Not Created');
        }

    }
    private function processBkashPayment($orderTotal, $paymenytID)
    {
        // Fetch Grant Token
        $grantToken = $this->grantToken();
        if (isset($grantToken['id_token'])) {
            $data = [
                'amount' => $orderTotal,
                'merchantInvoiceNumber' => $paymenytID . '-' . time(),
                'token_id' => $grantToken['id_token'],
            ];
            // Create Payment Request
            $paymentCreate = $this->paymentCreate($data);
            if ($paymentCreate['status']) {
                if (isset($paymentCreate['data']['bkashURL'])) {
                    // Redirect to Bkash Payment Page
                    return redirect($paymentCreate['data']['bkashURL'])->send();
                }
            }
        }
    }
    public function sellerViewProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('backend.seller.user.view-profile', compact('user'));
    }

    public function sellerEditProfile()
    {
        $id = Auth::user()->id;
        $editData = User::find($id);
        return view('backend.seller.user.edit-profile', compact('editData'));
    }

    public function sellerUpdateProfile(Request $request)
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
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data['image'] = $filename;
        }

        if ($request->file('logo')) {
            $file = $request->file('logo');
            @unlink(public_path('upload/user_images/' . $data->logo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data['logo'] = $filename;
        }
        $data->save();
        return redirect()->route('sellers.view.profile')->with('success', 'Profile update successfully !!!');
    }

    public function sellerPasswordView()
    {
        return view('backend.seller.user.edit-password');
    }

    public function sellerPasswordUpdate(Request $request)
    {
        if (Auth::attempt(['id' => Auth::user()->id, 'password' => $request->current_password])) {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->route('sellers.view.profile')->with('success', 'Your password changed successfully !!!');
        } else {
            return redirect()->back()->with('error', 'Sorry! Your current password does not match !!!');
        }
    }
    public function sellerVerifyProfile(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate(
            [
                'nid_no' => 'required|unique:profile_verifies,nid_no|max:11', // Ensure exactly 10 digits
                'user_id' => 'required|integer|exists:users,id',
                'birthdate' => 'required|date',
                'front_image' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Limit file size to 2MB
                'back_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ],
            [
                'nid_no.required' => 'NID number is required',
                'nid_no.unique' => 'NID number must be unique',
                'nid_no.digits' => 'NID number must be exactly 10 digits',
                'user_id.required' => 'User ID is required',
                'user_id.exists' => 'The selected user ID is invalid',
                'birthdate.required' => 'Birth date is required',
                'front_image.required' => 'Front image is required',
                'back_image.required' => 'Back image is required',
            ],
        );

        // Define the upload directory
        $uploadPath = public_path('upload/profile_verify/');

        // Handle image uploads and save only the image name
        $frontImageName = null;
        $backImageName = null;

        if ($request->hasFile('front_image')) {
            $frontImageName = $this->saveImage($request->file('front_image'), $uploadPath);
        }

        if ($request->hasFile('back_image')) {
            $backImageName = $this->saveImage($request->file('back_image'), $uploadPath);
        }

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

        // Redirect back with success message
        return redirect()->back()->with('success', 'Your profile has been verified successfully!');
    }


    private function saveImage($image, $path)
    {
        $fileName = date('YmdHi') . '_' . $image->getClientOriginalName();
        $image->move($path, $fileName);

        return $fileName; // Return only the file name
    }
    public function SaveWallet(Request $request)
    {
        $balance = auth()->user()->balance ?? 0;

        // Validate inputs
        $request->validate(
            [
                'mobile_no' => 'required|numeric',
                'payment_type' => 'required',
                'amount' => 'required|numeric|min:200|max:' . $balance,
            ],
            [
                'mobile_no.required' => 'The Mobile Number is required',
                'mobile_no.numeric' => 'Input only number',
                'payment_type.required' => 'The Payment Type is required',
                'amount.min' => 'Minimum request amount is 200',
                'amount.max' => 'Amount cannot exceed your balance',
            ]
        );

        // Block request if balance < 200
        if ($balance < 200) {
            return redirect()->back()->with('error', 'Your balance is below 200. You cannot make a withdrawal request.');
        }

        if ($request->amount > $balance) {
            return redirect()->back()->with('error', 'Withdrawal amount cannot exceed your current balance.');
        }

        // Check pending request
        $pending = Wallet::where('transaction_status', 'waiting')
            ->where('user_id', auth()->id())
            ->first();

        if ($pending) {
            return redirect()->back()->with('error', 'You already have a pending request.');
        }

        // Create wallet request
        Wallet::create([
            'user_id' => auth()->id(),
            'mobile_no' => $request->mobile_no,
            'payment_type' => $request->payment_type,
            'transaction_balance' => $request->amount,
            'transaction_status' => 'waiting',
        ]);

        return redirect()->back()->with('success', 'Your request has been submitted!');
    }

    public function viewSubcription()
    {
        $data['countSellerFee'] = SellerFee::count();
        $data['allData'] = SellerFee::select('id', 'account_type_of_myshop', 'subscription_fees', 'duration', 'plan_features')->orderBy('id', 'DESC')->get();
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
                'account_type_of_myshop' => 'required',
                'subscription_fees' => 'required',
                'duration' => 'required|in:monthly,yearly',
                'plan_features' => 'nullable|string',
            ]);
            $data = new SellerFee();
            $data->account_type_of_myshop = $request->account_type_of_myshop;
            $data->subscription_fees = $request->subscription_fees;
            $data->duration = $request->duration;
            $data->plan_features = $this->preparePlanFeatures($request->plan_features);
            $data->save();
        });
        return redirect()->route('subscriptions.view')->with('success', 'Data inserted successfully');
    }

    public function editSubscription($id)
    {
        $data['editData'] = SellerFee::find($id);
        return view('backend.subscription.add-subscription', $data);
    }

    public function updateSubscription(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $this->validate($request, [
                'account_type_of_myshop' => 'required',
                'subscription_fees' => 'required',
                'duration' => 'required|in:monthly,yearly',
                'plan_features' => 'nullable|string',
            ]);
            $data = SellerFee::find($id);
            $data->account_type_of_myshop = $request->account_type_of_myshop;
            $data->subscription_fees = $request->subscription_fees;
            $data->duration = $request->duration;
            $data->plan_features = $this->preparePlanFeatures($request->plan_features);
            $data->save();
        });
        return redirect()->route('subscriptions.view')->with('success', 'Data updated successfully');
    }
    public function deleteSubscription($id)
    {
        $data = SellerFee::find($id);
        $data->delete();
        return redirect()->route('subscriptions.view')->with('success', 'Data deleted successfully');
    }

    private function preparePlanFeatures($planFeatures)
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $planFeatures))
            ->map(function ($feature) {
                return trim($feature);
            })
            ->filter()
            ->values()
            ->all();
    }

}
