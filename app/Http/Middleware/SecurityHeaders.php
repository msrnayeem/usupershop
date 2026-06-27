<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // ── 1. Anti-Clickjacking ──────────────────────────────────────
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // ── 2. Prevent MIME-type sniffing ────────────────────────────
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // ── 3. XSS Protection ────────────────────────────────────────
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // ── 4. Referrer Policy ───────────────────────────────────────
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // ── 5. Permissions Policy ────────────────────────────────────
        $response->headers->set('Permissions-Policy',
            'camera=(), microphone=(), geolocation=(), payment=(self), ' .
            'usb=(), magnetometer=(), accelerometer=(), gyroscope=()'
        );

        // ── 6. HSTS (force HTTPS) ────────────────────────────────────
        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        // ── 7. Content Security Policy ───────────────────────────────
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' " .
                "https://cdn.jsdelivr.net " .
                "https://cdnjs.cloudflare.com " .
                "https://embed.tawk.to " .
                "https://www.googletagmanager.com " .
                "https://www.google-analytics.com " .
                "https://securepay.sslcommerz.com " .
                "https://sandbox.sslcommerz.com",
            "style-src 'self' 'unsafe-inline' " .
                "https://fonts.googleapis.com " .
                "https://cdnjs.cloudflare.com " .
                "https://cdn.jsdelivr.net",
            "font-src 'self' " .
                "https://fonts.gstatic.com " .
                "https://cdnjs.cloudflare.com " .
                "data:",
            "img-src 'self' data: blob: " .
                "https: " . // allow all HTTPS images for product imgs
                "http://",
            "connect-src 'self' " .
                "https://embed.tawk.to " .
                "https://www.google-analytics.com " .
                "https://api.callmebot.com " .
                "https://courier-api.pathao.com " .
                "https://portal.packzy.com " .
                "wss://embed.tawk.to",
            "frame-src 'self' " .
                "https://js.payheroes.com " .
                "https://securepay.sslcommerz.com " .
                "https://sandbox.sslcommerz.com",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "upgrade-insecure-requests",
        ]);
        $response->headers->set('Content-Security-Policy', $csp);

        // ── 8. Remove server fingerprints ────────────────────────────
        $response->headers->remove('Server');
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('X-Generator');
        $response->headers->remove('X-AspNet-Version');

        // ── 9. No-cache for sensitive authenticated pages ────────────
        $sensitiveRoutes = ['checkout', 'payment', 'wallet', 'admin', 'dashboard'];
        $uri = $request->path();
        $isSensitive = array_filter($sensitiveRoutes, fn($r) => str_contains($uri, $r));
        if (!empty($isSensitive) || Auth::check()) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
        }

        return $response;
    }
}
