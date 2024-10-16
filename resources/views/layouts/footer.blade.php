<!-- resources/views/layouts/footer.blade.php -->

<div class="home_border_top"></div>
<footer class="p-8 text-center mt-auto">
    <div class="container mx-auto">
        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="mb-4">
            @csrf
            <input type="email" name="email" placeholder="Votre Email" class="px-4 py-2 rounded text-gray-800 placeholder-gray-500" required>
            <button type="submit" class="ml-2 px-6 py-2 bg-red-600 text-white rounded">S'abonner</button>
        </form>
        @if (session('newsletter_success'))
            <div class="text-green-500 mb-4">{{ session('newsletter_success') }}</div>
        @endif
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

    footer input[type="email"] {
        color: #333;
    }

    footer input[type="email"]::placeholder {
        color: #666;
    }
</style>