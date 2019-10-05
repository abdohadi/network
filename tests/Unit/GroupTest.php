<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Group;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_an_owner()
    {
    	$this->assertInstanceOf('App\User', factory(Group::class)->create()->owner);
    }

    /** @test */
    public function it_has_a_path()
    {
    	$group = factory(Group::class)->create();

    	$this->assertEquals('/groups/'.$group->id, $group->path());
    }

    /** @test */
    public function it_can_have_members()
    {
        $user = $this->signIn();

        $group = factory(Group::class)->create();

        $group->join($user);

        $this->assertCount(1, $group->members);
    }
}
