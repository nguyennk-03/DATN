<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CartItemSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();

        for ($i = 1; $i <= 30; $i++) {
            DB::table('cart_items')->insert([
                'user_id' => $faker->randomElement($userIds),
                'product_id' => $faker->randomElement($productIds),
                'quantity' => $faker->numberBetween(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
