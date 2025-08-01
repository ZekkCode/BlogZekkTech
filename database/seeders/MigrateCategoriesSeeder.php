<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateCategoriesSeeder extends Seeder
{
    /**
     * Memindahkan data category_id yang lama ke tabel pivot category_post.
     *
     * @return void
     */
    public function run()
    {
        // Ambil semua post yang memiliki category_id
        $posts = Post::whereNotNull('category_id')->get();

        foreach ($posts as $post) {
            // Pastikan category_id valid
            if ($post->category_id) {
                // Tambahkan ke tabel pivot jika belum ada
                if (!$post->categories->contains($post->category_id)) {
                    DB::table('category_post')->insert([
                        'category_id' => $post->category_id,
                        'post_id' => $post->id,
                    ]);
                }
            }
        }

        $this->command->info('Migrasi kategori dari category_id ke category_post berhasil!');
    }
}
