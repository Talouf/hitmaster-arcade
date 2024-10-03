<!-- resources/views/layouts/footer.blade.php -->

<div class="home_border_top"></div>
<footer class="p-8 text-center mt-auto">
    <div class="container mx-auto">
        <div class="mb-4">
            <input type="email" placeholder="Votre Email" class="px-4 py-2 rounded">
            <button class="ml-2 px-6 py-2 bg-red-600 text-white rounded">S'abonner</button>
        </div>
        <p class="text-gray-400">HitMaster Arcade</p>
        <div class="mt-4 flex justify-center space-x-4">
            <a href="#" class="text-gray-400 hover:text-white">FAQ</a>
            <a href="{{ route('about') }}" class="text-gray-400 hover:text-white">À propos de nous</a>
            <a href="{{ route('mentions') }}" class="text-gray-400 hover:text-white">Mentions Légales</a>
        </div>
        <p class="mt-4 text-gray-400">2024, HitMaster Arcade</p>
    </div>
</footer>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        flex: 1;
    }
</style>