<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class MangeUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_and_a_guest_can_view_a_profile_of_any_user()
    {
        // $this->withoutExceptionHandling();
        // guest
        $user = factory(User::class)->create();
        $this->get($user->path())->assertSee($user->name);

        // a user can view their profiles
        $this->be($user)
            ->get($user->path())
            ->assertSee($user->name);

        // a user can view profiles of others
        $this->signIn();
        $this->get($user->path())->assertSee($user->name);
    }

    /** @test */
    public function a_user_can_send_a_friend_request_to_another_user()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $this->get('users/request/send/'.$anotherUser->id);

        $this->assertTrue($user->sentFriendRequests->contains($anotherUser));
    }

    /** @test */
    public function a_user_can_cancel_a_friend_request()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $this->get('users/request/cancel/'.$anotherUser->id);

        $this->assertFalse($user->sentFriendRequests->contains($anotherUser));
    }

    /** @test */
    public function a_user_can_accept_a_friend_request()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $this->get('users/request/send/'.$anotherUser->id);

        $this->signIn($anotherUser);

        $this->get('users/request/accept/'.$user->id);

        $this->assertTrue($anotherUser->friends->contains($user));
    }

    /** @test */
    public function anyone_can_view_friends_list_of_another_user()
    {
        // guest
        $user = factory(User::class)->create();

        $this->get("users/{$user->id}/friends")->assertOk();

        // user
        $this->signIn();

        $this->get("users/{$user->id}/friends")->assertOk();
    }
}
