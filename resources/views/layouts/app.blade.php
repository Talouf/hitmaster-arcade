<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HitMaster Arcade')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white font-sans">
    <div class="container mx-auto px-4">
        <header class="flex justify-between items-center py-4">
            @include('layouts.navigation')
        </header>
        <main class="py-8">
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>
</body>
</html>
