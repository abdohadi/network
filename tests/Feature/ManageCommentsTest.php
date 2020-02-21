<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Image;

class ManageCommentsTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_comment() {
        // $this->WithoutExceptionHandling();
        // create a user and sign them it
        $this->signIn();

        // create a comment
        $comment = factory('App\Comment')->create();

        // send post request
        $this->post("{$comment->post->path()}/comments", $comment->toArray());

        // assert database has comment
        $this->assertDatabaseHas('comments', ['body' => $comment->body]);
    }

    /** @test */
    public function a_user_can_update_their_comments() {
        // create a comment
        $comment = factory('App\Comment')->create();

        // assert that a user can update a comment
        $this->actingAs($comment->owner)
            ->patch($comment->path(), $attributes = ['body' => 'new comment']);
        
        $this->assertDatabaseHas('comments', $attributes);
    }

    /** @test */
    public function an_authorized_user_cannot_update_other_users_comments() {
        $this->signIn();

        // create a comment
        $comment = factory('App\Comment')->create();

        // assert that a user cannot update a comment
        $this->patch($comment->path(), $attributes = ['body' => 'new comment'])
             ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_delete_their_comments() {
        // create a comment
        $comment = factory('App\Comment')->create();
        
        // assert that a user can delete a comment
        $this->actingAs($comment->owner)
            ->get($comment->path());
        
        $this->assertDatabaseMissing('comments', ['id' => $comment->id, 'body' => $comment->body]);
    }

    /** @test */
    public function an_authorized_user_cannot_delete_other_users_comments() {
        $this->signIn();

        // create a comment
        $comment = factory('App\Comment')->create();

        // assert that a user cannot update a comment
        $this->get($comment->path(), $attributes = ['body' => 'new comment'])
             ->assertStatus(403);
    }

    /** @test */
    public function comments_validation() {
        // create a comment
        $comment = factory('App\Comment')->create(['body' => '']);
        
        // assert that a comment requires a body and has a valid image
        $this->actingAs($comment->owner)->post("{$comment->post->path()}/comments", $comment->toArray())
            ->assertSessionHasErrors('body');
    }
}
