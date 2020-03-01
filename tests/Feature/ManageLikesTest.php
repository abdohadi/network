<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageLikesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_like_a_post()
    {
        $user = $this->signIn();
        $post = factory(Post::class)->create();

        // like post
        $this->get(localizeURL("/posts/{$post->id}/liked"));
            
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post)
        ]);
    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {
        $user = $this->signIn();
        $post = factory(Post::class)->create();

        // like post
        $this->get(localizeURL("/posts/{$post->id}/liked"));
        // unlike post
        $this->get(localizeURL("/posts/{$post->id}/liked"));

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post)
        ]);
    }

    /** @test */
    public function a_guest_cannot_like_or_unlike_a_post()
    {
        $post = factory(Post::class)->create();

        $this->get(localizeURL("/posts/{$post->id}/liked"))
            ->assertRedirect(localizeURL('login'));
    }
}
