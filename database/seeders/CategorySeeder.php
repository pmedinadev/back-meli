<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Agriculture',
        ]);

        Category::create([
            'name' => 'Antiques and Collections',
        ]);

        Category::create([
            'name' => 'Art, Stationery and Haberdashery',
        ]);
        
        Category::create([
            'name' => 'Babies',
        ]);

        Category::create([
            'name' => 'Beauty and Personal Care',
        ]);

        Category::create([
            'name' => 'Books, Magazines and Comics',
        ]);

        Category::create([
            'name' => 'Cameras and Accessories',
        ]);

        Category::create([
            'name' => 'Cars, Motorcycles and Others',
        ]);

        Category::create([
            'name' => 'Cellphones and Telephony',
        ]);

        Category::create([
            'name' => 'Clothing, Bags and Footwear',
        ]);

        Category::create([
            'name' => 'Computing',
        ]);

        Category::create([
            'name' => 'Consoles and Video Games',
        ]);

        Category::create([
            'name' => 'Construction',
        ]);

        Category::create([
            'name' => 'Electronics, Audio and Video',
        ]);

        Category::create([
            'name' => 'Food and Beverages',
        ]);

        Category::create([
            'name' => 'Games and Toys',
        ]);

        Category::create([
            'name' => 'Health and Medical Equipment',
        ]);

        Category::create([
            'name' => 'Home Appliances',
        ]);

        Category::create([
            'name' => 'Home, Furniture and Garden',
        ]);

        Category::create([
            'name' => 'Industries and Offices',
        ]);

        Category::create([
            'name' => 'Jewelry and Watches',
        ]);

        Category::create([
            'name' => 'Musical Instruments',
        ]);

        Category::create([
            'name' => 'Music, Movies and Series',
        ]);

        Category::create([
            'name' => 'Party Supplies and Favors',
        ]);

        Category::create([
            'name' => 'Pets and Animals',
        ]);

        Category::create([
            'name' => 'Real Estate',
        ]);

        Category::create([
            'name' => 'Services',
        ]);

        Category::create([
            'name' => 'Sports and Fitness',
        ]);

        Category::create([
            'name' => 'Tools',
        ]);

        Category::create([
            'name' => 'Vehicle Accessories',
        ]);

        Category::create([
            'name' => 'Other Categories',
        ]);
    }
}
