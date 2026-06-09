<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Software', 'slug' => 'software', 'icon' => '💻', 'order' => 1, 'description' => 'Licencias originales de software para PC y Mac'],
            ['name' => 'Windows', 'slug' => 'windows', 'icon' => '🪟', 'order' => 2, 'description' => 'Licencias de Windows 10, 11 y servidor'],
            ['name' => 'Office', 'slug' => 'office', 'icon' => '📊', 'order' => 3, 'description' => 'Microsoft Office y alternativas'],
            ['name' => 'Antivirus', 'slug' => 'antivirus', 'icon' => '🛡️', 'order' => 4, 'description' => 'Protección para tu equipo'],
            ['name' => 'Juegos', 'slug' => 'juegos', 'icon' => '🎮', 'order' => 5, 'description' => 'Claves de juego para todas las plataformas'],
            ['name' => 'Steam', 'slug' => 'steam', 'icon' => '🎮', 'order' => 6, 'description' => 'Juegos y tarjetas de regalo Steam'],
            ['name' => 'Xbox', 'slug' => 'xbox', 'icon' => '🟢', 'order' => 7, 'description' => 'Juegos y Game Pass para Xbox'],
            ['name' => 'PlayStation', 'slug' => 'playstation', 'icon' => '🔵', 'order' => 8, 'description' => 'Juegos y PS Plus para PlayStation'],
            ['name' => 'Gift Cards', 'slug' => 'gift-cards', 'icon' => '🎁', 'order' => 9, 'description' => 'Tarjetas de regalo para todas las plataformas'],
            ['name' => 'Streaming', 'slug' => 'streaming', 'icon' => '📺', 'order' => 10, 'description' => 'Cuentas y suscripciones de streaming'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
