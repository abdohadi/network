<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Group;
use App\Post;
use App\Like;

class UserTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function a_user_has_a_path()
    {
        // $this->withoutExceptionHandling();
    	$user = factory(User::class)->create();

    	$this->assertEquals('/users/'.$user->id, $user->path());
    }

    /** @test */
    public function a_user_can_have_posts()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create(['user_id'=>$user->id]);

        $this->assertInstanceOf(Post::class, $user->posts->first());
    }

    /** @test */
    public function a_user_can_have_groups()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create(['user_id'=>$user->id]);

        $this->assertInstanceOf(Group::class, $user->groups->first());
    }

    /** @test */
    public function a_user_can_have_likes()
    {
        $user = factory(User::class)->create();
        $like = factory(Like::class)->create(['user_id'=>$user->id]);

        $this->assertInstanceOf(Like::class, $user->likes->first());
    }

    /** @test */
    public function a_user_can_send_a_friend_request_to_another_user()
    {
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
