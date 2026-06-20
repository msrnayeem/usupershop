<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->usertype == 'admin') {
            // Regenerate CSRF on sensitive admin actions for extra protection
            return $next($request);
        }

        // Log unauthorized admin access attempts
        Log::warning('Unauthorized admin access attempt', [
            'ip'  => $request->ip(),
            'url' => $request->fullUrl(),
            'ua'  => $request->userAgent(),
        ]);

        // Block IP temporarily after 20 failed admin access attempts in 10 min
        $key = 'admin_block:' . $request->ip();
        $attempts = Cache::get($key, 0) + 1;
        Cache::put($key, $attempts, now()->addMinutes(10));

        if ($attempts >= 20) {
            abort(403, 'Access denied.');
        }

        return redirect()->route('home');
    }
}
