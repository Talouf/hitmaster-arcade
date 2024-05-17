<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HitMaster Arcade')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-4">
        <header class="flex justify-between items-center my-4">
            <img src="{{ asset('images/hitmaster.png') }}" alt="HitMaster Arcade Logo">
            @include('layouts.navigation')
        </header>
        <main>
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>
    @vite('resources/js/app.js')
</body>

</html>
