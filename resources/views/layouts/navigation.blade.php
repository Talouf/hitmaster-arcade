<!-- resources/views/layouts/navigation.blade.php -->

<nav class="p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo on the left -->
        <div class="flex items-center">
            <img src="{{ asset('images/hitmaster.png') }}" alt="HitMaster Arcade Logo" class="h-13">
        </div>

        <!-- Main menu in the middle -->
        <div class="flex-grow flex justify-center">
            <ul class="hidden md:flex space-x-4" style="font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 18px; color: #FFFFFF;">
                <li><a href="{{ route('home') }}" class="text-white hover:text-gray-300">Accueil</a></li>
                <li><a href="{{ route('about') }}" class="text-white hover:text-gray-300">À propos</a></li>
                <li><a href="{{ route('products.index') }}" class="text-white hover:text-gray-300">Produits</a></li>
                <li><a href="{{ route('contact') }}" class="text-white hover:text-gray-300">Contact</a></li>
                <li><a href="{{ route('news.index') }}" class="text-white hover:text-gray-300">Actualité</a></li>
                @if (auth()->guard('admin')->check())
                    <li><a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-300">DashboardAdmin</a></li>
                @endif
            </ul>
        </div>

        <!-- Search bar, cart, and profile on the right -->
        <div class="hidden md:flex items-center space-x-4">
            <form action="{{ route('search') }}" method="GET" class="flex items-center relative">
                @csrf <!-- CSRF Protection -->
                <input type="text" name="query" placeholder="Recherche..." class="px-2 py-1 transition-all duration-300 ease-in-out w-0" id="searchInput">
                <button type="submit" class="bg-red-500 text-white px-3 py-1 hidden" id="searchButton">Rechercher</button>
                <button type="button" class="text-white" id="searchIcon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 18a8 8 0 100-16 8 8 0 000 16zm6-2l4 4" />
                    </svg>
                </button>
            </form>
            <a href="{{ route('cart.show') }}" class="relative text-white">
                <svg class="h-8 w-8 text-red-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <circle cx="9" cy="19" r="2" />
                    <circle cx="17" cy="19" r="2" />
                    <path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2" />
                </svg>
                <div>
                    <span>Panier: </span><span id="cart-count">{{ $cartCount }}</span>
                </div>
            </a>

            <div class="relative">
                <button id="profileButton" class="hover:text-red-600 focus:outline-none">
                    <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
                <div id="profileMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                    @if (auth()->guard('admin')->check())
                        <span class="block px-4 py-2 text-gray-800">Connecté en tant qu'Admin</span>
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Dashboard</a>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Déconnection</button>
                        </form>
                    @elseif (auth()->check())
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Déconnection</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Connection</a>
                        <a href="{{ route('register') }}"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200">S'inscrire</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden flex items-center space-x-4">
            <button id="menuButton" class="text-white focus:outline-none">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobileMenu" class="md:hidden flex flex-col items-center mt-4 space-y-4">
        <form action="{{ route('search') }}" method="GET" class="flex w-full justify-center">
            @csrf <!-- CSRF Protection -->
            <input type="text" name="query" placeholder="Recherche..." class="px-2 py-1">
            <button type="submit" class="bg-red-500 text-white px-3 py-1">Rechercher</button>
        </form>
        <a href="{{ route('cart.show') }}" class="relative text-white">
            <svg class="h-8 w-8 text-red-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" />
                <circle cx="9" cy="19" r="2" />
                <circle cx="17" cy="19" r="2" />
                <path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2" />
            </svg>
            <div>
                <span>Panier: </span><span id="cart-count">{{ $cartCount }}</span>
            </div>
        </a>
        <div class="relative">
            <button id="mobileProfileButton" class="hover:text-red-600 focus:outline-none">
                <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button>
            <div id="mobileProfileMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                @if (auth()->guard('admin')->check())
                    <span class="block px-4 py-2 text-gray-800">Connecté en tant qu'Admin</span>
                    <a href="{{ route('admin.dashboard') }}"
                        class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Dashboard</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Déconnection</button>
                    </form>
                @elseif (auth()->check())
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Déconnection</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Connection</a>
                    <a href="{{ route('register') }}"
                        class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Register</a>
                @endif
            </div>
        </div>
        <ul class="flex flex-col space-y-2 mt-4 text-center">
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
</nav>