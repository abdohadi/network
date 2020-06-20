<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use App\Group;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageGroupsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_group_requires_a_name()
    {
        // $this->WithoutExceptionHandling();
        $this->signIn();
        $group = factory(Group::class)->raw(['name' => '']);

        $this->post(route('groups.store'), $group)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_group_requires_a_description()
    {
        $group = factory(Group::class)->create(['description' => '']);

        $this->actingAs($group->owner)
            ->post(route('groups.store'), $group->toArray())
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_user_can_create_a_group()
    {
        $user = $this->signIn();
        $group = factory(Group::class)->raw(['user_id' => $user->id]);

        $this->post(route('groups.store'), $group)
            ->assertRedirect(Group::first()->path());

        $this->assertDatabaseHas('groups', $group);

        $this->assertTrue(Group::first()->hasAdmin($user));
    }

    /** @test */
    public function a_user_can_view_their_groups_and_the_groups_of_other_users()
    {
        // an authenticated user views their groups page
        // they can see their own groups, 
        // the groups that they are members of and the groups they sent a join request to
        $user = $this->createGroupAndOwner();
        $ownedGroup = Group::where('user_id', $user->id)->first();

        $requestedGroup = factory(Group::class)->create();
        $this->makeJoinRequestToGroup($requestedGroup, $user);

        $admin = $this->createGroupAndOwner();
        $joinedGroup = Group::where('user_id', $admin->id)->first();
        $this->makeAndAcceptJoinRequestToGroup($joinedGroup, $admin, $user);

        $this->be($user)->get(route('users.groups.index', $user))
            ->assertOk()
            ->assertSee($ownedGroup->name)
            ->assertSee($joinedGroup->name)
            ->assertSee($requestedGroup->name);

        // an authenticated user views a groups page of another user
        // the authenticated user can see the groups created by that user, 
        // the groups that user is a member of and the shared groups they both are members of
        $user2 = $this->createGroupAndOwner();
        $ownedGroup = Group::where('user_id', $user2->id)->first();
        $joinedGroup = Group::where('user_id', $admin->id)->first();

        $this->makeAndAcceptJoinRequestToGroup($joinedGroup, $admin, $user2);

        $this->be($user)->get(route('users.groups.index', $user2))
            ->assertOk()
            ->assertSee($ownedGroup->name)
            ->assertSee($joinedGroup->name);
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_a_group()
    {
        $this->signIn();  
        $group = factory(Group::class)->create();

        $this->patch(route('groups.update', $group), $attributes = [
            'name' => 'Lorem',
            'description' => 'Lorem'
        ])
        ->assertStatus(403);

        $this->assertDatabaseMissing('groups', $attributes);
    }

    /** @test */
    public function a_user_can_update_their_group()
    {
        $user = $this->signIn();
        $group = factory(Group::class)->create(['user_id' => $user->id]);

        $this->patch(route('groups.update', $group), $attributes = [
            'name' => 'Lorem',
            'description' => 'Lorem'
        ]);

        $this->assertDatabaseHas('groups', $attributes);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_a_group()
    {
        $user = $this->signIn();
        $group = factory(Group::class)->create();

        $this->delete(route('groups.destroy', $group))
            ->assertStatus(403);

        $this->assertDatabaseMissing('groups', $group->toArray());
    }

    /** @test */
    public function a_user_can_delete_their_group()
    {
        $user = $this->signIn();
        $group = factory(Group::class)->create(['user_id' => $user->id]);

        $this->delete(route('groups.destroy', $group))
            ->assertRedirect('/');

        $this->assertDatabaseMissing('groups', $group->toArray());
    }

    /** @test */
    public function a_user_can_send_a_join_request_to_a_group()
    {
        $group = factory(Group::class)->create();

        $this->makeJoinRequestToGroup($group);
    }

    /** @test */
    public function a_non_admin_of_a_group_cannot_assign_a_member_as_an_admin()
    {
        $admin = $this->signIn();
        $group = factory(Group::class)->raw(['user_id' => $admin->id]);

        $this->post(route('groups.store', $group));
        $this->assertDatabaseHas('groups', $group);

        $group = Group::first();
        $member = $this->makeAndAcceptJoinRequestToGroup($group, $admin);
        $this->signIn();
        $this->patch(route('groups.assign_admin', [$group, $member]))
            ->assertStatus(403);

        $this->assertFalse($group->hasAdmin($member));
    }

    /** @test */
    public function an_admin_of_a_group_can_assign_a_member_as_an_admin()
    {
        $admin = $this->signIn();
        $group = factory(Group::class)->raw(['user_id' => $admin->id]);

        $this->post(route('groups.store', $group), $group);
        $this->assertDatabaseHas('groups', $group);

        $group = Group::first();
        $member = $this->makeAndAcceptJoinRequestToGroup($group, $admin);
        $this->patch(route('groups.assign_admin', [$group, $member]));

        $this->assertTrue($group->hasAdmin($member));
    }

    /** @test */
    public function a_non_owner_of_a_group_cannot_remove_an_admin_from_admins_list()
    {
        $owner = $this->createGroupAndOwner();
        $group = Group::first();

        $admin1 = $this->makeAndAcceptJoinRequestToGroup($group, $owner);
        $group->assignAdmin($admin1);

        $group = Group::first();
        $admin2 = $this->makeAndAcceptJoinRequestToGroup($group, $owner);
        $group->assignAdmin($admin2);

        $this->be($admin1)->patch(route('groups.dismiss_admin', [$group, $admin2]))
            ->assertStatus(403);

        $this->assertTrue($group->hasAdmin($admin2));
    }

    /** @test */
    public function an_owner_of_a_group_can_remove_an_admin_from_admins_list()
    {
        $owner = $this->createGroupAndOwner();
        $group = Group::first();

        $admin = $this->makeAndAcceptJoinRequestToGroup($group, $owner);
        $group->assignAdmin($admin);

        $this->be($owner)->patch(route('groups.dismiss_admin', [$group, $admin]));

        $this->assertFalse($group->hasAdmin($admin));
    }

    /** @test */
    public function an_admin_of_a_group_can_remove_themselves_from_admins_list()
    {
        $owner = $this->createGroupAndOwner();
        $group = Group::first();

        $admin = $this->makeAndAcceptJoinRequestToGroup($group, $owner);
        $group->assignAdmin($admin);

        $this->be($admin)->patch(route('groups.dismiss_admin', [$group, $admin]));

        $this->assertFalse($group->hasAdmin($admin));
    }

    /** @test */
    public function a_user_who_didnot_send_a_join_request_to_a_group_cannot_cancel_it()
    {
        $group = factory(Group::class)->create();
        $user = $this->signIn();

        $this->delete(route('groups.cancel_request', $group))
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_cancel_a_join_request_to_a_group()
    {
        $group = factory(Group::class)->create();

        $user = $this->makeJoinRequestToGroup($group);
        $group = Group::first();

        $this->delete(route('groups.cancel_request', $group));

        $this->assertFalse($group->hasRequest($user));
    }

    /** @test */
    public function a_non_admin_cannot_accept_a_join_request()
    {
        // given we have an admin of a group
        $admin = $this->createGroupAndOwner();
        $group = Group::first();
        $this->assertTrue($group->hasAdmin($admin));

        // and a member of this group
        $member = factory(User::class)->create();
        $this->makeFriends($admin, $member);
        $this->post(route('groups.add_member', [$group, $member]));
        $this->assertTrue($group->hasAcceptedMember($member));

        // we also have a join request
        $user = $this->makeJoinRequestToGroup($group);

        // that member cannot remove the join request
        $this->signIn($member);
        $this->get(route('groups.requests', $group))
            ->assertStatus(403);
        $this->patch(route('groups.accept_request', [$group, $user]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_admin_can_accept_a_join_request()
    {
        $admin = $this->createGroupAndOwner();
        $group = Group::first();
        $this->assertTrue($group->hasAdmin($admin));

        $this->get(route('groups.requests', $group))
            ->assertOk();

        $this->makeAndAcceptJoinRequestToGroup($group, $admin);
    }

    /** @test */
    public function a_non_admin_cannot_remove_a_join_request()
    {
        // given we have an admin of a group
        $admin = $this->createGroupAndOwner();
        $group = Group::first();
        $this->assertTrue($group->hasAdmin($admin));

        // and a member of this group
        $member = factory(User::class)->create();
        $this->makeFriends($admin, $member);
        $this->post(route('groups.add_member', [$group, $member]));
        $this->assertTrue($group->hasAcceptedMember($member));

        // we also have a join request
        $user = $this->makeJoinRequestToGroup($group);

        // that member cannot remove the join request
        $this->be($member)->delete(route('groups.remove_request', [$group, $user]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_admin_can_remove_a_join_request()
    {
        // given we have an admin of a group
        $admin = $this->createGroupAndOwner();
        $group = Group::first();
        $this->assertTrue($group->hasAdmin($admin));

        // and a user wants to join this group
        $user = $this->makeJoinRequestToGroup($group);

        // when the admin removes their request
        $this->signIn($admin);
        $group = Group::first();
        $this->delete(route('groups.remove_request', [$group, $user]));

        // then their request is no longer exist
        $this->assertFalse($group->hasRequest($user));
        $this->assertFalse($group->members->contains($user));
    }

    /** @test */
    public function a_non_admin_cannot_add_a_friend_to_a_group()
    {
        // given we have an admin that creates a group
        $admin = $this->createGroupAndOwner();
        $group = Group::first();
        $this->assertTrue($group->hasAdmin($admin));

        // a member of the group
        $member = $this->makeAndAcceptJoinRequestToGroup($group, $admin);
        $this->signIn($member);

        // and a friend of that member
        $friend = factory(User::class)->create();
        $this->makeFriends($member, $friend);

        // when the member tries to add their friend they get 403 error
        $this->get(route('groups.view_friends', $group))
            ->assertStatus(403);
        $this->post(route('groups.add_member', [$group, $friend]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_admin_cannot_add_a_user_that_is_not_a_friend_to_their_group()
    {
        // given we have an admin that creates a group
        $admin = $this->createGroupAndOwner();
        $group = Group::first();
        $this->assertTrue($group->hasAdmin($admin));

        // and a user that's not a friend of the admin
        $user = factory(User::class)->create();

        // when the admin tries to add this user to the group
        $this->get(route('groups.view_friends', $group))->assertOk();
        $this->post(route('groups.add_member', [$group, $user]))
            ->assertStatus(404);

        // then the user won't become a member
        $this->assertFalse($group->hasAcceptedMember($user));
    }

    /** @test */
    public function an_admin_can_add_a_friend_to_their_group()
    {
        // given we have an admin that creates a group
        $admin = $this->createGroupAndOwner();
        $group = Group::first();
        $this->assertTrue($group->hasAdmin($admin));

        // and a user that's a friend of the admin
        $user = factory(User::class)->create();
        $this->makeFriends($admin, $user);

        // when the admin tries to add thier friend to the group
        $this->get(route('groups.view_friends', $group))->assertOk();
        $this->post(route('groups.add_member', [$group, $user]));
        
        // then the friend becomes a member
        $this->assertTrue($group->hasAcceptedMember($user));
    }

    /** @test */
    public function a_non_admin_cannot_remove_a_member_from_a_group()
    {
        // given we have an admin that creates a group
        $admin = $this->createGroupAndOwner();
        $group = Group::first();
        $this->assertTrue($group->hasAdmin($admin));

        // and two members of the group
        $member1 = $this->makeAndAcceptJoinRequestToGroup($group, $admin);
        $group = Group::first();
        $member2 = $this->makeAndAcceptJoinRequestToGroup($group, $admin);

        // when a member tries to remove another member from the group they fail
        $this->be($member1)->delete(route('groups.remove_member', [$group, $member2]))
            ->assertStatus(403);
    }

    /** @test */
    public function a_non_member_cannot_view_admins_of_a_group()
    {
        $this->signIn();
        $group = factory(Group::class)->create();

        $this->get(route('groups.admins', $group))->assertStatus(403);
    }

    /** @test */
    public function a_member_can_view_admins_of_a_group()
    {
        $member = $this->createMember();
        $group = Group::first();

        $this->be($member)->get(route('groups.admins', $group))->assertOk();
    }

    /** @test */
    public function a_non_member_cannot_view_members_of_a_group()
    {
        $this->signIn();
        $group = factory(Group::class)->create();

        $this->get(route('groups.members', $group))->assertStatus(403);
    }

    /** @test */
    public function a_member_can_view_members_of_a_group()
    {
        $member = $this->createMember();
        $group = Group::first();

        $this->be($member)->get(route('groups.members', $group))->assertOk();
    }

    /** @test */
    public function a_non_member_cannot_leave_a_group()
    {
        $group = factory(Group::class)->create();
        $user = $this->signIn();

        $this->delete(route('groups.leave', $group))
            ->assertStatus(403);
    }

    /** @test */
    public function a_member_can_leave_a_group()
    {
        $admin = $this->createGroupAndOwner();
        $group = Group::first();
        $this->assertTrue($group->hasAdmin($admin));

        $member = $this->makeAndAcceptJoinRequestToGroup($group, $admin);

        $this->be($member)->delete(route('groups.leave', $group))
            ->assertRedirect(route('groups.show', $group));

        $group = Group::first();
        $this->assertFalse($group->hasAcceptedMember($member));
    }

    /** @test */
    public function a_non_member_user_cannot_create_a_post()
    {
        $admin = $this->createGroupAndOwner();
        $group = Group::first();

        $user = factory(User::class)->create();

        $post = factory(Post::class)->raw(['user_id' => $user->id, 'group_id' => $group->id]);

        $this->be($user)->post(route('groups.posts.store', $group), $post)
            ->assertStatus(403);
    }

    /** @test */
    public function a_member_can_create_a_post()
    {
        $this->WithoutExceptionHandling();
        $admin = $this->createGroupAndOwner();
        $group = Group::first();

        $member = $this->makeAndAcceptJoinRequestToGroup($group, $admin);

        $post = factory(Post::class)->raw(['user_id' => $member->id, 'group_id' => $group->id]);

        $this->be($member)->post(route('groups.posts.store', $group), $post)
            ->assertRedirect(route('groups.show', $group));

        $this->assertDatabaseHas('posts', $post);
    }

    /** @test */
    public function a_post_of_a_group_requires_a_body()
    {
        $admin = $this->createGroupAndOwner();
        $group = Group::first();

        $member = $this->makeAndAcceptJoinRequestToGroup($group, $admin);

        $post = factory(Post::class)->raw([
            'user_id' => $member->id, 
            'group_id' => $group->id,
            'body' => ''
        ]);

        $this->post(route('groups.posts.store', $group), $post)
             ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_user_can_update_their_posts_of_a_group()
    {
        // Create a post
        $admin = $this->createGroupAndOwner();
        $group = Group::first();

        $member = $this->makeAndAcceptJoinRequestToGroup($group, $admin);

        $post = factory(Post::class)->create(['user_id' => $member->id, 'group_id' => $group->id]);

        // Update it
        $this->be($member)->patch(route('groups.posts.update', [$group, $post]), ['body' => 'updated']);

        $this->assertDatabaseHas('posts', ['body' => 'updated']);
    }

    /** @test */
    public function a_user_can_delete_their_posts_of_a_group()
    {
        // Create a post
        $admin = $this->createGroupAndOwner();
        $group = Group::first();

        $member = $this->makeAndAcceptJoinRequestToGroup($group, $admin);

        $post = factory(Post::class)->create(['user_id' => $member->id, 'group_id' => $group->id]);

        // Delete it
        $this->be($member)->delete(route('groups.posts.destroy', [$group, $post]));

        $this->assertDatabaseMissing('posts', $post->toArray());
    }

    public function createMember()
    {
        $admin = $this->createGroupAndOwner();
        $group = Group::first();
        $this->assertTrue($group->hasAdmin($admin));

        return $this->makeAndAcceptJoinRequestToGroup($group, $admin);
    }

    public function makeFriends($user, $friend)
    {
        $friend->sendFriendRequest($user);
        $user->acceptFriendRequest($friend);

        $this->assertTrue($user->hasFriend($friend));
    }

    public function createGroupAndOwner()
    {
        $admin = $this->signIn();
        $group = factory(Group::class)->raw(['user_id' => $admin->id]);

        $this->post(route('groups.store', 1), $group);
        
        $this->assertDatabaseHas('groups', $group);

        return $admin;
    }

    public function makeAndAcceptJoinRequestToGroup($group, $admin, $user = null)
    {
        $member = $this->makeJoinRequestToGroup($group, $user);

        $this->be($admin)->patch(route('groups.accept_request', [$group, $member]));

        $this->assertTrue($group->hasAcceptedMember($member));

        return $member;
    }

    public function makeJoinRequestToGroup($group, $user = null)
    {
        $user = $user ? $this->signIn($user) : $this->signIn();

        $this->post(route('groups.join', $group));
        
        $this->assertTrue($group->hasRequest($user));

        return $user;
    }
}
