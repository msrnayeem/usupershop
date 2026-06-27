<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function bangla()
    {
        Session::put('language', 'bangla');
        Session::put('locale', 'bn');
        App::setLocale('bn');
        return redirect()->back()
            ->withCookie(cookie()->forever('lang', 'bangla'))
            ->with('lang_changed', 'বাংলা ভাষা নির্বাচিত হয়েছে ✅');
    }

    public function english()
    {
        Session::put('language', 'english');
        Session::put('locale', 'en');
        App::setLocale('en');
        return redirect()->back()
            ->withCookie(cookie()->forever('lang', 'english'))
            ->with('lang_changed', 'English language selected ✅');
    }
}
