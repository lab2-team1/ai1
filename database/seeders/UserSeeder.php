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
        User::truncate();
        User::insert([
            [
                'first_name' => 'Kazimierz',
                'last_name' => 'Świt',
                'email' => 'swit@email.com',
                'password' => Hash::make('1234'),
                'phone' => '123-456-789',
                'admin' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'email' => 'kowalski@email.com',
                'password' => Hash::make('1234'),
                'phone' => '111-222-333',
                'admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Anna',
                'last_name' => 'Nowak',
                'email' => 'nowak@email.com',
                'password' => Hash::make('1234'),
                'phone' => '444-555-666',
                'admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Piotr',
                'last_name' => 'Wiśniewski',
                'email' => 'wisniewski@email.com',
                'password' => Hash::make('1234'),
                'phone' => '777-888-999',
                'admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
