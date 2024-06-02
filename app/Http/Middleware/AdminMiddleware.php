<?php

// app/Http/Middleware/AdminMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        Session::setDefaultDriver('admin');

        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login');
        }

        return $next($request);
    }
}


