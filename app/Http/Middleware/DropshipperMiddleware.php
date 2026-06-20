<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DropshipperMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Ensure only authorized dropshippers (and optionally admins/vendors)
     * can access dropshipper routes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        // ✅ Allow only dropshippers (you can add others if needed)
        if (in_array($user->usertype, ['dropshipper', 'admin'])) {
            return $next($request);
        }

        // 🚫 Unauthorized access
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
}
