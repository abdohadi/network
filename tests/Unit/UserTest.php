<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
    	$user = factory(User::class)->create();

    	$this->assertEquals('/users/'.$user->id, $user->path());
    }

    /** @test */
    public function it_can_have_posts()
    {
    	$user = factory(User::class)->create();

    	$this->assertInstanceOf(User::class, $user);
    }
}
