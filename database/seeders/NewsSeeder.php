<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Carbon;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $newsItems = [
            [
                'admin_id' => 1,
                'title_en' => 'Street Fighter VI Tournament',
                'title_fr' => 'Tournoi de Street Fighter VI',
                'content_en' => 'The big Street Fighter VI tournament will take place this weekend with players from all over the country. Prize pool of $10,000!',
                'content_fr' => 'Le grand tournoi de Street Fighter VI aura lieu ce week-end avec des joueurs de tout le pays. Cagnotte de 10 000 $ !',
                'post_date' => Carbon::now()->subDays(2),
            ],
            [
                'admin_id' => 1,
                'title_en' => 'New Tekken 8 Cabinets Arriving Next Month',
                'title_fr' => 'Nouvelles bornes Tekken 8 arrivant le mois prochain',
                'content_en' => 'We\'re excited to announce that brand new Tekken 8 arcade cabinets will be installed in our arcade next month. Be the first to experience the latest in the Tekken series!',
                'content_fr' => 'Nous sommes ravis d\'annoncer que de toutes nouvelles bornes d\'arcade Tekken 8 seront installées dans notre salle le mois prochain. Soyez les premiers à découvrir le dernier opus de la série Tekken !',
                'post_date' => Carbon::now()->subDays(5),
            ],
            [
                'admin_id' => 1,
                'title_en' => 'Retro Gaming Night: 80s Classics',
                'title_fr' => 'Soirée Rétro Gaming : Classiques des années 80',
                'content_en' => 'Join us for a nostalgic journey through the golden age of arcade gaming. We\'ll have Pac-Man, Space Invaders, Donkey Kong, and many more classics available all night!',
                'content_fr' => 'Rejoignez-nous pour un voyage nostalgique à travers l\'âge d\'or des jeux d\'arcade. Nous aurons Pac-Man, Space Invaders, Donkey Kong et bien d\'autres classiques disponibles toute la nuit !',
                'post_date' => Carbon::now()->subDays(7),
            ],
            [
                'admin_id' => 1,
                'title_en' => 'Monthly High Score Challenge: Mortal Kombat 11',
                'title_fr' => 'Défi mensuel du meilleur score : Mortal Kombat 11',
                'content_en' => 'This month\'s high score challenge features Mortal Kombat 11. Set the highest score by the end of the month to win exclusive MK merchandise!',
                'content_fr' => 'Le défi du meilleur score de ce mois met en vedette Mortal Kombat 11. Établissez le meilleur score d\'ici la fin du mois pour gagner des produits dérivés MK exclusifs !',
                'post_date' => Carbon::now()->subDays(10),
            ],
            [
                'admin_id' => 1,
                'title_en' => 'Kids\' Day: Introduction to Arcade Gaming',
                'title_fr' => 'Journée des enfants : Initiation aux jeux d\'arcade',
                'content_en' => 'Bring your kids for a fun-filled day of arcade gaming! We\'ll have special kid-friendly games and tutorials to introduce the next generation to the joy of arcades.',
                'content_fr' => 'Amenez vos enfants pour une journée remplie de jeux d\'arcade ! Nous aurons des jeux spéciaux adaptés aux enfants et des tutoriels pour initier la prochaine génération à la joie des salles d\'arcade.',
                'post_date' => Carbon::now()->subDays(12),
            ],
            [
                'admin_id' => 1,
                'title_en' => 'Maintenance Notice: Temporary Closure',
                'title_fr' => 'Avis de maintenance : Fermeture temporaire',
                'content_en' => 'We will be closed for maintenance and upgrades next Monday. We\'re installing new games and improving our facilities to enhance your gaming experience!',
                'content_fr' => 'Nous serons fermés pour maintenance et mises à niveau lundi prochain. Nous installons de nouveaux jeux et améliorons nos installations pour enrichir votre expérience de jeu !',
                'post_date' => Carbon::now()->subDays(15),
            ],
        ];

        foreach ($newsItems as $item) {
            News::create($item);
        }
    }
}