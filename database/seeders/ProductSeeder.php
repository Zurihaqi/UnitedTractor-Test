<?php

namespace Database\Seeders;

use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = CategoryProduct::all()->keyBy('name');

        $imagePath = "images/seeder/";

        $products = [
            [
                "name" => "Sumsang Galaxy",
                "price" => 5000000.00,
                "image" => "{$imagePath}smartphone.jpg",
                "category" => "Elektronik"
            ],
            [
                "name" => "Meja",
                "price" => 1500000.00,
                "image" => "{$imagePath}meja.png",
                "category" => "Perabot"
            ],
            [
                "name" => "Hairy Potter",
                "price" => 120000.00,
                "image" => "{$imagePath}buku.jpg",
                "category" => "Buku"
            ],
            [
                "name" => "Kaos",
                "price" => 50000.00,
                "image" => "{$imagePath}kaos.jpeg",
                "category" => "Pakaian"
            ],
            [
                "name" => "Action Figure",
                "price" => 800000.00,
                "image" => "{$imagePath}mainan.png",
                "category" => "Mainan"
            ],
            [
                "name" => "Raket Tenis",
                "price" => 500000.00,
                "image" => "{$imagePath}raket.png",
                "category" => "Olahraga"
            ],
        ];

        foreach ($products as $product) {
            $category = $categories->get($product['category']);

            if ($category) {
                Product::create([
                    "name" => $product["name"],
                    "price" => $product["price"],
                    "image" => $product["image"],
                    "product_category_id" => $category->id
                ]);
            } else {
                $this->command->error("Category not found: {$product['category']}");
            }
        }
    }
}
