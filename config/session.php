<?php

use Illuminate\Support\Str;

return [
    'driver' => env('SESSION_DRIVER', 'database'),

    // User session configuration
    'user' => [
        'driver' => 'database',
        'table' => 'sessions',
        'lottery' => [2, 100],
    ],

    // Admin session configuration
    'admin' => [
        'driver' => 'database',
        'table' => 'admin_sessions',
        'lottery' => [2, 100],
    ],

    // General session settings
    'lifetime' => env('SESSION_LIFETIME', 120),
    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),
    'encrypt' => env('SESSION_ENCRYPT', false),
    'files' => storage_path('framework/sessions'),
    'connection' => null,
    'store' => null,
    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),
    'path' => '/',
    'domain' => env('SESSION_DOMAIN', null),
    'secure' => env('SESSION_SECURE_COOKIE', false),
    'http_only' => true,
    'same_site' => 'lax',
];

