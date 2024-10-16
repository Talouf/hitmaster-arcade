<?php
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

App::setLocale(Session::get('applocale', config('app.locale')));
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="HitMaster Arcade, la référence en matière de jeux vidéo">
    <title>HitMaster Arcade</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto:wght@400&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-white">
    <!-- Navbar -->
    @include('layouts.navigation')

    <main class="py-8">
        @yield('content')
    </main>

    @include('layouts.footer')

    @if(session()->has('locale_changed'))
        <div style="position: fixed; top: 0; left: 0; background: yellow; padding: 5px; z-index: 9999;">
            Current Locale: {{ App::getLocale() }}<br>
            Session Locale: {{ Session::get('applocale', 'Not set') }}<br>
            Home Translation: {{ __('messages.home') }}<br>
            Raw Session Data: {{ json_encode(Session::all()) }}
        </div>
    @endif
</body>

</html>