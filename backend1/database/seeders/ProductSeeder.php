<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $categories = DB::table('categories')->pluck('id')->toArray();
        $brands = DB::table('brands')->pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            $name = $faker->words(2, true); // Tạo tên sản phẩm ngẫu nhiên
            $slug = Str::slug($name) . '-' . Str::random(5); // Thêm 5 ký tự ngẫu nhiên vào slug

            DB::table('products')->insert([
                'name' => ucfirst($name),
                'slug' => $slug,
                'description' => $faker->sentence(10),
                'price' => $faker->randomFloat(2, 10, 500),
                'category_id' => $faker->randomElement($categories),
                'brand_id' => $faker->randomElement($brands),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}