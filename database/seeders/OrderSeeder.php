<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Générer 10 commandes factices
        Order::factory()->count(10)->create([
            'user_id' => fn() => random_int(1, 100), // ID utilisateur
            'status' => fn() => fake()->randomElement(['pending', 'completed', 'shipped']),
            'total_price' => fn() => fake()->randomFloat(2, 20, 500), // Prix aléatoire entre 20 et 500
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
