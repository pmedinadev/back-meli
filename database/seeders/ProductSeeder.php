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
        Product::create ([
            'title' => 'Wireless Headphones',
            'description' => 'Noise-cancelling over-ear headphones with 20 hours of battery life.',
            'condition' => 'new',
            'stock' => 50,
            'price' => 199.99,
            'warranty_type' => 'manufacturer',
            'warranty_duration' => 1,
            'warranty_duration_type' => 'years',
            'status' => 'published',
            'user_id' => 1,
            'category_id' => 1,
        ]);
        Product::create ([
            'title' => '4K Smart TV',
            'description' => '65-inch 4K UHD Smart TV with HDR and built-in streaming apps.',
            'condition' => 'new',
            'stock' => 20,
            'price' => 899.99,
            'warranty_type' => 'seller',
            'warranty_duration' => 2,
            'warranty_duration_type' => 'years',
            'status' => 'published',
            'user_id' => 2,
            'category_id' => 2,
        ]);
        Product::create ([
            'title' => 'Running Shoes',
            'description' => 'Lightweight running shoes with breathable mesh and cushioned sole.',
            'condition' => 'new',
            'stock' => 75,
            'price' => 129.99,
            'warranty_type' => 'seller',
            'warranty_duration' => 1,
            'warranty_duration_type' => 'years',
            'status' => 'published',
            'user_id' => 1,
            'category_id' => 3,
        ]);
        Product::create ([
            'title' => 'Gaming Laptop',
            'description' => 'High-performance gaming laptop with Intel i7 processor and RTX 3060.',
            'condition' => 'new',
            'stock' => 15,
            'price' => 1499.99,
            'warranty_type' => 'manufacturer',
            'warranty_duration' => 2,
            'warranty_duration_type' => 'years',
            'status' => 'published',
            'user_id' => 3,
            'category_id' => 4,
        ]);
        Product::create ([
            'title' => 'Coffee Maker',
            'description' => 'Automatic drip coffee maker with programmable timer and 12-cup capacity.',
            'condition' => 'new',
            'stock' => 30,
            'price' => 89.99,
            'warranty_type' => 'seller',
            'warranty_duration' => 1,
            'warranty_duration_type' => 'years',
            'status' => 'draft',
            'user_id' => 7,
            'category_id' => 5,
        ]);
        Product::create ([
            'title' => 'Smartphone',
            'description' => 'Latest model smartphone with 128GB storage and 5G connectivity.',
            'condition' => 'reaconditioned',
            'stock' => 40,
            'price' => 999.99,
            'warranty_type' => 'manufacturer',
            'warranty_duration' => 1,
            'warranty_duration_type' => 'years',
            'status' => 'published',
            'user_id' => 2,
            'category_id' => 6,
        ]);
        Product::create ([
            'title' => 'Electric Guitar',
            'description' => 'Solid-body electric guitar with maple neck and dual humbuckers.',
            'condition' => 'new',
            'stock' => 25,
            'price' => 699.99,
            'warranty_type' => 'seller',
            'warranty_duration' => 30,
            'warranty_duration_type' => 'days',
            'status' => 'published',
            'user_id' => 3,
            'category_id' => 7,
        ]);
        Product::create ([
            'title' => 'Mountain Bike',
            'description' => 'Full-suspension mountain bike with 21-speed gearing and disc brakes.',
            'condition' => 'used',
            'stock' => 10,
            'price' => 599.99,
            'warranty_type' => 'seller',
            'warranty_duration' => 3,
            'warranty_duration_type' => 'months',
            'status' => 'published',
            'user_id' => 5,
            'category_id' => 8,
        ]);
        Product::create ([
            'title' => 'Electric Kettle',
            'description' => 'Stainless steel electric kettle with 1.7-liter capacity and auto shut-off.',
            'condition' => 'new',
            'stock' => 100,
            'price' => 49.99,
            'warranty_type' => 'manufacturer',
            'warranty_duration' => 1,
            'warranty_duration_type' => 'years',
            'status' => 'published',
            'user_id' => 4,
            'category_id' => 9,
        ]);
    }
}
