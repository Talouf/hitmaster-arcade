<!-- resources/views/layouts/navigation.blade.php -->

<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center">
            <img src="{{ asset('images/hitmaster.png') }}" alt="HitMaster Arcade Logo" class="h-12">
            <ul class="flex space-x-4 ml-6">
                <li><a href="{{ route('home') }}" class="text-white hover:text-gray-300">Accueil</a></li>
                <li><a href="{{ route('about') }}" class="text-white hover:text-gray-300">À propos</a></li>
                <li><a href="{{ route('products.index') }}" class="text-white hover:text-gray-300">Produits</a></li>
                <li><a href="{{ route('contact') }}" class="text-white hover:text-gray-300">Contact</a></li>
                <li><a href="{{ route('news.index') }}" class="text-white hover:text-gray-300">News</a></li>
                @if (auth()->guard('admin')->check())
                <li><a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-300">Dashboard</a></li>
                @endif
            </ul>
        </div>
        <div class="flex items-center space-x-4">
            <form action="{{ route('search') }}" method="GET" class="flex">
                @csrf <!-- CSRF Protection -->
                <input type="text" name="query" placeholder="Search..." class="px-2 py-1">
                <button type="submit" class="bg-red-500 text-white px-3 py-1">Search</button>
            </form>
            <a href="{{ route('cart.show') }}" class="relative text-white">
                <svg class="h-8 w-8 text-red-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <circle cx="9" cy="19" r="2" />
                    <circle cx="17" cy="19" r="2" />
                    <path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2" />
                </svg>
                <div>
                    <span>Cart: </span><span id="cart-count">{{ $cartCount }}</span>
                </div>
            </a><!-- Example: In your header or navbar -->

            <div class="relative">
                <button id="profileButton" class="hover:text-red-600 focus:outline-none">
                    <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
                <div id="profileMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                    @auth
                    <span class="block px-4 py-2 text-gray-800">Hello, {{ htmlspecialchars(Auth::user()->name) }}</span> <!-- Sanitize user input -->
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Login</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>