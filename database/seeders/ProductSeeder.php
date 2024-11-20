<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            1 => [ // ID de la categoría
                'titles' => [
                    // Títulos
                ],
                'descriptions' => [
                    // Descripciones
                ],
            ],
            2 => [ // ID de la categoría
                'titles' => [
                    // Títulos
                ],
                'descriptions' => [
                    // Descripciones
                ],
            ],
        ];

        foreach ($categories as $categoryId => $data) {
            for ($i = 0; $i < 30; $i++) { // 30 productos por categoría
                Product::create([
                    'title' => $data['titles'][array_rand($data['titles'])],
                    'description' => $data['descriptions'][array_rand($data['descriptions'])],
                    'condition' => ['new', 'used', 'reaconditioned'][array_rand(['new', 'used', 'reaconditioned'])],
                    'stock' => rand(10, 200),
                    'price' => rand(100, 5000),
                    'publication_type' => ['free', 'classic', 'premium'][array_rand(['free', 'classic', 'premium'])],
                    'warranty_type' => ['manufacturer', 'seller'][array_rand(['manufacturer', 'seller'])],
                    'warranty_duration' => rand(1, 24),
                    'warranty_duration_type' => ['days', 'months', 'years'][array_rand(['days', 'months', 'years'])],
                    'status' => ['draft', 'published'][array_rand(['draft', 'published'])],
                    'user_id' => rand(1, 9),
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}
