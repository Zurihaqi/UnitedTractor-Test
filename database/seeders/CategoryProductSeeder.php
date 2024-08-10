<?php

namespace Database\Seeders;

use App\Models\CategoryProduct;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productCategories = [
            [
                "name" => "Elektronik"
            ],
            [
                "name" => "Perabot"
            ],
            [
                "name" => "Buku"
            ],
            [
                "name" => "Pakaian"
            ],
            [
                "name" => "Mainan"
            ],
            [
                "name" => "Olahraga"
            ],
        ];

        foreach ($productCategories as $category) {
            CategoryProduct::firstOrCreate([
                "name" => $category["name"]
            ]);
        }
    }
}
