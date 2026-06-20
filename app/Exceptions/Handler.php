<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        // Handle 429 Too Many Requests (rate limit hit)
        $this->renderable(function (ThrottleRequestsException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Too many requests. Please slow down.'
                ], 429);
            }
            return response()->view('errors.429', [], 429);
        });

        // Handle 404 cleanly
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Not found.'], 404);
            }
        });

        // Handle 403
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Access denied.'], 403);
            }
        });

        $this->reportable(function (Throwable $e) {
            // All exceptions are reported to laravel.log automatically
        });
    }

    /**
     * Don't expose internal errors to users in production.
     */
    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);

        // Strip stack traces from JSON error responses in production
        if (app()->environment('production') && $response->getStatusCode() >= 500) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Server error. Please try again later.'
                ], 500);
            }
        }

        return $response;
    }
}
