<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Anti-clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        // Prevent MIME sniffing - critical for file upload attacks
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        // XSS filter
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        // Referrer
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        // Remove server fingerprinting
        $response->headers->remove('Server');
        $response->headers->remove('X-Powered-By');
        // Permissions policy - disable unnecessary browser features
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');
        // Content Security Policy - allow same origin + CDNs used
        $response->headers->set('Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://ajax.googleapis.com https://embed.tawk.to; " .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://code.ionicframework.com; " .
            "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com https://code.ionicframework.com data:; " .
            "img-src 'self' data: blob: https:; " .
            "connect-src 'self' https://embed.tawk.to wss://ws.tawk.to; " .
            "frame-src 'self' https://pgw.bkash.com https://checkout.bkash.com; " .
            "object-src 'none'; base-uri 'self';"
        );
        // HSTS - only on HTTPS
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        return $response;
    }
}
