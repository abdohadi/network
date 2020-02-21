<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Post;
use App\User;
use App\Like;
use App\Comment;

class PostTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function it_has_an_owner()
    {
    	$this->assertInstanceOf(User::class, factory(Post::class)->create()->owner);
    }

    /** @test */
    public function it_can_have_likes()
    {
        $post = factory(Post::class)->create();
        $like = factory(Like::class)->create(['post_id'=>$post->id]);

        $this->assertInstanceOf(Like::class, $post->likes->first());
    }

    /** @test */
    public function it_can_have_comments()
    {
        $post = factory(Post::class)->create();
        factory(Comment::class)->create(['post_id'=>$post->id]);

        $this->assertInstanceOf(Comment::class, $post->comments->first());
    }

    /** @test */
    public function it_has_a_path()
    {
        $post = factory(Post::class)->create();

    	$this->assertEquals('/posts/'.$post->id, $post->path());
    }
}
