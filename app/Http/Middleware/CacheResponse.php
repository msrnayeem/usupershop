<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Cache GET responses for public pages to reduce DB load under high traffic.
 * Only caches anonymous (non-logged-in) requests.
 */
class CacheResponse
{
    // Pages to cache (seconds)
    protected array $cacheRoutes = [
        'home'          => 120,   // 2 min
        'product.list'  => 120,
        'about'         => 600,   // 10 min
        'contact.index' => 600,
    ];

    public function handle(Request $request, Closure $next, int $ttl = 120)
    {
        // Only cache GET requests for guests
        if ($request->method() !== 'GET' || auth()->check()) {
            return $next($request);
        }

        $cacheKey = 'page_cache_' . sha1($request->fullUrl());

        if (Cache::has($cacheKey)) {
            return response(Cache::get($cacheKey))
                ->header('Content-Type', 'text/html; charset=UTF-8')
                ->header('X-Cache', 'HIT');
        }

        $response = $next($request);

        // Only cache successful HTML responses
        if ($response->getStatusCode() === 200 &&
            str_contains($response->headers->get('Content-Type', ''), 'text/html')) {
            Cache::put($cacheKey, $response->getContent(), $ttl);
            $response->headers->set('X-Cache', 'MISS');
        }

        return $response;
    }
}
