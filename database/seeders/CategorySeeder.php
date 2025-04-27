<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Wyczyść tabelę przed dodaniem nowych danych
        DB::table('categories')->truncate();

        // Dodaj przykładowe kategorie
        $categories = [
            'Elektronika',
            'Telefony i Akcesoria',
            'Komputery i Laptopy',
            'Sprzęt RTV',
            'Moda',
            'Obuwie',
            'Sport i Rekreacja',
            'Dom i Ogród',
            'Motoryzacja',
            'Książki i Muzyka'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
    }
}
