<nav>
    <ul class="flex space-x-4">
        <li><a href="{{ route('home') }}">Accueil</a></li>
        <li><a href="{{ route('about') }}">À propos</a></li>
        <li><a href="{{ route('products.index') }}">Produits</a></li>
        <li><a href="{{ route('contact') }}">Contact</a></li>
        <li><a href="{{ route('news.index') }}">News</a></li>
    </ul>
</nav>
<form action="{{ route('search') }}" method="GET" class="search-form">
        <input type="text" name="query" placeholder="Search...">
        <button type="submit">Search</button>
</form>