<?php

namespace Database\Seeders;

use App\Models\Wishlist;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wishlist::create([
            'user_id' => 1,
        ]);
        Wishlist::create([
            'user_id' => 2,
        ]);
        Wishlist::create([
            'user_id' => 3,
        ]);
        Wishlist::create([
            'user_id' => 4,
        ]);
        Wishlist::create([
            'user_id' => 5,
        ]);
        Wishlist::create([
            'user_id' => 6,
        ]);
        Wishlist::create([
            'user_id' => 7,
        ]);
        Wishlist::create([
            'user_id' => 8,
        ]);
        Wishlist::create([
            'user_id' => 9
        ]);
    }
}
