<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - HitMaster Arcade</title>
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
                <h1 class="text-4xl font-bold">Nous contacter</h1>
                <p class="text-gray-400 mt-4">Nous sommes là pour répondre à toutes vos questions.</p>
                <form class="mt-8 max-w-lg mx-auto">
                    <div class="mb-4">
                        <label for="name" class="block text-left">Nom:</label>
                        <input type="text" id="name" class="w-full bg-gray-700 border border-gray-600 rounded py-2 px-4">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-left">Email:</label>
                        <input type="email" id="email" class="w-full bg-gray-700 border border-gray-600 rounded py-2 px-4">
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-left">Message:</label>
                        <textarea id="message" rows="5" class="w-full bg-gray-700 border border-gray-600 rounded py-2 px-4"></textarea>
                    </div>
                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded">Envoyer</button>
                </form>
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
