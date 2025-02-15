<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            DB::table('reviews')->insert([
                'user_id' => $faker->randomElement($userIds),
                'product_id' => $faker->randomElement($productIds),
                'rating' => $faker->numberBetween(1, 5),
                'comment' => $faker->sentence(10),
                'created_at' => now(),
            ]);
        }
    }
}
