<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            ImageSeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
            ProductVariantSeeder::class,
            UserSeeder::class,
            CartItemSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            PaymentSeeder::class,
            ReviewSeeder::class,
            DiscountSeeder::class,
        ]);
    }
}
