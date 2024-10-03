<?php

namespace Database\Seeders;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run()
    {
        OrderItem::factory()->count(50)->create([
            'order_id' => fn() => random_int(1, 10), // ID de commande
            'product_id' => fn() => random_int(1, 10), // ID de produit
            'quantity' => fn() => fake()->numberBetween(1, 5),
            'price' => fn() => fake()->randomFloat(2, 20, 100), // Prix par produit
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
