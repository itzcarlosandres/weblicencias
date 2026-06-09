<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Microsoft', 'slug' => 'microsoft'],
            ['name' => 'Norton', 'slug' => 'norton'],
            ['name' => 'Kaspersky', 'slug' => 'kaspersky'],
            ['name' => 'Bitdefender', 'slug' => 'bitdefender'],
            ['name' => 'Steam', 'slug' => 'steam-brand'],
            ['name' => 'Xbox', 'slug' => 'xbox-brand'],
            ['name' => 'PlayStation', 'slug' => 'playstation-brand'],
            ['name' => 'Netflix', 'slug' => 'netflix'],
            ['name' => 'Spotify', 'slug' => 'spotify'],
            ['name' => 'Adobe', 'slug' => 'adobe'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
