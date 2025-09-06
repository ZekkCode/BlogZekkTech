<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str as SupportStr;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);
        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => SupportStr::slug($title) . '-' . $this->faker->unique()->randomNumber(5),
            'excerpt' => $this->faker->text(120),
            'body' => $this->faker->paragraphs(3, true),
            'published_at' => now(),
        ];
    }
}
