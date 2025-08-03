<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class UpdatePostExcerptSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::whereNull('excerpt')->orWhere('excerpt', '')->get();

        foreach ($posts as $post) {
            // Generate excerpt from body content
            $excerpt = $this->generateExcerpt($post->title, $post->body);
            $post->update(['excerpt' => $excerpt]);
        }

        $this->command->info('Updated ' . $posts->count() . ' posts with excerpts.');
    }

    private function generateExcerpt(string $title, string $body): string
    {
        $excerpts = [
            'Markdown Extended Features' => 'Read more about Markdown features in Fuwari',
            'Expressive Code Example' => 'How code blocks look in Markdown using Expressive Code.',
            'Getting Started with Laravel' => 'Learn the fundamentals of Laravel framework and start building amazing web applications.',
            'Modern JavaScript Tips' => 'Discover powerful JavaScript techniques that will improve your development workflow.',
            'Database Design Best Practices' => 'Essential guidelines for creating efficient and scalable database schemas.',
            'API Development with Laravel' => 'Build robust RESTful APIs using Laravel\'s powerful features and tools.',
            'Frontend Development Trends' => 'Explore the latest trends and technologies shaping modern frontend development.',
        ];

        // Try to find a matching excerpt based on title
        foreach ($excerpts as $titlePattern => $excerpt) {
            if (stripos($title, $titlePattern) !== false || stripos($titlePattern, $title) !== false) {
                return $excerpt;
            }
        }

        // Fallback: generate from body content
        $cleanBody = strip_tags($body);
        $sentences = preg_split('/[.!?]+/', $cleanBody, -1, PREG_SPLIT_NO_EMPTY);

        if (count($sentences) > 0) {
            $firstSentence = trim($sentences[0]);
            return strlen($firstSentence) > 100 ?
                substr($firstSentence, 0, 97) . '...' :
                $firstSentence . '.';
        }

        return 'Discover insights and knowledge in this comprehensive article.';
    }
}
