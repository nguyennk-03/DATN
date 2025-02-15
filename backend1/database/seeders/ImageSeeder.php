<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ImageSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $productIds = DB::table('products')->pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) { // Tạo 50 ảnh ngẫu nhiên
            DB::table('images')->insert([
                'product_id' => $faker->randomElement($productIds),
                'image_url' => $faker->imageUrl(640, 480, 'fashion'),
                'created_at' => now(),
            ]);
        }
    }
}
