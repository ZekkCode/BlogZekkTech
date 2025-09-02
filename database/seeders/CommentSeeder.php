<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();

        if ($users->count() === 0 || $posts->count() === 0) {
            $this->command->info('Tidak ada user atau post untuk dibuat komentar');
            return;
        }

        $sampleComments = [
            'Artikel yang sangat informatif! Terima kasih sudah berbagi.',
            'Saya setuju dengan poin-poin yang disampaikan di sini.',
            'Apakah ada rencana untuk menulis lanjutan dari topik ini?',
            'Sangat membantu, sudah saya praktekan dan berhasil.',
            'Konten berkualitas seperti ini yang kita butuhkan.',
            'Tutorial yang mudah diikuti, thanks!',
            'Bisa jelaskan lebih detail tentang bagian ini?',
            'Artikel terbaik yang pernah saya baca tentang topik ini.',
            'Sangat membantu untuk pemula seperti saya.',
            'Ditunggu artikel selanjutnya!'
        ];

        $replyComments = [
            'Terima kasih atas komentarnya!',
            'Senang artikel ini membantu Anda.',
            'Akan saya pertimbangkan untuk artikel selanjutnya.',
            'Silakan tanyakan jika ada yang kurang jelas.',
            'Sama-sama, semoga bermanfaat!',
            'Akan saya buatkan tutorial lanjutannya.',
            'Bagian mana yang perlu dijelaskan lebih detail?',
            'Terima kasih atas feedback positifnya.',
            'Semangat terus belajarnya!',
            'Stay tuned untuk update selanjutnya!'
        ];

        foreach ($posts as $post) {
            // Create 3-8 comments per post
            $commentCount = rand(3, 8);
            
            for ($i = 0; $i < $commentCount; $i++) {
                $comment = Comment::create([
                    'user_id' => $users->random()->id,
                    'post_id' => $post->id,
                    'content' => $sampleComments[array_rand($sampleComments)],
                    'likes' => rand(0, 25),
                    'dislikes' => rand(0, 5),
                    'is_approved' => true,
                ]);

                // 30% chance untuk membuat reply
                if (rand(1, 100) <= 30) {
                    Comment::create([
                        'user_id' => $users->random()->id,
                        'post_id' => $post->id,
                        'parent_id' => $comment->id,
                        'content' => $replyComments[array_rand($replyComments)],
                        'likes' => rand(0, 10),
                        'dislikes' => rand(0, 2),
                        'is_approved' => true,
                    ]);
                }
            }
        }

        $this->command->info('Sample comments berhasil dibuat!');
    }
}
