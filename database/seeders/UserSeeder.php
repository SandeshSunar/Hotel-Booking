<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin account
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Hotel Admin',
                'password' => Hash::make('admin123'),
                'usertype' => 'admin',
            ]
        );

        // User 1
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
                'usertype' => 'user',
            ]
        );
    }
}
