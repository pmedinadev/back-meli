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
            'name' => 'Accesorios para Vehículos',
        ]);

        Category::create([
            'name' => 'Agro',
        ]);

        Category::create([
            'name' => 'Alimentos y Bebidas',
        ]);
        
        Category::create([
            'name' => 'Animales y Mascotas',
        ]);

        Category::create([
            'name' => 'Antigüedades y Colecciones',
        ]);

        Category::create([
            'name' => 'Arte, Papelería y Mercería',
        ]);

        Category::create([
            'name' => 'Autos, Motos y Otros',
        ]);

        Category::create([
            'name' => 'Bebés',
        ]);

        Category::create([
            'name' => 'Belleza y Cuidado Personal',
        ]);

        Category::create([
            'name' => 'Cámaras y Accesorios',
        ]);

        Category::create([
            'name' => 'Celulares y Telefonía',
        ]);

        Category::create([
            'name' => 'Computación',
        ]);

        Category::create([
            'name' => 'Consolas y Videojuegos',
        ]);

        Category::create([
            'name' => 'Construcción',
        ]);

        Category::create([
            'name' => 'Deportes y Fitness',
        ]);

        Category::create([
            'name' => 'Electrodomésticos',
        ]);

        Category::create([
            'name' => 'Electrónica, Audio y Video',
        ]);

        Category::create([
            'name' => 'Herramientas',
        ]);

        Category::create([
            'name' => 'Hogar, Muebles y Jardín',
        ]);

        Category::create([
            'name' => 'Industrias y Oficinas',
        ]);

        Category::create([
            'name' => 'Inmuebles',
        ]);

        Category::create([
            'name' => 'Instrumentos Musicales',
        ]);

        Category::create([
            'name' => 'Joyas y Relojes',
        ]);

        Category::create([
            'name' => 'Juegos y Juguetes',
        ]);

        Category::create([
            'name' => 'Libros, Revistas y Comics',
        ]);

        Category::create([
            'name' => 'Música, Películas y Series',
        ]);

        Category::create([
            'name' => 'Recuerdos, Cotillón y Fiestas',
        ]);

        Category::create([
            'name' => 'Ropa, Bolsas y Calzado',
        ]);

        Category::create([
            'name' => 'Salud y Equipamiento Médico',
        ]);

        Category::create([
            'name' => 'Servicios',
        ]);

        Category::create([
            'name' => 'Otras Categorías',
        ]);
    }
}
