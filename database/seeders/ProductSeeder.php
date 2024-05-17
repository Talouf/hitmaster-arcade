<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'HitMaster Alpha',
                'description' => 'Contrôleur de jeu précis et durable.',
                'details' => 'Conçu pour offrir une précision et une durabilité exceptionnelles.',
                'price' => 100,
                'image' => 'images/white_controller.webp'
            ],
            [
                'name' => 'HitMaster Beta',
                'description' => 'Design ergonomique pour un confort maximal.',
                'details' => 'Le design ergonomique assure un confort maximal pendant les longues sessions de jeu.',
                'price' => 120,
                'image' => 'images/white_controller.webp'
            ],
            [
                'name' => 'HitMaster Gamma',
                'description' => 'Haute performance et réactivité.',
                'details' => 'Haute performance et réactivité pour les joueurs professionnels.',
                'price' => 150,
                'image' => 'images/white_controller.webp'
            ],
            [
                'name' => 'HitMaster Delta',
                'description' => 'Conçu pour les joueurs professionnels.',
                'details' => 'Conçu pour offrir une performance optimale aux joueurs professionnels.',
                'price' => 200,
                'image' => 'images/white_controller.webp'
            ],
            [
                'name' => 'HitMaster Epsilon',
                'description' => 'Durabilité et confort exceptionnel.',
                'details' => 'Fabriqué avec des matériaux de haute qualité pour une durabilité et un confort exceptionnels.',
                'price' => 180,
                'image' => 'images/white_controller.webp'
            ],
            [
                'name' => 'HitMaster Zeta',
                'description' => 'Idéal pour les tournois et les compétitions.',
                'details' => 'Idéal pour les tournois et les compétitions grâce à sa haute performance.',
                'price' => 220,
                'image' => 'images/white_controller.webp'
            ],
            [
                'name' => 'HitMaster Eta',
                'description' => 'Contrôleur compact et portable.',
                'details' => 'Facile à transporter et idéal pour les sessions de jeu en déplacement.',
                'price' => 90,
                'image' => 'images/white_controller.webp'
            ],
            [
                'name' => 'HitMaster Theta',
                'description' => 'Personnalisation avancée.',
                'details' => 'Permet une personnalisation avancée des commandes et des configurations.',
                'price' => 130,
                'image' => 'images/white_controller.webp'
            ],
            [
                'name' => 'HitMaster Iota',
                'description' => 'Compatibilité multi-plateformes.',
                'details' => 'Compatible avec plusieurs plateformes de jeu pour une flexibilité maximale.',
                'price' => 160,
                'image' => 'images/white_controller.webp'
            ],
            [
                'name' => 'HitMaster Kappa',
                'description' => 'Résistance améliorée.',
                'details' => 'Conçu pour résister à une utilisation intensive et prolongée.',
                'price' => 140,
                'image' => 'images/white_controller.webp'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}




