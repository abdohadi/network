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
    public function a_user_has_a_path()
    {
    	$user = factory(User::class)->create();

    	$this->assertEquals('/users/'.$user->id, $user->path());
    }

    /** @test */
    public function a_user_can_have_posts()
    {
        $this->assertInstanceOf(User::class, factory(User::class)->create());
    }

    /** @test */
    public function a_user_can_have_groups()
    {
        $this->assertInstanceOf(Group::class, factory(Group::class)->create());
    }

    /** @test */
    public function a_user_can_send_a_friend_request_to_another_user()
    {
        // $this->withoutExceptionHandling();
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $user->sendFriendRequest($anotherUser);

        $this->assertTrue($user->sentFriendRequests->contains($anotherUser));
    }

    /** @test */
    public function a_user_can_cancel_a_friend_request()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $user->cancelFriendRequest($anotherUser);

        $this->assertFalse($user->sentFriendRequests->contains($anotherUser));
    }

    /** @test */
    public function a_user_can_receive_a_friend_request_from_another_user()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $anotherUser->sendFriendRequest($user);

        $this->assertTrue($user->receivedFriendRequests->contains($anotherUser));
    }

    /** @test */
    public function a_user_can_accept_a_friend_request_from_another_user()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $anotherUser->sendFriendRequest($user);

        $user->acceptFriendRequest($anotherUser);

        $this->assertTrue($user->friends->contains($anotherUser));
    }
}
