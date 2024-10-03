<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'user_id' => random_int(1, 100),  // Générer un ID utilisateur aléatoire
            'product_id' => random_int(1, 10),  // Générer un ID produit aléatoire
            'rating' => $this->faker->numberBetween(1, 5),  // Générer une note aléatoire entre 1 et 5
            'content' => $this->faker->realText(200),  // Générer un commentaire de 200 caractères
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
