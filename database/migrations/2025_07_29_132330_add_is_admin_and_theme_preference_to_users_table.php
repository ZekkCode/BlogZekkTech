<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kolom is_admin dan theme_preference sudah ditambahkan dalam migrasi sebelumnya
        // 2025_07_29_120309_add_is_admin_to_users_table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu melakukan apa-apa
    }
};
