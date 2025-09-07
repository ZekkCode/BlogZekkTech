<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            AdminUserSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
        ];

        if (app()->environment('production')) {
            // In production, only run seeders when explicitly allowed
            if (!env('ALLOW_SEED', false)) {
                $this->command?->warn('Database seeding skipped in production');
                return;
            }
        }

        $this->call($seeders);
    }
}
