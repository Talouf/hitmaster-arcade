<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $reviews = [
            [
                'user_id' => 1,
                'product_id' => 1,
                'rating' => 4,
                'content' => 'Great product! Highly recommend it.',
            ],
            [
                'user_id' => 2,
                'product_id' => 2,
                'rating' => 5,
                'content' => 'Exceeded my expectations!',
            ],
            [
                'user_id' => 3,
                'product_id' => 3,
                'rating' => 3,
                'content' => 'Good product, but there is room for improvement.',
            ],
        ];
        Review::factory()->count(100)->create([
            'user_id' => fn() => random_int(1, 100), // Supposons que vous avez 100 utilisateurs
            'product_id' => fn() => random_int(1, 10), // Supposons que vous avez 10 produits
            'rating' => fn() => fake()->numberBetween(1, 5),
            'content' => fn() => fake()->realText(200), // Texte de 200 caractères
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
