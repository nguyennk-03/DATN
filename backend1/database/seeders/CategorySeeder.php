<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        for ($i = 1; $i <= 5; $i++) {
            DB::table('categories')->insert([
                'name' => $faker->word,
                'slug' => Str::slug($faker->word),
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
