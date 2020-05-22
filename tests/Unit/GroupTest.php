<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Group;
use App\User;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        // $this->WithoutExceptionHandling();
        $group = factory(Group::class)->create();

        $this->assertEquals('/groups/'.$group->id, $group->path());
    }

    /** @test */
    public function it_has_an_owner()
    {
    	$this->assertInstanceOf('App\User', factory(Group::class)->create()->owner);
    }

    /** @test */
    public function it_can_have_admins()
    {
        $user = $this->signIn();

        $group = factory(Group::class)->create();
     
        $group->addMember($user);
        $group->assignAdmin($user);

        $this->assertCount(1, $group->admins);
    }

    /** @test */
    public function it_can_check_if_it_has_an_admin()
    {
        $user = $this->signIn();

        $group = factory(Group::class)->create();

        $group->addMember($user);
        $group->assignAdmin($user);

        $this->assertTrue($group->hasAdmin($user));
    }

    /** @test */
    public function the_owner_of_a_group_is_assigned_as_an_admin_when_creating_a_group()
    {
        $user = $this->signIn();

        $group = factory(Group::class)->raw();

        $this->post(localizeURL('/groups'), $group);

        $group = Group::first();
        $this->assertEquals($group->owner->id, $user->id);

        $this->assertCount(1, $group->admins);
    }

    /** @test */
    public function it_can_join_a_user_and_have_join_requests()
    {
        $user = $this->signIn();
        $group = factory(Group::class)->create();

        $group->join($user);

        $this->assertTrue($group->joinRequests->contains($user));
    }

    /** @test */
    public function it_can_make_a_regular_member_an_admin()
    {
        $group = factory(Group::class)->create();
        $user = factory(User::class)->create();

        $group->join($user);
        $group->acceptRequest($user);
        $group->assignAdmin($user);

        $this->assertCount(1, $group->admins);
    }

    /** @test */
    public function it_can_make_an_admin_a_regular_member()
    {
        $group = factory(Group::class)->create();
        $user = factory(User::class)->create();

        $group->join($user);
        $group->acceptRequest($user);
        $group->assignAdmin($user);
        $this->assertCount(1, $group->admins);

        $group = $group->fresh();
        $group->dismissAdmin($user);
        $this->assertCount(0, $group->admins);
    }

    /** @test */
    public function it_can_add_a_member()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $group->addMember($user);

        $this->assertCount(1, $group->acceptedMembers);
    }

    /** @test */
    public function it_can_remove_a_member()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $group->addMember($user);
        $this->assertCount(1, $group->acceptedMembers);

        $group = $group->fresh();
        $group->removeMember($user);
        $this->assertCount(0, $group->acceptedMembers);
    }

    /** @test */
    public function it_can_have_members()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $group->join($user);

        $this->assertTrue($group->members->contains($user));
    }

    /** @test */
    public function it_can_accept_a_join_request()
    {
        $user = $this->signIn();
        $group = factory(Group::class)->create();
        
        $group->join($user);
        $group->acceptRequest($user);

        $this->assertTrue($group->acceptedMembers->contains($user));
    }

    /** @test */
    public function it_can_check_if_it_has_a_member()
    {
        $user = $this->signIn();
        $group = factory(Group::class)->create();

        $group->join($user);
        $group->acceptRequest($user);

        $this->assertTrue($group->hasAcceptedMember($user));
    }

    /** @test */
    public function it_can_check_if_it_has_a_request()
    {
        $user = $this->signIn();
        $group = factory(Group::class)->create();

        $group->join($user);

        $this->assertTrue($group->hasRequest($user));
    }
}
