<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 10; $i++) {
            DB::table('payments')->insert([
                'order_id' => rand(1, 10),
                'user_id' => rand(1, 10),
                'payment_method' => $faker->randomElement(['momo', 'vnpay', 'paypal', 'cod']),
                'amount' => $faker->randomFloat(2, 100, 5000),
                'status' => $faker->randomElement(['pending', 'completed', 'failed']),
                'created_at' => now()
            ]);
        }
    }
}
