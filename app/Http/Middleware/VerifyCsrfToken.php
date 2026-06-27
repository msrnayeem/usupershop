<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // bKash payment callbacks — must be excluded from CSRF
        'api/callback/bkash',
        'api/bkash/*',
        'payment/bkash/callback',
        'payment/callback/*',
        // Webhook endpoints if any
        'webhook/*',
    ];
}
