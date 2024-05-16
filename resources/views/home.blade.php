<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HitMaster Arcade</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-4">
        <header class="flex justify-between items-center my-4">
            <img src="{{ asset('images/hitmaster.png') }}" alt="HitMaster Arcade Logo">
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
                <h1 class="text-4xl font-bold">Derniers Produits</h1>
                <p class="text-gray-400">Améliorez votre confort de jeu avec nos nouvelles box</p>
                <button class="mt-4">Explorer</button>
                <div class="flex justify-center mt-8 space-x-4">
                    <div class="card">
                        <img src="{{ asset('images/black_controller.webp') }}" alt="HitMaster α" class="mb-2">
                        <p>HitMaster α - 100€</p>
                    </div>
                    <div class="card">
                        <img src="{{ asset('images/white_controller.webp') }}" alt="HitMaster β" class="mb-2">
                        <p>HitMaster β - 120€</p>
                    </div>

                </div>
            </section>
            <section class="text-center mb-8">
                <h2 class="text-3xl font-bold">Dernières News</h2>
                <div class="flex justify-center mt-4 space-x-4">
                    <div class="card">
                        <p>Découvrez le Futur du Gaming avec HitMaster Arcade : Lancement Officiel en 2025</p>
                    </div>
                    <div class="card">
                        <p>LANCEMENT 2025</p>
                    </div>
                </div>
            </section>
            <section class="text-center mb-8">
                <h2 class="text-3xl font-bold">Avis de nos clients</h2>
                <div class="flex justify-center mt-4 space-x-4">
                    <div class="review-card">
                        <p>“Je suis devenu trop fort depuis que j'ai une HitMaster α”</p>
                        <p>- Jean-Didier, joueur occasionnel</p>
                    </div>
                    <div class="review-card">
                        <p>“Mes combos sortent tout seuls!”</p>
                        <p>- Anne-Marie, débutante</p>
                    </div>
                    <div class="review-card">
                        <p>“J'ai pas perdu un seul tournoi depuis que j'ai la HitMaster β”</p>
                        <p>- ShredG0dX, joueur professionnel</p>
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