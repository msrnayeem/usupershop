<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Priority: session > cookie > default (en)
        $lang = Session::get('language', $request->cookie('lang', 'english'));
        
        if ($lang === 'bangla') {
            App::setLocale('bn');
        } else {
            App::setLocale('en');
        }

        return $next($request);
    }
}
