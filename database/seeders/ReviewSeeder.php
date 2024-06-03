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

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
