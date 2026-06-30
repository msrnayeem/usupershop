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

        // Share categories and subcategories globally with caching
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            static $categories = null;
            if ($categories === null) {
                try {
                    $categories = \Illuminate\Support\Facades\Cache::remember('global_categories_with_sub', 300, function() {
                        return \App\Models\Category::with(['subcategories' => function($q) {
                            $q->withCount('products');
                        }])->withCount('products')->orderBy('id', 'DESC')->get();
                    });
                } catch (\Exception $e) {
                    $categories = collect();
                }
            }
            $view->with('globalCategories', $categories);
        });

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
