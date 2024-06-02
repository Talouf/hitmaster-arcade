<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Admin;
use Illuminate\Auth\EloquentUserProvider;

class AdminAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        // 
    }

    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('admin', function($app, $name, array $config) {
            return new EloquentUserProvider($app['hash'], Admin::class);
        });
    }
}

