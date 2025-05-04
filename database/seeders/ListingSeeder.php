<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pobierz wszystkie ID użytkowników i kategorii
        $userIds = User::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();

        Listing::truncate();
        Listing::insert([
            [
                'user_id' => $userIds[0],
                'category_id' => $categoryIds[0],
                'title' => 'Laptop Dell XPS 13',
                'description' => 'Nowy, nieużywany laptop z gwarancją.',
                'price' => 4999.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[1],
                'category_id' => $categoryIds[1],
                'title' => 'iPhone 12 Pro Max',
                'description' => 'Telefon w idealnym stanie, z oryginalnym opakowaniem.',
                'price' => 3499.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[2],
                'category_id' => $categoryIds[2],
                'title' => 'Samsung Galaxy S21',
                'description' => 'Smartfon z doskonałym aparatem i długą baterią.',
                'price' => 2999.99,
                'status' => 'sold',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[3],
                'category_id' => $categoryIds[3],
                'title' => 'Sony WH-1000XM4',
                'description' => 'Słuchawki bezprzewodowe z aktywnym tłumieniem hałasu.',
                'price' => 1299.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[0],
                'category_id' => $categoryIds[4],
                'title' => 'MacBook Pro M1',
                'description' => 'Laptop Apple z procesorem M1, 16GB RAM.',
                'price' => 7999.99,
                'status' => 'expired',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[1],
                'category_id' => $categoryIds[5],
                'title' => 'Nike Air Max 270',
                'description' => 'Buty sportowe w rozmiarze 42, nowe.',
                'price' => 599.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[2],
                'category_id' => $categoryIds[6],
                'title' => 'Adidas Ultraboost',
                'description' => 'Buty do biegania, używane kilka razy.',
                'price' => 499.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[3],
                'category_id' => $categoryIds[7],
                'title' => 'Canon EOS R5',
                'description' => 'Aparat fotograficzny z obiektywem 24-70mm.',
                'price' => 12999.99,
                'status' => 'sold',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[0],
                'category_id' => $categoryIds[8],
                'title' => 'Sony A7III',
                'description' => 'Lustrzanka cyfrowa z pełną klatką.',
                'price' => 8999.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[1],
                'category_id' => $categoryIds[9],
                'title' => 'Bose QuietComfort 35 II',
                'description' => 'Słuchawki nauszne z doskonałym dźwiękiem.',
                'price' => 1199.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
