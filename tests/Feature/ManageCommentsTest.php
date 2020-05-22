<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Image;

class ManageCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_comment() {
        // $this->WithoutExceptionHandling();
        $this->signIn();

        $comment = factory('App\Comment')->make();

        $this->post(localizeURL("posts/{$comment->post_id}/comments"), $comment->toArray());

        $this->assertDatabaseHas('comments', ['body' => $comment->body]);
    }

    /** @test */
    public function a_user_can_update_their_comments() {
        $comment = factory('App\Comment')->create();

        $this->actingAs($comment->owner)
             ->patch(localizeURL($comment->path()), $attributes = ['body' => 'new comment']);
        
        $this->assertDatabaseHas('comments', $attributes);
    }

    /** @test */
    public function an_authorized_user_cannot_update_other_users_comments() 
    {
        $this->signIn();

        $comment = factory('App\Comment')->create();

        $this->patch(localizeURL($comment->path()), $attributes = ['body' => 'new comment'])
             ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_delete_their_comments() 
    {
        $comment = factory('App\Comment')->create();
        
        $this->actingAs($comment->owner)
            ->get(localizeURL($comment->path()));
        
        $this->assertDatabaseMissing('comments', ['id' => $comment->id, 'body' => $comment->body]);
    }

    /** @test */
    public function an_authorized_user_cannot_delete_other_users_comments() {
        $this->signIn();

        $comment = factory('App\Comment')->create();

        $this->get(localizeURL($comment->path()), $attributes = ['body' => 'new comment'])
             ->assertStatus(403);
    }

    /** @test */
    public function comments_validation() {
        $comment = factory('App\Comment')->create(['body' => '']);
        
        $this->actingAs($comment->owner)
             ->post(localizeURL("{$comment->post->path()}/comments"), $comment->toArray())
            ->assertSessionHasErrors('body');
    }
}
