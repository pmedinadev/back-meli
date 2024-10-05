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
            'name' => 'Martín Aispuro',
            'email' => 'm.aispuro20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Cristopher Gómez',
            'email' => 'c.gomez20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Melissa González',
            'email' => 'my.gonzalez20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Ricardo Iriarte',
            'email' => 'jr.iriarte19@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Isaac López',
            'email' => 'ij.lopez20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Kevin Lugo',
            'email' => 'kj.lugo20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Pablo Medina',
            'email' => 'jp.medina20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'José Parra',
            'email' => 'ja.parra20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'David Sedano',
            'email' => 'ed.sedano20@info.uas.edu.mx',
            'password' => Hash::make('12345678'),
        ]);
    }
}
