<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncating the existing articles
        Product::truncate();

        $faker = \Faker\Factory::create();

        // creating 50 new articles
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'product_id' => $i+1000,
                'name' => $faker->name,
                'description' => $faker->paragraph,
                'brand' => $faker->name,
                'price' => $faker->numberBetween(50, 7000),
                'stock' => $faker->numberBetween(0, 175),
            ]);
        }
    }
}
