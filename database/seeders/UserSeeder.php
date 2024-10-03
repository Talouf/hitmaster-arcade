<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nickname' => 'User1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'nickname' => 'User2',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'nickname' => 'User3',
            'email' => 'user3@example.com',
            'password' => Hash::make('password'),
        ]);
        User::factory()->count(100)->create([
            'nickname' => fn() => fake()->userName(),
            'name' => fn() => fake()->name(),
            'email' => fn() => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // mot de passe par défaut
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }


}
