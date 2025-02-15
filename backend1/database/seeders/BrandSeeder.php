<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        for ($i = 1; $i <= 5; $i++) {
            DB::table('brands')->insert([
                'name' => $faker->company,
                'slug' => Str::slug($faker->company),
                'logo' => $faker->imageUrl(100, 100, 'fashion'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
