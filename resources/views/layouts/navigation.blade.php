<!-- resources/views/layouts/navigation.blade.php -->

<nav class="p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo on the left -->
        <div class="flex items-center">
            <img src="{{ asset('images/hitmaster.png') }}" alt="HitMaster Arcade Logo" class="h-13">
        </div>

        <!-- Main menu in the middle (hidden on mobile) -->
        <div class="hidden md:flex flex-grow justify-center">
            <ul class="flex space-x-4"
                style="font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 18px; color: #FFFFFF;">
                <li><a href="{{ route('home') }}" class="text-white hover:text-gray-300">{{ __('messages.home') }}</a>
                </li>
                <li><a href="{{ route('about') }}" class="text-white hover:text-gray-300">{{ __('messages.about') }}</a>
                </li>
                <li><a href="{{ route('products.index') }}"
                        class="text-white hover:text-gray-300">{{ __('messages.products') }}</a></li>
                <li><a href="{{ route('contact') }}"
                        class="text-white hover:text-gray-300">{{ __('messages.contact') }}</a></li>
                <li><a href="{{ route('news.index') }}"
                        class="text-white hover:text-gray-300">{{ __('messages.news') }}</a></li>
                @if (Auth::guard('admin')->check())
                    <li><a href="{{ route('admin.dashboard') }}"
                            class="text-white hover:text-gray-300">{{ __('messages.admin_dashboard') }}</a></li>
                @endif
            </ul>
        </div>

        <!-- Search bar, cart, profile, and language switcher on the right (hidden on mobile) -->
        <div class="hidden md:flex items-center space-x-4">
            <form action="{{ route('search') }}" method="GET" class="relative">
                @csrf
                <input type="text" name="query" placeholder="{{ __('messages.search') }}"
                    class="bg-gray-800 text-white placeholder-gray-400 rounded-full py-1 px-4 pr-10 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-300 w-48"
                    id="searchInput">
                <button type="submit"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
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
                <span
                    class="cart-count absolute top-0 right-0 -mt-1 -mr-1 bg-red-600 text-white rounded-full text-xs px-1">{{ $cartCount ?? 0 }}</span>
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
                        <span class="block px-4 py-2 text-gray-800">{{ __('messages.logged_as_admin') }}</span>
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200">{{ __('messages.dashboard') }}</a>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-200">{{ __('messages.logout') }}</button>
                        </form>
                    @elseif (auth()->check())
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200">{{ __('messages.profile') }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-200">{{ __('messages.logout') }}</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200">{{ __('messages.login') }}</a>
                        <a href="{{ route('register') }}"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200">{{ __('messages.register') }}</a>
                    @endif
                </div>
            </div>
            <div class="language-switcher">
                @if(app()->getLocale() == 'en')
                    <a href="{{ route('lang.switch', 'fr') }}" class="text-white hover:text-gray-300">Français</a>
                @else
                    <a href="{{ route('lang.switch', 'en') }}" class="text-white hover:text-gray-300">English</a>
                @endif
            </div>
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden">
            <button id="menuButton" class="text-white focus:outline-none">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobileMenu" class="md:hidden hidden bg-gray-800 mt-4">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">{{ __('messages.home') }}</a>
            <a href="{{ route('about') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">{{ __('messages.about') }}</a>
            <a href="{{ route('products.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">{{ __('messages.products') }}</a>
            <a href="{{ route('contact') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">{{ __('messages.contact') }}</a>
            <a href="{{ route('news.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">{{ __('messages.news') }}</a>
            @if (Auth::guard('admin')->check())
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">{{ __('messages.admin_dashboard') }}</a>
            @endif
        </div>
        <div class="px-2 pt-2 pb-3 border-t border-gray-700">
            <a href="{{ route('cart.show') }}"
                class="flex items-center px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">
                <svg class="h-6 w-6 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {{ __('messages.cart') }} (<span id="mobileCartCount">{{ $cartCount ?? 0 }}</span>)
            </a>
            @if (auth()->check())
                <a href="{{ route('profile.edit') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">{{ __('messages.profile') }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">{{ __('messages.logout') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">{{ __('messages.login') }}</a>
                <a href="{{ route('register') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">{{ __('messages.register') }}</a>
            @endif
        </div>
        <div class="px-2 pt-2 pb-3 border-t border-gray-700">
            <form action="{{ route('search') }}" method="GET" class="flex">
                @csrf
                <input type="text" name="query" placeholder="{{ __('messages.search') }}"
                    class="flex-grow bg-gray-700 text-white placeholder-gray-400 rounded-l-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-red-500">
                <button type="submit"
                    class="bg-red-500 text-white rounded-r-md px-4 py-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                    {{ __('messages.search') }}
                </button>
            </form>
        </div>
        <div class="px-2 pt-2 pb-3 border-t border-gray-700">
            @if(app()->getLocale() == 'en')
                <a href="{{ route('lang.switch', 'fr') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">Français</a>
            @else
                <a href="{{ route('lang.switch', 'en') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-300 hover:bg-gray-700">English</a>
            @endif
        </div>
    </div>
</nav>