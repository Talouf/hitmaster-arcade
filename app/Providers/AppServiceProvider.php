<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::extend('admin', function($app, $name, array $config) {
            return new EloquentUserProvider($app['hash'], Admin::class);
        });
        View::share('cartCount', Session::get('cart_count', 0));
    }
}