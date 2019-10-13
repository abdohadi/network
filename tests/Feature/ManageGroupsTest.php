<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Group;

class ManageGroupsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_group()
    {
        // $this->WithoutExceptionHandling();
        $user = $this->signIn();

        $group = factory(Group::class)->create(['user_id' => $user->id]);

        $this->post('/groups', $group->toArray());

        $this->assertDatabaseHas('groups', $group->toArray());
    }

    /** @test */
    public function a_group_requires_a_name()
    {
        $group = factory(Group::class)->create(['name' => '']);

        $this->actingAs($group->owner)
            ->post('/groups', $group->toArray())
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_group_requires_a_description()
    {
        $group = factory(Group::class)->create(['description' => '']);

        $this->actingAs($group->owner)
            ->post('/groups', $group->toArray())
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_user_can_join_a_group()
    {
        $this->WithoutExceptionHandling();
        $user = $this->signIn();

        $group = factory(Group::class)->create();

        $this->get($group->path().'/join');

        $this->assertTrue($group->groupJoinRequests->contains($user));
    }
}
