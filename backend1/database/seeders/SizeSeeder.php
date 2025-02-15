<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    public function run()
    {
        $sizes = ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];

        foreach ($sizes as $size) {
            DB::table('sizes')->insert([
                'size' => $size
            ]);
        }
    }
}
