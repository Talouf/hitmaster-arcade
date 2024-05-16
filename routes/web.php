<?php

use Illuminate\Support\Facades\Route;

// Autres routes existantes...

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/products', function () {
    return view('products');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/product/{id}', function ($id) {
    $products = [
        1 => [
            'name' => 'HitMaster Alpha',
            'description' => 'Contrôleur de jeu précis et durable.',
            'details' => 'Conçu pour offrir une précision et une durabilité exceptionnelles.',
            'price' => 100,
            'image' => 'images/white_controller.webp'
        ],
        2 => [
            'name' => 'HitMaster Beta',
            'description' => 'Design ergonomique pour un confort maximal.',
            'details' => 'Le design ergonomique assure un confort maximal pendant les longues sessions de jeu.',
            'price' => 120,
            'image' => 'images/white_controller.webp'
        ],
        3 => [
            'name' => 'HitMaster Gamma',
            'description' => 'Haute performance et réactivité.',
            'details' => 'Haute performance et réactivité pour les joueurs professionnels.',
            'price' => 150,
            'image' => 'images/white_controller.webp'
        ],
        4 => [
            'name' => 'HitMaster Delta',
            'description' => 'Conçu pour les joueurs professionnels.',
            'details' => 'Conçu pour offrir une performance optimale aux joueurs professionnels.',
            'price' => 200,
            'image' => 'images/white_controller.webp'
        ],
        5 => [
            'name' => 'HitMaster Epsilon',
            'description' => 'Durabilité et confort exceptionnel.',
            'details' => 'Fabriqué avec des matériaux de haute qualité pour une durabilité et un confort exceptionnels.',
            'price' => 180,
            'image' => 'images/white_controller.webp'
        ],
        6 => [
            'name' => 'HitMaster Zeta',
            'description' => 'Idéal pour les tournois et les compétitions.',
            'details' => 'Idéal pour les tournois et les compétitions grâce à sa haute performance.',
            'price' => 220,
            'image' => 'images/white_controller.webp'
        ],
    ];

    if (!array_key_exists($id, $products)) {
        abort(404);
    }

    return view('product', ['product' => $products[$id]]);
});
