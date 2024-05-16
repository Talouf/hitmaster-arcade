<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - HitMaster Arcade</title>
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
                <h1 class="text-4xl font-bold">À propos de HitMaster Arcade</h1>
                <p class="text-gray-400 mt-4">Votre destination ultime pour des contrôleurs de jeu de qualité supérieure.</p>
                <div class="mt-8 text-left space-y-4">
                    <h2 class="text-3xl font-bold">Notre Histoire</h2>
                    <p>Chez HitMaster Arcade, nous sommes passionnés par le jeu et nous croyons en la création de produits qui améliorent véritablement l'expérience de jeu. Fondée en 2020, notre mission est de fournir des contrôleurs de jeu de haute qualité qui répondent aux besoins des joueurs de tous niveaux.</p>
                    
                    <h2 class="text-3xl font-bold">Nos Produits</h2>
                    <p>Nous proposons une gamme de contrôleurs de jeu, y compris des modèles inspirés par les célèbres hitboxes. Nos produits sont conçus pour offrir précision, durabilité et confort, vous permettant de jouer à votre meilleur niveau.</p>
                    
                    <h2 class="text-3xl font-bold">Engagement envers la Qualité</h2>
                    <p>Chaque produit HitMaster Arcade est fabriqué avec les meilleurs matériaux et subit des tests rigoureux pour garantir une performance optimale. Nous nous engageons à fournir à nos clients des produits fiables et de haute qualité.</p>
                    
                    <h2 class="text-3xl font-bold">Service Client</h2>
                    <p>Notre équipe de support est toujours prête à vous aider. Que vous ayez des questions sur nos produits ou besoin d'assistance avec votre achat, nous sommes là pour vous.</p>
                    
                    <h2 class="text-3xl font-bold">Rejoignez notre Communauté</h2>
                    <p>Rejoignez la communauté HitMaster Arcade et connectez-vous avec d'autres joueurs passionnés. Suivez-nous sur les réseaux sociaux pour les dernières nouvelles, mises à jour et promotions.</p>
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
