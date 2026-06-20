<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LoginRateLimiter
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next)
    {
        $key = 'login_attempt:' . $request->ip();

        // Allow max 10 login attempts per 5 minutes per IP
        if (Cache::get($key, 0) >= 10) {
            return response()->json([
                'message' => 'Too many login attempts. Please try again after 5 minutes.'
            ], 429);
        }

        $response = $next($request);

        // If login failed (redirect back or 422), increment counter
        if ($response->getStatusCode() === 302 || $response->getStatusCode() === 422) {
            Cache::increment($key);
            Cache::put($key, Cache::get($key, 0), now()->addMinutes(5));
        } else {
            // Successful login - reset counter
            Cache::forget($key);
        }

        return $response;
    }
}
