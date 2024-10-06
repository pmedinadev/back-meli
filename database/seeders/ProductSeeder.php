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
            'price' => 199.99,
            'stock' => 50,
            'category_id' => 1,
            'user_id' => 1,
        ]);
        Product::create ([
            'title' => '4K Smart TV',
            'description' => '65-inch 4K UHD Smart TV with HDR and built-in streaming apps.',
            'price' => 899.99,
            'stock' => 20,
            'category_id' => 2,
            'user_id' => 2,
        ]);
        Product::create ([
            'title' => 'Running Shoes',
            'description' => 'Lightweight running shoes with breathable mesh and cushioned sole.',
            'price' => 129.99,
            'stock' => 75,
            'category_id' => 3,
            'user_id' => 1,
        ]);
        Product::create ([
            'title' => 'Gaming Laptop',
            'description' => 'High-performance gaming laptop with Intel i7 processor and RTX 3060.',
            'price' => 1499.99,
            'stock' => 15,
            'category_id' => 4,
            'user_id' => 3,
        ]);
        Product::create ([
            'title' => 'Coffee Maker',
            'description' => 'Automatic drip coffee maker with programmable timer and 12-cup capacity.',
            'price' => 89.99,
            'stock' => 30,
            'category_id' => 5,
            'user_id' => 4,
        ]);
        Product::create ([
            'title' => 'Smartphone',
            'description' => 'Latest model smartphone with 128GB storage and 5G connectivity.',
            'price' => 999.99,
            'stock' => 40,
            'category_id' => 6,
            'user_id' => 2,
        ]);
        Product::create ([
            'title' => 'Electric Guitar',
            'description' => 'Solid-body electric guitar with maple neck and dual humbuckers.',
            'price' => 699.99,
            'stock' => 25,
            'category_id' => 7,
            'user_id' => 3,
        ]);
        Product::create ([
            'title' => 'Mountain Bike',
            'description' => 'Full-suspension mountain bike with 21-speed gearing and disc brakes.',
            'price' => 599.99,
            'stock' => 10,
            'category_id' => 8,
            'user_id' => 5,
        ]);
        Product::create ([
            'title' => 'Electric Kettle',
            'description' => 'Stainless steel electric kettle with 1.7-liter capacity and auto shut-off.',
            'price' => 49.99,
            'stock' => 100,
            'category_id' => 9,
            'user_id' => 4,
        ]);
    }
}
