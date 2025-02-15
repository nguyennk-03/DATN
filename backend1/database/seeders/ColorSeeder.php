<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    public function run()
    {
        $colors = ['Red', 'Blue', 'Black', 'White', 'Green', 'Yellow', 'Pink', 'Purple', 'Grey'];

        foreach ($colors as $color) {
            DB::table('colors')->insert([
                'color_name' => $color
            ]);
        }
    }
}
