<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            DB::table('discounts')->insert([
                'code' => strtoupper($faker->lexify('??????')),
                'discount_type' => $faker->randomElement(['fixed', 'percentage']),
                'value' => $faker->randomFloat(2, 5, 50),
                'start_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'end_date' => $faker->dateTimeBetween('now', '+1 month'),
                'max_uses' => $faker->numberBetween(10, 100),
                'created_at' => now(),
            ]);
        }
    }
}
