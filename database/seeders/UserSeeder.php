<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'martin_aispuro',
            'email' => 'm.aispuro20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'cristopher_gomez',
            'email' => 'c.gomez20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'melissa_gonzalez',
            'email' => 'my.gonzalez20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'ricardo_iriarte',
            'email' => 'jr.iriarte19@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'isaac_lopez',
            'email' => 'ij.lopez20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'kevin_lugo',
            'email' => 'kj.lugo20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'pablo_medina',
            'email' => 'jp.medina20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'jose_parra',
            'email' => 'ja.parra20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'username' => 'david_sedano',
            'email' => 'ed.sedano20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);
    }
}
