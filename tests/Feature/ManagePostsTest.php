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
        $this->WithoutExceptionHandling();

        // Given I'm a user who is logged in
        $user = factory(User::class)->create();

        $post = factory(Post::class)->raw();

        $this->actingAs($user);

        $this->get('/posts/create')->assertStatus(200);

        // When they hit the end point /posts to create a new post, while passing the necessary data
        $this->post('/posts', $post);

        // Then there should be a new post in the database
        $this->assertDatabaseHas('posts', $post);
    }
}
