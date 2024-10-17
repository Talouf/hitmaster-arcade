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
        $sessionLocale = Session::get('applocale');
        $configLocale = config('app.locale');

        $locale = $sessionLocale ?: $configLocale;

        // Ensure the locale is valid
        if (!in_array($locale, ['en', 'fr'])) {
            $locale = $configLocale;
        }

        Log::info("SetLocale Middleware - Request URL: " . $request->fullUrl());
        Log::info("SetLocale Middleware - Session Locale: " . ($sessionLocale ?: 'not set'));
        Log::info("SetLocale Middleware - Config Locale: " . $configLocale);
        Log::info("SetLocale Middleware - Setting locale to: " . $locale);

        App::setLocale($locale);
        Session::put('applocale', $locale);

        return $next($request);
    }
}