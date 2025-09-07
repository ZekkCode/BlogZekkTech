<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Safety: skip in production unless explicitly allowed
        if (app()->environment('production') && !env('ALLOW_ADMIN_SEED', false)) {
            $this->command?->warn('AdminUserSeeder skipped in production');
            return;
        }

        User::create([
            'name' => 'Zekk',
            'email' => 'zakariamujur6@gmail.com',
            'password' => Hash::make('zekktech2024'),
            'is_admin' => true,
            'theme_preference' => 'light',
        ]);

        // Admin tambahan untuk testing
        User::create([
            'name' => 'Admin Test',
            'email' => 'admin@blogzekktech.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'theme_preference' => 'light',
    ]);

    // User biasa sebagai contoh
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@zekktech.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'theme_preference' => 'dark',
        ]);
    }
}
