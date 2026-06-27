<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    /**
     * Ensure only main admin can access staff management
     */
    private function onlyMainAdmin()
    {
        if (Auth::user()->usertype !== 'admin') {
            abort(403, 'শুধু Main Admin এই section access করতে পারবে।');
        }
    }

    public function index()
    {
        $this->onlyMainAdmin();
        $staffList = Staff::with(['user', 'createdBy'])
            ->where('created_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('backend.staff.index', compact('staffList'));
    }

    public function create()
    {
        $this->onlyMainAdmin();
        $modules = Staff::MODULES;
        return view('backend.staff.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $this->onlyMainAdmin();

        $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|unique:users,email',
            'mobile'      => 'required|regex:/^01[3-9][0-9]{8}$/|unique:users,mobile',
            'password'    => 'required|min:6|confirmed',
            'role'        => 'required|in:manager,employee',
            'permissions' => 'required|array|min:1',
        ], [
            'permissions.required' => 'কমপক্ষে একটি Permission দিতে হবে।',
            'mobile.regex'         => 'সঠিক বাংলাদেশি নম্বর দিন।',
            'password.confirmed'   => 'Password match করেনি।',
        ]);

        // Validate all permissions are valid modules
        $validModules = array_keys(Staff::MODULES);
        foreach ($request->permissions as $perm) {
            if (!in_array($perm, $validModules)) {
                return back()->withErrors(['permissions' => 'Invalid permission: ' . $perm]);
            }
        }

        // Create user account
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'mobile'   => $request->mobile,
            'password' => Hash::make($request->password),
            'status'   => 1,
        ]);
        // Set usertype directly (not via mass assignment)
        $user->usertype = 'staff';
        $user->save();

        // Create staff record
        Staff::create([
            'user_id'     => $user->id,
            'role'        => $request->role,
            'permissions' => $request->permissions,
            'is_active'   => 1,
            'created_by'  => Auth::id(),
        ]);

        Log::info('New staff created', ['admin' => Auth::id(), 'staff_user' => $user->id, 'role' => $request->role]);

        return redirect()->route('staff.index')
            ->with('success', "✅ {$request->name} সফলভাবে {$request->role} হিসেবে যোগ হয়েছে!");
    }

    public function edit($id)
    {
        $this->onlyMainAdmin();
        $staff   = Staff::with('user')->findOrFail($id);
        $modules = Staff::MODULES;
        return view('backend.staff.edit', compact('staff', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $this->onlyMainAdmin();

        $staff = Staff::with('user')->findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|unique:users,email,' . $staff->user_id,
            'mobile'      => 'nullable|regex:/^01[3-9][0-9]{8}$/|unique:users,mobile,' . $staff->user_id,
            'role'        => 'required|in:manager,employee',
            'permissions' => 'required|array|min:1',
            'new_password'=> 'nullable|min:6|confirmed',
        ]);

        // Update user info
        $staff->user->name   = $request->name;
        $staff->user->email  = $request->email;
        if (!empty($request->mobile)) $staff->user->mobile = $request->mobile;
        if (!empty($request->new_password)) {
            $staff->user->password = Hash::make($request->new_password);
        }
        $staff->user->save();

        // Update staff record
        $staff->role        = $request->role;
        $staff->permissions = $request->permissions;
        $staff->is_active   = $request->has('is_active') ? 1 : 0;
        $staff->save();

        Log::info('Staff updated', ['admin' => Auth::id(), 'staff_id' => $id]);

        return redirect()->route('staff.index')
            ->with('success', "✅ {$request->name}-এর তথ্য আপডেট হয়েছে!");
    }

    public function toggleActive($id)
    {
        $this->onlyMainAdmin();
        $staff            = Staff::with('user')->findOrFail($id);
        $staff->is_active = $staff->is_active ? 0 : 1;
        $staff->save();
        $status = $staff->is_active ? 'Active' : 'Inactive';
        return back()->with('success', "{$staff->user->name} → {$status} করা হয়েছে।");
    }

    public function destroy($id)
    {
        $this->onlyMainAdmin();
        $staff = Staff::with('user')->findOrFail($id);
        $name  = $staff->user->name ?? 'Staff';
        // Soft delete: deactivate and mark usertype as 'customer'
        $staff->user->usertype = 'customer';
        $staff->user->status   = 0;
        $staff->user->save();
        $staff->delete();
        Log::info('Staff deleted', ['admin' => Auth::id(), 'staff_id' => $id]);
        return back()->with('success', "✅ {$name} মুছে ফেলা হয়েছে।");
    }
}
