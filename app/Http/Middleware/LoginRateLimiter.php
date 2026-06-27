<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Log;

class LoginRateLimiter
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next, int $maxAttempts = 10, int $decayMinutes = 15)
    {
        // Keys: per-IP and per-email combination
        $ipKey    = 'login_ip:'  . $request->ip();
        $emailKey = 'login_em:'  . md5(strtolower($request->input('email', '')));

        // ── Check if blocked ─────────────────────────────────────────
        if ($this->limiter->tooManyAttempts($ipKey, $maxAttempts) ||
            $this->limiter->tooManyAttempts($emailKey, $maxAttempts)) {

            $retryAfter = max(
                $this->limiter->availableIn($ipKey),
                $this->limiter->availableIn($emailKey)
            );

            Log::warning('Login rate limit hit', [
                'ip'    => $request->ip(),
                'email' => $request->input('email'),
                'url'   => $request->fullUrl(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'অনেকবার চেষ্টা করা হয়েছে। ' . ceil($retryAfter / 60) . ' মিনিট পরে আবার চেষ্টা করুন।',
                ], 429)->header('Retry-After', $retryAfter);
            }

            return redirect()->back()
                ->withInput($request->except('password'))
                ->withErrors(['email' => '⛔ অনেকবার ভুল চেষ্টা। ' . ceil($retryAfter / 60) . ' মিনিট পরে চেষ্টা করুন।']);
        }

        $response = $next($request);

        // ── On failed login, increment ───────────────────────────────
        if ($request->method() === 'POST') {
            // Check if authentication failed (redirect back = failure)
            if ($response->getStatusCode() === 302 &&
                str_contains($response->headers->get('Location', ''), $request->getPathInfo())) {
                $this->limiter->hit($ipKey,    $decayMinutes * 60);
                $this->limiter->hit($emailKey, $decayMinutes * 60);
            } else {
                // Success — clear attempts
                $this->limiter->clear($ipKey);
                $this->limiter->clear($emailKey);
            }
        }

        return $response;
    }
}
