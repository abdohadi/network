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
    public function a_post_requires_a_body()
    {
        $this->signIn();

        $this->post('/posts', factory(Post::class)->raw(['body' => '']))
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_user_can_view_the_home_page()
    {
        // User
        $this->signIn();
        
        $this->get('/')->assertStatus(200);
    }

    /** @test */
    public function a_user_can_update_their_posts()
    {
        $post = factory(Post::class)->create();

        $this->be($post->owner)
            ->patch($post->path(), $attributes = ['body' => 'updated body']);

        $this->assertDatabaseHas('posts', $attributes);
    }

    /** @test */
    public function a_user_can_delete_their_posts()
    {
        $post = factory(Post::class)->create();

        $this->be($post->owner)
            ->delete($post->path())
            ->assertRedirect('/');
    }

    /** @test */
    public function authenticated_users_cannot_manage_posts_of_others()
    {
        $this->signIn();

        $this->patch(factory(Post::class)->create()->path())->assertStatus(403);

        $this->delete(factory(Post::class)->create()->path())->assertStatus(403);
    }

    /** @test */
    public function a_user_can_view_posts()
    {
        $post = factory(Post::class)->create();

        $this->be($post->owner)
            ->get($post->path())
            ->assertSee($post->body);
    }

    /** @test */
    public function guests_cannot_manage_posts()
    {
        $path = factory(Post::class)->create()->path();

        $this->get('/posts')->assertRedirect('login');

        $this->get($path)->assertRedirect('login');

        $this->post('/posts')->assertRedirect('login');

        $this->patch($path)->assertRedirect('login');

        $this->delete($path)->assertRedirect('login');
    }
}
