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
            'name' => 'ZakariaMP',
            'email' => 'admin@blogzekktech.com',
            'avatar' => 'https://media.licdn.com/dms/image/v2/D5603AQF90iK4P4muvA/profile-displayphoto-shrink_200_200/B56ZRC4gmAGoAg-/0/1736288898198?e=2147483647&v=beta&t=Y6_QrNwc1Oma9Df_Wp-6R9nAleVKTSMDuK5ClCJTLvc',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'theme_preference' => 'light',
        ]);
    }
}
