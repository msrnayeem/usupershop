<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function view()
    {
        $data['allData'] = User::where('usertype', 'admin')->where('status', '1')->orderBy('id', 'DESC')->get();
        return view('backend.user.view-user', $data);
    }

    public function list(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = User::getUsersResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            $EditRoute = route('users.edit', $Res->id);
            $DeleteRoute = route('users.delete', $Res->id);

            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            if($Res->id != 1){
                 $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";
            }else{  
                 $action .= " <button class='btn btn-sm btn-secondary' disabled><i class='fas fa-ban'></i> Delete</button>";
            }
            

            $Data[] = array(
                'sn' => $sn,
                'role' => $Res->role,
                'name' => $Res->name,
                'email' => $Res->email,
                'action' => $action
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => User::count(),
            "iTotalDisplayRecords" => User::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }

    public function add()
    {
        return view('backend.user.add-user');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|max:32'
        ]);

        $data = new User();
        $data->usertype = 'admin';
        $data->role = $request->role;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->save();
        //$this->setSuccessMessage('Your user is created successfully !!!');
        return redirect()->route('users.view')->with('success', 'User data created successfully');
    }

    public function edit($id)
    {
        $editData = User::find($id);
        return view('backend.user.edit-user', compact('editData'));
    }

    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);

        $this->validate($request, [
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email,' . $id,
            'mobile'       => 'nullable|regex:/^01[3-9][0-9]{8}$/|unique:users,mobile,' . $id,
            'new_password' => 'nullable|min:6|max:32|confirmed',
        ], [
            'email.unique'   => 'এই Email অন্য account-এ ব্যবহৃত হচ্ছে।',
            'mobile.unique'  => 'এই Phone Number অন্য account-এ ব্যবহৃত হচ্ছে।',
            'mobile.regex'   => 'সঠিক বাংলাদেশি নম্বর দিন (01XXXXXXXXX)।',
            'new_password.confirmed' => 'Password confirm করুন।',
            'new_password.min' => 'Password কমপক্ষে ৬ অক্ষর হতে হবে।',
        ]);

        // ── Basic info ────────────────────────────────────────────────────
        $data->name  = $request->name;
        $data->email = $request->email;

        if (!empty($request->mobile)) {
            $data->mobile = $request->mobile;
        }

        // ── Password change (optional) ────────────────────────────────────
        if (!empty($request->new_password)) {
            $data->password = \Hash::make($request->new_password);
        }

        $data->save();

        return redirect()->route('users.edit', $id)
            ->with('success', '✅ User সফলভাবে আপডেট হয়েছে!');
    }

    /* public function delete($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.view')->with('success','Data deleted successfully !!!');
    } */
     public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.view')->with('error', 'User not found!');
        }
        if (!empty($user->image)) {
            $imagePath = 'upload/user_images/' . $user->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $user->delete();
        return redirect()->route('users.view')->with('success', 'Data deleted successfully !!!');
    }

}
