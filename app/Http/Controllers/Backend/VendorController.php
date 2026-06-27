<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Traits\SendSmsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    use SendSmsTrait;
    public function view()
    {
        $pageTitle = 'Vendor List';
        $vendors = User::where('usertype', 'vendor')->orderBy('id','DESC');
        if(request()->has('active')){
            $pageTitle = 'Active Vendor List';
            $vendors = $vendors->where('status', 1);
        }
        else if(request()->has('inactive')){
            $pageTitle = 'Inactive Vendor List';
            $vendors = $vendors->where('status', 0);
        }
        else if(request()->has('suspended')){
            $pageTitle = 'Suspended Vendor List';
            $vendors = $vendors->where('status', 2);
        }
        else if(request()->has('paid')){
            $pageTitle = 'Paid Vendor List';
            $vendors = $vendors->where('payment_status', 1);
        }
        else if(request()->has('unpaid')){
            $pageTitle = 'Unpaid Vendor List';
            $vendors = $vendors->where('payment_status', 0);
        }


        $vendors = $vendors->get();
        return view('backend.vendor.view-vendor', compact('vendors', 'pageTitle'));
    }
    public function vendorEdit($id){
        $editData = User::find($id);
        $createDate = date('d-m-Y', $editData->subscription_plan);
        return view('backend.vendor.add-vendor', compact('editData','createDate'));
    }
    public function vendorUpdate(Request $request,$id){
        $data = User::find($id);
        $wasActive = (int) $data->status === 2;
        $newStatus = (int) $request->status;
        $plainPassword = $request->password;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->usertype = $request->usertype;
        $data->mobile = $request->mobile;
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
        if($request->file('image')){
            $file = $request->file('image');
            @unlink(public_path('upload/user_images/'.$data->image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['image'] = $filename;
        }
        if($request->file('logo')){
            $file = $request->file('logo');
            @unlink(public_path('upload/user_images/'.$data->logo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['logo'] = $filename;
        }
        $oldUsertype = $data->getOriginal('usertype');
        $newUsertype = $request->usertype;
        $data->save();

        // Log account type change
        if ($oldUsertype !== $newUsertype) {
            \Log::info('Admin changed account type', [
                'user_id'   => $data->id,
                'from'      => $oldUsertype,
                'to'        => $newUsertype,
                'admin_id'  => auth()->id(),
            ]);
        }

        // Send welcome SMS when vendor is activated for the first time
        if (!$wasActive && $newStatus === 2 && !empty($plainPassword)) {
            try {
                $expireDate = $data->subscription_plan ? date('Y-m-d', $data->subscription_plan) : 'Lifetime';
                $this->sendVendorRegistrationSms($data, $plainPassword, 'N/A', $data->account_type ?? 'Standard', $expireDate);
            } catch (\Exception $e) {
                Log::error('Vendor activation SMS failed', ['vendor_id' => $id, 'error' => $e->getMessage()]);
            }
        }
        
        return redirect()->back()->with('success','Vendor Profile update successfully !!!');
    }
    public function vendorList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');
        $Data = [];
        $Result = User::getVendorResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
            $EditRoute = route('vendors.edit', $Res->id);
            $DeleteRoute = route('vendors.delete', $Res->id);
            $VerifyRoute = route('vendors.profile.verify', $Res->id);
            $action = "<a title='Edit' class='btn btn-sm btn-primary' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            $action .= "<a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";
            $action .= "<a title='Vendor Profile' class='btn btn-sm btn-success' href='$VerifyRoute'><i class='fas fa-users'></i> Vendor Profile</a>";
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
            if ($Res->status == 2) {
                $status = '<span style="background:#1BA160;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Active</span>';
            } else {
                $status = '<span style="background:#DD4F42;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Inactive</span>';
            }
            if ($Res->payment_status == 2) {
                $payment_status = '<span style="background:#1BA160;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Paid</span>';
            } else {
                $payment_status = '<span style="background:#DD4F42;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Unpaid</span>';
            }
            $commission = $Res->commission."%";
            $createDate = date('d-m-Y', $Res->subscription_plan);
            $Data[] = array(
                'sn' => $sn,
                'name' => $Res->name,
                'email' => $Res->email,
                'mobile' => $Res->mobile,
                'account_type' => $Res->account_type,
                'shop_name' => $Res->shop_name,
                'createDate' => $createDate,
                'address' => $Res->address,
                'commission' => $commission,
                'payment_status' => $payment_status,
                'status' => $status,
                'action' => $action
            );
            $sn++;
        }
        $res = array(
            "draw" => $draw,
            "iTotalRecords" => User::where('status','=',2)->where('usertype','=','vendor')->count(),
            "iTotalDisplayRecords" => User::where('status','=',2)->where('usertype','=','vendor')->count(),
            "aaData" => $Data
        );

        return response()->json($res);
    }


    public function draftView()
    {
        $data['allData'] = User::where('usertype', 'vendor')->where('payment_status',1)->orderBy('id', 'DESC')->get();
        return view('backend.vendor.draft-vendor', $data);
    }


    public function draftList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = User::getVendorDraftResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
          
            $DeleteRoute = route('vendors.delete', $Res->id);
            $statusChangedPayment = route('vendors.statuschanged', $Res->id);
            $action = "<a title='statusApproved' class='btn btn-sm btn-info'  href='$statusChangedPayment'><i class='fas fa-check-double'></i> Changed Status</a>";
            $action .= "<a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";
            if ($Res->status ==1) {
                $status = '<span style="background:red;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;"> Inactive </span>';
            } else {
                $status = '<span style="background:#DD4F42;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Active</span>';
            }
            if ($Res->payment_status ==1) {
                $payment_status = '<span style="background:red;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;"> Paid</span>';
            } else {
                $payment_status = '<span style="background:#53d05c;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Unpaid</span>';
            }
            $created = new Carbon($Res->created_at);
            $now = Carbon::now();
            $difference = $created->diff($now)->days < 1 ? 'today' : $created->diffForHumans($now);
           
            $Data[] = array(
                'sn' => $sn,
                'name' => $Res->name,
                'email' => $Res->email,
                'mobile' => $Res->mobile,
                'address' => $Res->address,
                'account_type' => $Res->account_type,
                'difference' => $difference,
                'payment_status' => $payment_status,
                'status' => $status,
                'action' => $action
            );
            $sn++;
        }

        $res = array(
            "draw" => $draw,
            /* "iTotalRecords" => User::count(), */
            "iTotalRecords" => User::where('payment_status','=',1)->where('usertype','=','vendor')->count(),
            "iTotalDisplayRecords" => User::where('payment_status','=',1)->where('usertype','=','vendor')->count(),
            "aaData" => $Data
        );

        return response()->json($res);
    }

    public function VendorPaymentStatus($id) {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        $user->payment_status = 2;
        $user->status = 2;
        $user->save();
        return redirect()->back()->with('success', 'Status changed successfully !!!');
    }
    
    public function approved(Request $request)
    {
        $vendorId = $request->id;
        $commission = $request->commission;

        if (empty($vendorId)) {
            $res = ['message' => "Something wrong ! ID no found !!!"];
            return response($res,203)->header('Content-Type','application/json');
        }
        if ($commission == "") {
            $res = ['message' => "Please enter commission value !!!"];
            return response($res,203)->header('Content-Type','application/json');
        }
        if ($commission == 0) {
            $res = ['message' => "Please enter commission at least 1% !!!"];
            return response($res,203)->header('Content-Type','application/json');
        }
        if ($commission > 50) {
            $res = ['message' => "Please enter commission less than or equale 50% !!!"];
            return response($res,203)->header('Content-Type','application/json');
        }

        if(!empty($vendorId)){
            $updateData = User::where('id', $vendorId)->update(['status'=>2, 'payment_status'=>2, 'commission'=>$commission]);
            if ($updateData) {
                $res = ['message' => "Vendor approved successfully !!!"];
                return response($res,202)->header('Content-Type','application/json');
            } else {
                $res = ['message' => "Something wrong !"];
                return response($res,203)->header('Content-Type','application/json');
            }
        }
        //return redirect()->route('vendors.view')->with('success', 'Seller approved successfully !!!');
    }

   public function delete($id)
    {
        $vendor = User::find($id);
        if (!$vendor) {
            return redirect()->back()->with('error', 'Vendor not found!');
        }
        if (!empty($vendor->image)) {
            $imagePath = 'upload/user_images/' . $vendor->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $vendor->delete();
        return redirect()->back()->with('success', 'Vendor deleted successfully!');
    }
    public function VendorProfileVerify($userid){
        $profiles  = \App\Models\ProfileVerify::where('user_id',$userid)->first();
        return view('backend.vendor.vendor-profile-verify',compact('profiles'));
    }
    public function VendorProfileDelete($userid){
        $profiles  = \App\Models\ProfileVerify::where('user_id',$userid)->first();
        User::where('id', $userid)->update(['is_profile_verify' => 0]); 
        $profiles->delete();
        return redirect()->back()->with('success', 'Data deleted successfully !!!');
    }


    public function vendorStatus($id, $status){
        $user = User::findOrFail($id);
        $status = (int) $status;
        $wasActive = (int) $user->status === 1;
        if($status == 0){
            $user->code = rand(100000, 999999);
            $user->status = $status;
            $user->activated_at = null;
            $user->save();
        }
        else if($status == 1){
            $user->code = NULL;
            $user->status = $status;
            if (!$wasActive || empty($user->activated_at)) {
                $user->activated_at = now();
            }
            $user->save();
        }
        else if($status == 2){
            $user->code = NULL;
            $user->status = $status;
            $user->activated_at = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Status Change Success');
    }
    public function vendorPaymentStatus_new($id, $payment_status){
        $user = User::findOrFail($id);
        if($payment_status == 0){
            $user->payment_status = $payment_status;
            $user->save();
        }
        else if($payment_status == 1){
            $user->payment_status = $payment_status;
            $user->save();
        }

        return redirect()->back()->with('success', 'Payment Status Change Success');
    }
    
   public function vendorCommission(Request $request)
{
    // Validate the commission input
    $request->validate([
        'commission' => 'required|numeric|min:0|max:100',
    ]);

    // Update commission for all vendors
    User::where('usertype', 'vendor')
        ->update(['commission' => $request->commission]);

    return redirect()->back()->with('success', 'All vendor commissions updated successfully.');
}
}
