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
                'status' => $faker->randomElement(['Chờ xử lý', 'Đang xử lý', 'Đã giao', 'Hoàn tất', 'Đã hủy']),
                'total_price' => $faker->randomFloat(2, 100, 1000),
                'payment_status' => $faker->randomElement(['Chờ thanh toán', 'Đã thanh toán', 'Thất bại']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);            
        }
    }
}