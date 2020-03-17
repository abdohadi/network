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

        $this->actingAs($post->owner)
             ->post(localizeURL('/posts'), $post->toArray());

        $this->get(localizeURL($post->path()))->assertSee($post['body']);
    }

    /** @test */
    public function a_post_requires_a_body()
    {
        $this->signIn();

        $this->post(localizeURL('/posts'), factory(Post::class)->raw(['body' => '']))
             ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_user_can_update_their_posts()
    {
        $post = factory(Post::class)->create();

        $this->be($post->owner)
             ->patch(localizeURL($post->path()), $attributes = ['body' => 'updated body']);

        $this->assertDatabaseHas('posts', $attributes);
    }

    /** @test */
    public function a_user_can_delete_their_posts()
    {
        $post = factory(Post::class)->create();

        $this->be($post->owner)
             ->delete(localizeURL($post->path()))
             ->assertRedirect('/');
    }

    /** @test */
    public function authenticated_users_cannot_manage_posts_of_others()
    {
        $this->signIn();

        $this->patch(localizeURL(factory(Post::class)->create()->path()))
             ->assertStatus(403);

        $this->delete(localizeURL(factory(Post::class)->create()->path()))
             ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_view_a_post()
    {
        $post = factory(Post::class)->create();

        $this->be($post->owner)
             ->get(localizeURL($post->path()))
             ->assertOk();
    }

    /** @test */
    public function a_guest_cannot_view_a_post()
    {
        $post = factory(Post::class)->create();

        $this->get(localizeURL($post->path()))->assertRedirect(localizeURL('login'));
    }

    /** @test */
    public function a_guest_cannot_manage_posts()
    {
        $path = factory(Post::class)->create()->path();

        $this->post(localizeURL('/posts'))->assertRedirect(localizeURL('login'));

        $this->patch(localizeURL($path))->assertRedirect(localizeURL('login'));

        $this->delete(localizeURL($path))->assertRedirect(localizeURL('login'));
    }

    /** @test */
    public function a_user_can_share_a_post()
    {
        // $this->WithoutExceptionHandling();
        $this->signIn();

        $shared_post = factory(Post::class)->create();

        // share a post without adding a body
        $this->get(localizeURL($shared_post->path() . '/shared'));
        
        $this->assertDatabaseHas('posts', ['user_id' => auth()->id(), 'shared_post_id' => $shared_post->id]);

        // share a post with adding a body
        $this->followingRedirects()
             ->post(localizeURL($shared_post->path() . '/shared'), ['body' => 'post body'])
             ->assertSee('post body')
             ->assertSee($shared_post['body']);
        
        $this->assertDatabaseHas('posts', ['user_id' => auth()->id(), 'shared_post_id' => $shared_post->id]);
    }
}
