<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProjectExpiry
{
    /**
     * Handle an incoming request.
     * 
     * This middleware checks if user needs email/OTP verification.
     * Note: Project expiry check has been removed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is inactive with pending verification code
        if (Auth::check() && Auth::user()->status == 0 && Auth::user()->code !== null) {
            return redirect()->route('logout2');
        }

        return $next($request);
    }
}
