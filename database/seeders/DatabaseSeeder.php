<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Default Admin
        User::updateOrCreate(
            ['phone' => '081111111111'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );
    }
}
