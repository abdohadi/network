<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Group;

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
        $this->assertInstanceOf(User::class, factory(User::class)->create());
    }

    /** @test */
    public function it_can_have_groups()
    {
        $this->assertInstanceOf(Group::class, factory(Group::class)->create());
    }
}
