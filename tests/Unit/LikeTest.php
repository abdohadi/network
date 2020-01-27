<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Post;

class LikeTest extends TestCase
{
	// use RefreshDatabase;

	/** @test */
	public function belongs_to_a_user()
	{
		$this->assertInstanceOf(User::class, factory('App\Like')->create()->owner);
	}

	/** @test */
	public function belongs_to_a_post()
	{
		$this->assertInstanceOf(Post::class, factory('App\Like')->create()->post);
	}
}
