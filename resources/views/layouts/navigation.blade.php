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
            </ul>
        </div>
        <div class="flex items-center space-x-4">
            <form action="{{ route('search') }}" method="GET" class="flex">
                <input type="text" name="query" placeholder="Search..." class="px-2 py-1">
                <button type="submit" class="bg-red-500 text-white px-3 py-1">Search</button>
            </form>
            <a href="{{ route('cart.show') }}" class="relative text-white">
                <i class="fa fa-shopping-cart"></i>
                <span class="absolute top-0 right-0 inline-block w-6 h-6 bg-red-600 text-center text-white rounded-full">
                    {{ \App\Models\OrderItem::where('user_id', auth()->id())->where('is_ordered', false)->count() }}
                </span>
            </a>
            <div class="relative">
                <button class="text-white hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4c2.761 0 5 2.239 5 5s-2.239 5-5 5-5-2.239-5-5 2.239-5 5-5zm0 2a3 3 0 100 6 3 3 0 000-6z" />
                    </svg>
                </button>
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                    @auth
                    <span class="block px-4 py-2 text-gray-800">Welcome, {{ Auth::user()->name }}</span>
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
