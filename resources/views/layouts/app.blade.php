<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="HitMaster Arcade, la référence en matière de jeux vidéo">
    <title>HitMaster Arcade</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/navigation.js'])
</head>
<body class="bg-gray-900 text-white">
    <!-- Navbar -->
    @include('layouts.navigation')
    <main class="py-8">
        @yield('content')
        
    </main>
    @include('layouts.footer')

</body>
</html>
