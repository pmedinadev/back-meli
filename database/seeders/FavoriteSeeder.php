<?php

namespace Database\Seeders;

use App\Models\Favorite;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Favorite::create([
            'user_id' => 1,
        ]);
        Favorite::create([
            'user_id' => 2,
        ]);
        Favorite::create([
            'user_id' => 3,
        ]);
        Favorite::create([
            'user_id' => 4,
        ]);
        Favorite::create([
            'user_id' => 5,
        ]);
        Favorite::create([
            'user_id' => 6,
        ]);
        Favorite::create([
            'user_id' => 7,
        ]);
        Favorite::create([
            'user_id' => 8,
        ]);
        Favorite::create([
            'user_id' => 9
        ]);
    }
}
