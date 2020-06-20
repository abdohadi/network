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
        $this->get(route('posts.like', $post));
            
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
        $this->get(route('posts.like', $post));
        // unlike post
        $this->get(route('posts.like', $post));

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

        $this->get(route('posts.like', $post))
            ->assertRedirect(route('login'));
    }
}
