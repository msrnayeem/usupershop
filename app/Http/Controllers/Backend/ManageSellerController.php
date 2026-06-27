<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\SendSmsTrait;
use App\Traits\ReferCommissionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ManageSellerController extends Controller
{
    use SendSmsTrait;
    use ReferCommissionTrait;
    public function view()
    {
        $pageTitle = 'Seller List';
        $sellers = User::where('usertype', 'seller')->orderBy('id','DESC');
        if(request()->has('active')){
            $pageTitle = 'Active Seller List';
            $sellers = $sellers->where('status', 1);
        }
        else if(request()->has('inactive')){
            $pageTitle = 'Inactive Seller List';
            $sellers = $sellers->where('status', 0);
        }
        else if(request()->has('suspended')){
            $pageTitle = 'Suspended Seller List';
            $sellers = $sellers->where('status', 2);
        }
        else if(request()->has('paid')){
            $pageTitle = 'Paid Seller List';
            $sellers = $sellers->where('payment_status', 1);
        }
        else if(request()->has('unpaid')){
            $pageTitle = 'Unpaid Seller List';
            $sellers = $sellers->where('payment_status', 0);
        }

        $sellers =$sellers->get();
        return view('backend.shopseller.view-seller', compact('sellers', 'pageTitle'));
    }

    public function sellerList(Request $request)
    {
        $draw = $request->input('draw');
        $length = $request->input('length');
        $start = $request->input('start');
        $columns = $request->input('columns');

        $Data = [];
        $Result = User::getSellerResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
            $EditRoute = route('sellers.edit', $Res->id);
            $DeleteRoute = route('sellers.delete', $Res->id);
            $ProfileRoute = route('sellers.profile', $Res->id);
            $action = "<a title='Edit' class='btn btn-sm btn-primary' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            $action .= "<a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";
           // Inside the foreach loop where $Result is processed
            $reseller = User::find($Res->reseller_id); // Fetch reseller using reseller_id

            if ($reseller) {
                $action .= '
                    <button type="button" class="btn btn-success btn-sm edit-refer"
                        data-toggle="modal" data-target="#sellerReferModal"
                        data-reseller-id="' . $reseller->id . '"
                        data-reseller-name="' . $reseller->mobile . '"
                        data-reseller-balance="' . $reseller->balance . '">
                        <i class="fas fa-money-bill"></i> Add Refer Balance
                    </button>
                ';
            }

            $action .= "<a title='Seller Profile' class='btn btn-sm btn-success' href='$ProfileRoute'><i class='fas fa-users'></i> Verify Seller</a>";
            $action .=
                '
            <button type="button" class="btn btn-success btn-sm edit-commission"
                    data-toggle="modal" data-target="#sellerCommissionModal"
                    data-user-id="' .
                $Res->id .
                '"
                    data-commission="' .
                str_replace('%', '', $Res->commission) .
                '">
                Edit Seller Commission
            </button>
            ';
            if ($Res->status == 2) {
                $status = '<span style="background:#1BA160;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Active </span>';
            } else {
                $status = '<span style="background:#DD4F42;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Inactive</span>';
            }

            if ($Res->payment_status == 2) {
                $payment_status = '<span style="background:#1BA160;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Paid  </span>';
            } else {
                $payment_status = '<span style="background:#DD4F42;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Unpaid</span>';
            }

            $commission = $Res->commission . '%';
            $createDate = date('d-m-Y', $Res->subscription_plan);
            $Data[] = [
                'sn' => $sn,
                'name' => $Res->name,
                'email' => $Res->email,
                'mobile' => $Res->mobile,
                'account_type' => $Res->account_type,
                'createDate' => $createDate,
                'shop_name' => $Res->shop_name,
                'address' => $Res->address,
                'commission' => $commission,
                'payment_status' => $payment_status,
                'status' => $status,
                'action' => $action,
            ];

            $sn++;
        }

        $res = [
            'draw' => $draw,
            "resellerId" => $reseller->id ?? 0,
            'iTotalRecords' => User::where('status', '=', 2)->where('usertype', '=', 'seller')->count(),
            'iTotalDisplayRecords' => User::where('status', '=', 2)->where('usertype', '=', 'seller')->count(),
            'aaData' => $Data,
        ];

        return response()->json($res);
    }

    public function draftView()
    {
        $data['allData'] = User::where('usertype', 'seller')->where('status', 1)->orderBy('id', 'DESC')->get();
        return view('backend.shopseller.draft-seller', $data);
    }

    public function draftList(Request $request)
    {
        $draw = $request->input('draw');
        $length = $request->input('length');
        $start = $request->input('start');
        $columns = $request->input('columns');

        $Data = [];
        $Result = User::getSellerDraftResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
            /* $EditRoute = route('vendors.edit', $Res->id); */
            $DeleteRoute = route('sellers.delete', $Res->id);

            $action = "<a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";
            if ($Res->status == 1) {
                $status = '<span style="background:#1BA160;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Active</span>';
            } 
            else if ($Res->status == 0) {
                $status = '<span style="background:#1BA160;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Inactive</span>';
            } 
            else {
                $status = '<span style="background:#DD4F42;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Suspended </span>';
            }
            if ($Res->payment_status == 1) {
                $payment_status = '<span style="background:#1BA160;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;"> Paid</span>';
            } else {
                $payment_status = '<span style="background:#53d05c;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Unpaid</span>';
            }
            $created = new Carbon($Res->created_at);
            $now = Carbon::now();
            $difference = $created->diff($now)->days < 1 ? 'today' : $created->diffForHumans($now);

            if ($Res->commission == 0) {
                $commission = '<input type="text" name="commission" id="commission_' . $Res->id . '" size="6">';
            } else {
                $commission = '';
            }

            $Data[] = [
                'sn' => $sn,
                'name' => $Res->name,
                'email' => $Res->email,
                'mobile' => $Res->mobile,
                'address' => $Res->address,
                'account_type' => $Res->account_type,
                'difference' => $difference,
                'payment_status' => $payment_status,
                'commission' => $commission,
                'status' => $status,
                'action' => $action,
            ];
            $sn++;
        }
        $res = [
            'draw' => $draw,
            /* "iTotalRecords" => User::count(), */
            'iTotalRecords' => User::where('payment_status', '=', 1)->where('usertype', '=', 'seller')->count(),
            'iTotalDisplayRecords' => User::where('payment_status', '=', 1)->where('usertype', '=', 'seller')->count(),
            'aaData' => $Data,
        ];
        return response()->json($res);
    }

    public function approved(Request $request)
    {
        $sellerId = $request->id;
        $commission = $request->commission;

        if (empty($sellerId)) {
            $res = ['message' => 'Something wrong ! ID no found !!!'];
            return response($res, 203)->header('Content-Type', 'application/json');
        }
        if ($commission == '') {
            $res = ['message' => 'Please enter commission value !!!'];
            return response($res, 203)->header('Content-Type', 'application/json');
        }
        if ($commission == 0) {
            $res = ['message' => 'Please enter commission at least 1% !!!'];
            return response($res, 203)->header('Content-Type', 'application/json');
        }
        if ($commission > 50) {
            $res = ['message' => 'Please enter commission less than or equale 50% !!!'];
            return response($res, 203)->header('Content-Type', 'application/json');
        }

        if (!empty($sellerId)) {
            $seller = User::find($sellerId);

            if ($seller) {
                $seller->commission = $commission ?? 0; // Ensure $commission is set
                $seller->save();
                $res = ['message' => 'Seller approved successfully !!!'];
                return response($res, 202)->header('Content-Type', 'application/json');
            } else {
                $res = ['message' => 'Seller not found!'];
                return response($res, 404)->header('Content-Type', 'application/json');
            }
        }

        //return redirect()->route('vendors.view')->with('success', 'Seller approved successfully !!!');
    }
    public function sellerEdit($id)
    {
        $editData = User::find($id);
        $createDate = date('d-m-Y', $editData->subscription_plan);
        return view('backend.shopseller.add-seller', compact('editData', 'createDate'));
    }
    public function sellerUpdate(Request $request, $id)
    {
        $data = User::find($id);
        $wasActive = (int) $data->status === 2;
        $newStatus = (int) $request->status;
        $plainPassword = $request->password;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->usertype = $request->usertype;
        $data->address = $request->address;
        $data->shop_name = $request->shop_name;
        $data->subscription_plan = strtotime($request->subscription_plan);
        $data->gender = $request->gender;
        $data->status = $newStatus;
        if ($newStatus === 1) {
            if (!$wasActive || empty($data->activated_at)) {
                $data->activated_at = now();
            }
        } else {
            $data->activated_at = null;
        }
        // Password is optional - only update if provided
        if (!empty($request->password)) {
            $data->password = \Hash::make($request->password);
        }
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
        $oldUsertype = $data->getOriginal('usertype');
        $newUsertype = $request->usertype;
        $data->update();

        // Log account type change
        if ($oldUsertype !== $newUsertype) {
            \Log::info('Admin changed seller account type', [
                'user_id' => $data->id,
                'from'    => $oldUsertype,
                'to'      => $newUsertype,
                'admin'   => auth()->id(),
            ]);
        }

        // Send welcome SMS when seller is activated for the first time
        if (!$wasActive && $newStatus === 2 && !empty($plainPassword)) {
            try {
                $expireDate = $data->subscription_plan ? date('Y-m-d', $data->subscription_plan) : 'Lifetime';
                $this->sendSellerRegistrationSms($data, $plainPassword, 'N/A', $data->account_type ?? 'Standard', $expireDate);
            } catch (\Exception $e) {
                Log::error('Seller activation SMS failed', ['seller_id' => $id, 'error' => $e->getMessage()]);
            }
        }

        // ── COD Refer Commission: trigger when admin sets payment_status=1 ──
        $wasPaymentPaid = (int)(\DB::table('users')->where('id', $id)->value('payment_status')) === 1;
        $newPaymentStatus = (int)$request->payment_status;

        if (!$wasPaymentPaid && $newPaymentStatus === 1 && $data->reseller_id) {
            try {
                $freshUser = \App\Models\User::find($id);
                if ($freshUser) {
                    $this->distribute_refer_commission($freshUser, 399); // default subscription amount
                    Log::info('COD Refer commission distributed on admin activation', [
                        'seller_id'   => $id,
                        'reseller_id' => $freshUser->reseller_id,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('COD Refer commission failed', ['seller_id' => $id, 'error' => $e->getMessage()]);
            }
        }

        return redirect()->route('sellers.view')->with('success', 'Sellers Profile update successfully !!!');
    }
    public function delete($id)
    {
        $vendor = User::find($id);
        if (!empty($vendor->image)) {
            $imagePath = 'upload/user_images/' . $vendor->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $vendor->delete();
        return redirect()->back()->with('success', 'Data deleted successfully !!!');
    }

    public function sellers_commission(Request $request)
    {
     
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'commission' => 'required|numeric|min:0|max:100',
        ]);
        $user = User::find($request->user_id);
        $user->commission = $request->commission;
        $user->save();
        return response()->json(['success' => true]);
    }
    public function SellerProfileVerify($userid)
    {
        $profiles = \App\Models\ProfileVerify::where('user_id', $userid)->first();
        return view('backend.shopseller.profile-seller', compact('profiles'));
    }
    public function SellerProfileDelete($userid)
    {
        $profiles = \App\Models\ProfileVerify::where('user_id', $userid)->first();
        User::where('id', $userid)->update(['is_profile_verify' => 0]);
        $profiles->delete();
        return redirect()->route('sellers.view')->with('success', 'Data deleted successfully !!!');
    }
    public function ReferBalace(Request $request)
    {
        $request->validate([
            'reseller_id' => 'required|exists:users,id',
            'balance' => 'required|numeric'
        ]);
        $reseller = User::find($request->reseller_id);
        $reseller->update([
            'balance'=> $request->balance
        ]);
        return redirect()->back()->with('success', 'Referral balance updated successfully!');
    }
    public function sellerCommission(Request $request)
{
    // Validate the commission input
    $request->validate([
        'commission' => 'required|numeric|min:0|max:100',
    ]);

    // Update commission for all vendors
    User::where('usertype', 'seller')
        ->update(['commission' => $request->commission]);

    return redirect()->back()->with('success', 'All seller commissions updated successfully.');
}

    /**
     * Unblock a user's login (admin only)
     */
    public function unblockLogin($id)
    {
        $user = \App\Models\User::findOrFail($id);

        $user->login_blocked_at      = null;
        $user->login_blocked_reason  = null;
        $user->failed_login_attempts = 0;
        $user->save();

        \Log::info('Admin unblocked user login', [
            'admin_id' => auth()->id(),
            'user_id'  => $id,
            'email'    => $user->email,
        ]);

        return back()->with('success', "✅ {$user->name}-এর account unblock করা হয়েছে। এখন Login করতে পারবে।");
    }

    /**
     * Show all blocked accounts
     */
    public function blockedAccounts()
    {
        $blocked = \App\Models\User::whereNotNull('login_blocked_at')
            ->whereIn('usertype', ['seller','vendor','dropshipper','customer'])
            ->orderBy('login_blocked_at', 'desc')
            ->get();
        return view('backend.seller.blocked-accounts', compact('blocked'));
    }

}