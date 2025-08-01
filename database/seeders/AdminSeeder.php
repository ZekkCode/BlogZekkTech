<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@blogzekktech.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'theme_preference' => 'dark',
        ]);
    }
}
