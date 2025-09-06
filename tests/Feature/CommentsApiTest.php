<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_comments_publicly(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $resp = $this->getJson(route('comments.index', $post));
        $resp->assertStatus(200)->assertJson(['success' => true]);
    }
}
