<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Post;

class ManagePostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_post()
    {
        // $this->WithoutExceptionHandling();
        $post = factory(Post::class)->create();

        $this->followingRedirects()
            ->actingAs($post->owner)
            ->post('/posts', $post->toArray())
            ->assertSee($post['body']);
    }

    /** @test */
    public function a_guest_cannot_create_a_post()
    {
        $this->post('/posts')->assertRedirect('login');
    }

    /** @test */
    public function a_post_requires_a_body()
    {
        $this->signIn();

        $this->post('/posts', factory(Post::class)->raw(['body' => '']))
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function anyone_can_view_all_posts()
    {
        // Guest
        $this->get('/')->assertStatus(200);

        // User
        $this->signIn();
        
        $this->get('/')->assertStatus(200);
    }

    /** @test */
    public function a_user_can_update_their_posts()
    {
        $this->WithoutExceptionHandling();

        $post = factory(Post::class)->create();

        $this->be($post->owner)
            ->patch($post->path(), $attributes = ['body' => 'updated body']);

        $this->assertDatabaseHas('posts', $attributes);
    }
}
