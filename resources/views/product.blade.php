<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du Produit - HitMaster Arcade</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-4">
        <header class="flex justify-between items-center my-4">
            <img src="{{ asset('images/hitmaster.png') }}" alt="HitMaster Arcade Logo" class="w-32">
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="/">Accueil</a></li>
                    <li><a href="/about">À propos</a></li>
                    <li><a href="/products">Produits</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </nav>
            <div class="flex space-x-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4v8l6-4-6-4z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4v8l6-4-6-4z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4v8l6-4-6-4z" />
                </svg>
            </div>
        </header>
        <main>
            <section class="text-center mb-8">
                <h1 class="text-4xl font-bold">{{ $product['name'] }}</h1>
                <p class="text-gray-400 mt-4">{{ $product['description'] }}</p>
                <div class="mt-8">
                    <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="mx-auto rounded-lg">
                    <div class="text-left mt-4">
                        <h2 class="text-2xl font-bold">Détails du Produit</h2>
                        <p>{{ $product['details'] }}</p>
                        <p class="text-primary mt-2 text-2xl">{{ $product['price'] }}€</p>
                        <button class="bg-red-500 text-white py-2 px-4 rounded mt-4">Ajouter au Panier</button>
                    </div>
                </div>
            </section>
        </main>
        <footer class="footer">
            <p>HitMaster Arcade</p>
            <p>&copy; 2024, HitMaster Arcade</p>
            <form class="mt-4">
                <label for="email" class="block mb-2 text-sm">Votre Email</label>
                <input type="email" id="email" class="bg-gray-700 border border-gray-600 rounded py-2 px-4" placeholder="Email">
                <button type="submit">S'abonner</button>
            </form>
        </footer>
    </div>
    @vite('resources/js/app.js')
</body>
</html>
