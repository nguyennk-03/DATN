<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderItemSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Lấy danh sách `order_id` và `product_id` từ database
        $orderIds = DB::table('orders')->pluck('id')->toArray();
        $productIds = DB::table('product_variants')->pluck('id')->toArray();

        // Tạo dữ liệu giả cho order_items
        for ($i = 1; $i <= 10; $i++) {
            DB::table('order_items')->insert([
                'order_id'   => $faker->randomElement($orderIds),
                'product_variant_id' => $faker->randomElement($productIds),
                'quantity'   => $faker->numberBetween(1, 10),
                'price'      => $faker->randomFloat(2, 10, 500), // Giá từ 10 - 500
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
