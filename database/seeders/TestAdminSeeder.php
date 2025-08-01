<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus user admin test jika sudah ada
        User::where('email', 'admin@blogzekktech.com')->delete();

        // Buat admin baru untuk testing
        User::create([
            'name' => 'Admin Test',
            'email' => 'admin@blogzekktech.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'theme_preference' => 'light',
        ]);
    }
}
