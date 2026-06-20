<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function view()
    {
        //$data['allData'] = User::where('usertype', 'customer')->where('status', '1')->orderBy('id', 'DESC')->get();
        return view('backend.customer.view-customer');
    }
    public function edit($id)
    {
        $editData = User::find($id);
        return view('backend.customer.add-customer', compact('editData'));
    }
    public function customerList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = User::getCustomerResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
            $EditRoute = route('customers.edit', $Res->id);
            $DeleteRoute = route('customers.delete', $Res->id);
            $action = "<a title='Edit' class='btn btn-sm btn-primary' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            $action .= "<a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";
            $Data[] = array(
                'sn' => $sn,
                'name' => $Res->name,
                'email' => $Res->email,
                'mobile' => $Res->mobile,
                'address' => $Res->address,
                'action' => $action
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => User::where('status','=','1')->where('usertype','=','customer')->count(),
            "iTotalDisplayRecords" => User::where('status','=','1')->where('usertype','=','customer')->count(),
            "aaData" => $Data
        );

        return response()->json($res);
    }

    public function draftView()
    {
        $data['allData'] = User::where('usertype', 'customer')->where('status', '0')->orderBy('id', 'DESC')->get();
        return view('backend.customer.draft-customer', $data);
    }

    public function customerDraftList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = User::getDraftCustomerResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            /* $EditRoute = route('vendors.edit', $Res->id); */
            $DeleteRoute = route('customers.delete', $Res->id);

            /* $action = "<a title='Edit' class='btn btn-sm btn-primary' href='$EditRoute'><i class='fas fa-edit'></i>
        Edit</a>"; */
            $action = " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";

            if ($Res->status == 1) {
                $status = '<span style="background:#1BA160;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Active</span>';
            } else {
                $status = '<span style="background:#DD4F42;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Inactive</span>';
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
                'difference' => $difference,
                'action' => $action
            );

            $sn++;
        }

        $res = array( 
            "draw" => $draw,
            /* "iTotalRecords" => User::count(),
            "iTotalDisplayRecords" => User::countResult($columns), */
            "iTotalRecords" => User::where('status','=','0')->where('usertype','=','customer')->count(),
            "iTotalDisplayRecords" => User::where('status','=','0')->where('usertype','=','customer')->count(),
            "aaData" => $Data
        );

        return response()->json($res);
    }
    public function update(Request $request,$id){
        $data = User::find($id);
        $data->name = $request->name;
        $data->usertype = 'customer';
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->address = $request->address;
        $data->gender = $request->gender;
        $data->password = Hash::make($request->password);
        if($request->file('image')){
            $file = $request->file('image');
            @unlink(public_path('upload/user_images/'.$data->image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['image'] = $filename;
        }
        $data->save();
        return redirect()->route('customers.view')->with('success','Profile update successfully !!!');
    }
    public function delete($id)
    {
        $customer = User::find($id);
        if (!empty($customer->image)) {
            $imagePath = 'upload/user_images/' . $customer->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted successfully !!!');
    }
}
