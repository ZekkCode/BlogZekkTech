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
        Schema::table('posts', function (Blueprint $table) {
            // Hapus foreign key constraint jika ada
            if (Schema::hasColumn('posts', 'category_id')) {
                // Nama foreign key biasanya mengikuti konvensi Laravel
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Tambahkan kembali kolom
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
        });
    }
};
