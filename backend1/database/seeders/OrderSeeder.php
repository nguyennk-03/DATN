<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray(); 

        for ($i = 1; $i <= 10; $i++) {
            DB::table('orders')->insert([
                'user_id' => $faker->randomElement($userIds),
                'status' => $faker->randomElement(['pending', 'processing', 'shipped', 'completed', 'canceled']),
                'total_price' => $faker->randomFloat(2, 100, 1000),
                'payment_status' => $faker->randomElement(['pending', 'paid', 'failed']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);            
        }
    }
}