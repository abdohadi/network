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
             ->post(route('posts.store'), $post->toArray());

        $this->get(route('posts.show', $post))->assertSee($post['body']);
    }

    /** @test */
    public function a_post_requires_a_body()
    {
        $this->signIn();

        $this->post(route('posts.store'), factory(Post::class)->raw(['body' => '']))
             ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_user_can_update_their_posts()
    {
        $post = factory(Post::class)->create();

        $this->be($post->owner)
             ->patch(route('posts.update', $post), $attributes = ['body' => 'updated body']);

        $this->assertDatabaseHas('posts', $attributes);
    }

    /** @test */
    public function a_user_can_delete_their_posts()
    {
        $post = factory(Post::class)->create();

        $this->be($post->owner)
             ->delete(route('posts.destroy', $post))
             ->assertRedirect('/');
    }

    /** @test */
    public function authenticated_users_cannot_manage_posts_of_others()
    {
        $this->signIn();
        $post = factory(Post::class)->create();

        $this->patch(route('posts.update', $post))
             ->assertStatus(403);

        $this->delete(route('posts.destroy', $post))
             ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_view_a_post()
    {
        $post = factory(Post::class)->create();

        $this->be($post->owner)
             ->get(route('posts.show', $post))
             ->assertOk();
    }

    /** @test */
    public function a_guest_cannot_view_a_post()
    {
        $post = factory(Post::class)->create();

        $this->get(route('posts.show', $post))->assertRedirect(route('login'));
    }

    /** @test */
    public function a_guest_cannot_manage_posts()
    {
        $post = factory(Post::class)->create();

        $this->post(route('posts.store', $post))->assertRedirect(route('login'));

        $this->patch(route('posts.update', $post))->assertRedirect(route('login'));

        $this->delete(route('posts.destroy', $post))->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_share_a_post()
    {
        $this->signIn();

        $shared_post = factory(Post::class)->create();

        // share a post without adding a body
        $this->post(route('posts.share', $shared_post));
        
        $this->assertDatabaseHas('posts', ['user_id' => auth()->id(), 'shared_post_id' => $shared_post->id]);

        // share a post with adding a body
        $this->followingRedirects()
             ->post(route('posts.share', $shared_post), ['body' => 'post body'])
             ->assertSee('post body')
             ->assertSee($shared_post['body']);
        
        $this->assertDatabaseHas('posts', ['user_id' => auth()->id(), 'shared_post_id' => $shared_post->id]);
    }
}
