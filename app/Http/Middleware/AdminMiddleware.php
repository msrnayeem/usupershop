<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Staff;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        }

        $user = Auth::user();

        // ── 1. Main Admin → Full Access ────────────────────────────────
        if ($user->usertype === 'admin') {
            return $next($request);
        }

        // ── 2. Staff (Manager/Employee) → Permission-based Access ──────
        if ($user->usertype === 'staff') {
            $staff = Staff::where('user_id', $user->id)
                          ->where('is_active', 1)
                          ->first();

            if (!$staff) {
                Auth::logout();
                return redirect()->route('home')
                    ->with('error', 'আপনার account inactive। Admin-এর সাথে যোগাযোগ করুন।');
            }

            // Check route permission
            $routeName = $request->route()?->getName() ?? '';

            // Always allow dashboard home and logout
            $alwaysAllow = ['home', 'adminlogin.logout', 'profiles.view', 'profiles.update'];
            if (in_array($routeName, $alwaysAllow)) {
                return $next($request);
            }

            // Check module permission
            if ($staff->canAccessRoute($routeName)) {
                // ── Protect main admin data from staff ─────────────────
                // Staff cannot edit main admin's account
                if ($this->isAttemptingMainAdminEdit($request, $routeName)) {
                    abort(403, 'মেইন Admin-এর তথ্য পরিবর্তন করার অনুমতি নেই।');
                }

                // Managers cannot edit other managers
                if ($staff->role === 'manager' && $this->isAttemptingOtherStaffEdit($request, $user->id)) {
                    abort(403, 'অন্য Manager বা Employee-র তথ্য পরিবর্তন করার অনুমতি নেই।');
                }

                return $next($request);
            }

            // Permission denied
            Log::warning('Staff unauthorized route access', [
                'staff_id' => $user->id,
                'role'     => $staff->role,
                'route'    => $routeName,
                'url'      => $request->fullUrl(),
            ]);

            if ($request->expectsJson()) {
                return response()->json(['error' => 'এই section-এ আপনার access নেই।'], 403);
            }

            return redirect()->route('home')
                ->with('error', '⛔ এই section-এ আপনার access নেই।');
        }

        // ── 3. Not admin or staff → Block ──────────────────────────────
        Log::warning('Unauthorized admin access attempt', [
            'ip'       => $request->ip(),
            'url'      => $request->fullUrl(),
            'usertype' => $user->usertype,
        ]);

        // Block IP after repeated attempts
        $key      = 'admin_block:' . $request->ip();
        $attempts = Cache::get($key, 0) + 1;
        Cache::put($key, $attempts, now()->addMinutes(10));
        if ($attempts >= 20) abort(403, 'Access denied.');

        return redirect()->route('home');
    }

    /**
     * Check if trying to edit main admin account
     */
    private function isAttemptingMainAdminEdit(Request $request, string $routeName): bool
    {
        $editRoutes = ['users.update', 'users.edit', 'adminlogin.update'];
        if (!in_array($routeName, $editRoutes)) return false;

        $id = $request->route('id') ?? $request->route('user');
        if (!$id) return false;

        $targetUser = \App\Models\User::find($id);
        return $targetUser && $targetUser->usertype === 'admin';
    }

    /**
     * Check if manager trying to edit another staff member
     */
    private function isAttemptingOtherStaffEdit(Request $request, int $currentUserId): bool
    {
        $editRoutes = ['users.update', 'users.edit'];
        $routeName  = $request->route()?->getName() ?? '';
        if (!in_array($routeName, $editRoutes)) return false;

        $id = $request->route('id') ?? $request->route('user');
        if (!$id || (int)$id === $currentUserId) return false;

        $targetUser  = \App\Models\User::find($id);
        $targetStaff = $targetUser ? Staff::where('user_id', $targetUser->id)->first() : null;
        return $targetStaff !== null;
    }
}
