# Cloner le dépôt
git clone https://github.com/nom-utilisateur/nom-depot.git

# Accéder au répertoire du projet
cd nom-depot

# Installer les dépendances PHP
composer install

# Copier le fichier .env.example
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Configurer le fichier .env (modifier les paramètres de base de données, etc.)

# Migrer la base de données et exécuter les seeders
php artisan migrate --seed

# Installer les dépendances JavaScript
npm install

# Compiler les assets
npm run dev

# Lancer le serveur de développement
php artisan serve