<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\CourierService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CourierService::class, function ($app) {
            return new CourierService();
        });

        $this->app->bind('path.public', function () {
            return base_path();
        });
    }

    public function boot()
    {
        Paginator::useBootstrap();

        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Log slow queries (> 2 seconds) for performance monitoring
        if (config('app.debug') === false) {
            DB::listen(function ($query) {
                if ($query->time > 2000) {
                    Log::warning('Slow DB query detected', [
                        'sql'      => $query->sql,
                        'time_ms'  => $query->time,
                        'bindings' => $query->bindings,
                    ]);
                }
            });
        }
    }
}
