<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits - HitMaster Arcade</title>
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
                <h1 class="text-4xl font-bold">Nos Produits</h1>
                <p class="text-gray-400 mt-4">Découvrez notre gamme de contrôleurs de jeu de haute qualité.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                    <!-- Produit 1 -->
                    <div class="card">
                        <a href="/product/1">
                            <img src="{{ asset('images/white_controller.webp') }}" alt="HitMaster Alpha" class="mb-4 rounded-lg">
                            <h2 class="text-xl font-bold">HitMaster Alpha</h2>
                            <p class="text-gray-400">Contrôleur de jeu précis et durable.</p>
                            <p class="text-primary mt-2">100€</p>
                        </a>
                    </div>
                    <!-- Produit 2 -->
                    <div class="card">
                        <a href="/product/2">
                            <img src="{{ asset('images/black_controller.webp') }}" alt="HitMaster Beta" class="mb-4 rounded-lg">
                            <h2 class="text-xl font-bold">HitMaster Beta</h2>
                            <p class="text-gray-400">Design ergonomique pour un confort maximal.</p>
                            <p class="text-primary mt-2">120€</p>
                        </a>
                    </div>
                    <!-- Produit 3 -->
                    <div class="card">
                        <a href="/product/3">
                            <img src="{{ asset('images/white_controller.webp') }}" alt="HitMaster Gamma" class="mb-4 rounded-lg">
                            <h2 class="text-xl font-bold">HitMaster Gamma</h2>
                            <p class="text-gray-400">Haute performance et réactivité.</p>
                            <p class="text-primary mt-2">150€</p>
                        </a>
                    </div>
                    <!-- Produit 4 -->
                    <div class="card">
                        <a href="/product/4">
                            <img src="{{ asset('images/black_controller.webp') }}" alt="HitMaster Delta" class="mb-4 rounded-lg">
                            <h2 class="text-xl font-bold">HitMaster Delta</h2>
                            <p class="text-gray-400">Conçu pour les joueurs professionnels.</p>
                            <p class="text-primary mt-2">200€</p>
                        </a>
                    </div>
                    <!-- Produit 5 -->
                    <div class="card">
                        <a href="/product/5">
                            <img src="{{ asset('images/white_controller.webp') }}" alt="HitMaster Epsilon" class="mb-4 rounded-lg">
                            <h2 class="text-xl font-bold">HitMaster Epsilon</h2>
                            <p class="text-gray-400">Durabilité et confort exceptionnel.</p>
                            <p class="text-primary mt-2">180€</p>
                        </a>
                    </div>
                    <!-- Produit 6 -->
                    <div class="card">
                        <a href="/product/6">
                            <img src="{{ asset('images/black_controller.webp') }}" alt="HitMaster Zeta" class="mb-4 rounded-lg">
                            <h2 class="text-xl font-bold">HitMaster Zeta</h2>
                            <p class="text-gray-400">Idéal pour les tournois et les compétitions.</p>
                            <p class="text-primary mt-2">220€</p>
                        </a>
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
