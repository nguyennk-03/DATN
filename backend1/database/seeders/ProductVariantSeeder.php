<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductVariantSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Lấy danh sách ID của các sản phẩm, sizes và colors
        $productIds = DB::table('products')->pluck('id')->toArray();
        $sizeIds = DB::table('sizes')->pluck('id')->toArray();
        $colorIds = DB::table('colors')->pluck('id')->toArray();

        for ($i = 1; $i <= 30; $i++) { // Tạo 30 biến thể sản phẩm
            DB::table('product_variants')->insert([
                'product_id' => $faker->randomElement($productIds),
                'size_id' => $faker->randomElement($sizeIds),
                'color_id' => $faker->randomElement($colorIds),
                'stock' => $faker->numberBetween(0, 100), // Số lượng tồn kho từ 0 đến 100
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
