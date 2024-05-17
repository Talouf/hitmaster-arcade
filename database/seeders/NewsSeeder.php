<?php

// database/seeders/NewsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class NewsSeeder extends Seeder
{
    public function run()
    {
        DB::table('news')->insert([
            [
                'admin_id' => 1, 
                'title' => 'Tournoi de Street Fighter V',
                'content' => 'Le grand tournoi de Street Fighter V aura lieu ce week-end avec des joueurs de tout le pays.',
                'post_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'admin_id' => 1, 
                'title' => 'Nouvelle Mise à Jour pour Tekken 7',
                'content' => 'Tekken 7 reçoit une nouvelle mise à jour avec des améliorations de gameplay et de nouveaux personnages.',
                'post_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'admin_id' => 1, 
                'title' => 'Résultats du Tournoi Mortal Kombat 11',
                'content' => 'Découvrez les résultats du dernier tournoi de Mortal Kombat 11 qui s\'est déroulé la semaine dernière.',
                'post_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'admin_id' => 1, 
                'title' => 'Annonce du Nouveau Jeu de Combat',
                'content' => 'Un nouveau jeu de combat sera annoncé lors de l\'E3 cette année.',
                'post_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'admin_id' => 1, 
                'title' => 'Mise à Jour de la Communauté',
                'content' => 'La communauté des joueurs s\'agrandit avec de nouveaux membres chaque jour.',
                'post_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'admin_id' => 1, 
                'title' => 'Tournoi en Ligne de Super Smash Bros.',
                'content' => 'Participez au tournoi en ligne de Super Smash Bros. ce week-end.',
                'post_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'admin_id' => 1, 
                'title' => 'Guide des Nouveaux Joueurs',
                'content' => 'Découvrez notre guide complet pour les nouveaux joueurs afin de bien débuter.',
                'post_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
