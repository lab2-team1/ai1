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
                'description' => 'Nowy, nieużywany laptop z gwarancją. Procesor i7, 16GB RAM, 512GB SSD.',
                'price' => 4999.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[1],
                'category_id' => $categoryIds[1],
                'title' => 'iPhone 12 Pro Max',
                'description' => 'Telefon w idealnym stanie, z oryginalnym opakowaniem. 256GB, kolor grafitowy.',
                'price' => 3499.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[2],
                'category_id' => $categoryIds[2],
                'title' => 'Samsung Galaxy S21',
                'description' => 'Smartfon z doskonałym aparatem i długą baterią. 128GB, Phantom Gray.',
                'price' => 2999.99,
                'status' => 'sold',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[0],
                'category_id' => $categoryIds[3],
                'title' => 'Sony Bravia 55" 4K TV',
                'description' => 'Telewizor LED 4K HDR, Android TV, 2 lata gwarancji.',
                'price' => 3499.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[1],
                'category_id' => $categoryIds[4],
                'title' => 'Nike Air Max 270',
                'description' => 'Buty sportowe w rozmiarze 42, nowe, nieużywane.',
                'price' => 499.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[2],
                'category_id' => $categoryIds[5],
                'title' => 'Adidas Ultraboost 21',
                'description' => 'Buty biegowe, rozmiar 43, kolor czarny.',
                'price' => 599.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[0],
                'category_id' => $categoryIds[6],
                'title' => 'Kijki do nordic walking',
                'description' => 'Profesjonalne kijki do nordic walking, regulowane.',
                'price' => 149.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[1],
                'category_id' => $categoryIds[7],
                'title' => 'Młotek Bosch GSH 11 E',
                'description' => 'Młotek udarowy 1500W, nowy, w oryginalnym opakowaniu.',
                'price' => 899.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[2],
                'category_id' => $categoryIds[8],
                'title' => 'Toyota Corolla 2019',
                'description' => 'Samochód w idealnym stanie, pierwszy właściciel, pełna historia serwisowa.',
                'price' => 65000.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[0],
                'category_id' => $categoryIds[9],
                'title' => 'Książka "Clean Code"',
                'description' => 'Nowa książka o programowaniu, autor Robert C. Martin.',
                'price' => 89.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[1],
                'category_id' => $categoryIds[0],
                'title' => 'MacBook Pro 14" M1 Pro',
                'description' => 'Laptop Apple z procesorem M1 Pro, 16GB RAM, 512GB SSD.',
                'price' => 8999.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[2],
                'category_id' => $categoryIds[1],
                'title' => 'Samsung Galaxy Watch 4',
                'description' => 'Smartwatch w kolorze czarnym, nowy, nieużywany.',
                'price' => 999.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[0],
                'category_id' => $categoryIds[2],
                'title' => 'Monitor Dell 27" 4K',
                'description' => 'Monitor 4K UHD, HDR, USB-C, nowy.',
                'price' => 2499.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[1],
                'category_id' => $categoryIds[3],
                'title' => 'Słuchawki Sony WH-1000XM4',
                'description' => 'Słuchawki bezprzewodowe z ANC, nowe, nieużywane.',
                'price' => 1299.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[2],
                'category_id' => $categoryIds[4],
                'title' => 'Kurtka zimowa The North Face',
                'description' => 'Kurtka puchowa, rozmiar M, kolor czarny.',
                'price' => 799.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
