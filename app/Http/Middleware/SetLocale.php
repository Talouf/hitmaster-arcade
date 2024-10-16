<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('applocale', config('app.locale'));
        App::setLocale($locale);
        Log::info("SetLocale Middleware - App Locale set to: " . App::getLocale());

        return $next($request);
    }
}