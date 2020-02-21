<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function it_has_an_owner() {
	  	$this->assertInstanceOf('App\User', factory('App\Comment')->create()->owner);
	}

	/** @test */
	public function it_has_a_post() {
	  	$this->assertInstanceOf('App\Post', factory('App\Comment')->create()->post);
	}

	/** @test */
	public function it_has_a_path() {
		$comment = factory('App\Comment')->create();

	  	$this->assertEquals("{$comment->post->path()}/comments/{$comment->id}", $comment->path());
	}
}
