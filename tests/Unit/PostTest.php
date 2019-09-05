<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Post;
use App\User;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_an_owner()
    {
    	$post = factory(Post::class)->create();

    	$this->assertInstanceOf(User::class, $post->owner);
    }

    /** @test */
    public function it_has_a_path()
    {
    	$post = factory(Post::class)->create();

    	$this->assertEquals('posts/'.$post->id, $post->path());
    }
}
