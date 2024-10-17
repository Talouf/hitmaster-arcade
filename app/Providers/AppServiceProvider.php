<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Localize;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::extend('admin', function ($app, $name, array $config) {
            return new EloquentUserProvider($app['hash'], Admin::class);
        });

        View::share('cartCount', Session::get('cart_count', 0));

        // Set the application locale
        $sessionLocale = Session::get('applocale');
        $configLocale = config('app.locale');

        $locale = $sessionLocale ?: $configLocale;
        Blade::component('localize', Localize::class);
        Log::info("AppServiceProvider boot method. Session locale: " . ($sessionLocale ?: 'not set'));
        Log::info("AppServiceProvider boot method. Config locale: " . $configLocale);
        Log::info("AppServiceProvider boot method. Setting locale to: " . $locale);

        App::setLocale($locale);
        Session::put('applocale', $locale); // Ensure the session always has a locale set

        // Set the Carbon locale for date translations
        \Carbon\Carbon::setLocale($locale);

        // Share the current locale with all views
        View::share('currentLocale', $locale);
    }
}