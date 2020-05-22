<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Group;
use App\Post;
use App\Like;
use App\Comment;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        // $this->withoutExceptionHandling();
    	$user = factory(User::class)->create();

    	$this->assertEquals('/users/'.$user->id, $user->path());
    }

    /** @test */
    public function it_can_have_posts()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Post::class, $user->posts->first());
    }

    /** @test */
    public function it_can_have_their_own_groups()
    {
        $user = $this->signIn();
        $group = factory(Group::class)->raw(['user_id' => $user->id]);

        $this->post(localizeURL('/groups'), $group);

        $this->assertInstanceOf(Group::class, $user->ownedGroups->first());
    }

    /** @test */
    public function it_can_have_groups_which_is_an_admin_or_a_member_of()
    {
        $admin = $this->signIn();
        $group = factory(Group::class)->raw(['user_id' => $admin->id]);
        $this->post(localizeURL('/groups'), $group);
        $this->assertInstanceOf(Group::class, $admin->groups->first());

        $user = $this->signIn();
        $group = factory(Group::class)->raw();
        $this->post(localizeURL('/groups'), $group);
        $this->assertInstanceOf(Group::class, $user->groups->first());
    }

    /** @test */
    public function it_can_have_likes()
    {
        $user = factory(User::class)->create();
        factory(Like::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Like::class, $user->likes->first());
    }

    /** @test */
    public function it_can_have_comments()
    {
        $user = factory(User::class)->create();
        factory(Comment::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Comment::class, $user->comments->first());
    }

    /** @test */
    public function it_can_send_a_friend_request_to_another_user()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $user->sendFriendRequest($anotherUser);

        $this->assertTrue($user->sentFriendRequests->contains($anotherUser));
    }

    /** @test */
    public function it_can_cancel_a_friend_request()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $user->cancelFriendRequest($anotherUser);

        $this->assertFalse($user->sentFriendRequests->contains($anotherUser));
    }

    /** @test */
    public function it_can_receive_a_friend_request_from_another_user()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $anotherUser->sendFriendRequest($user);

        $this->assertTrue($user->receivedFriendRequests->contains($anotherUser));
    }

    /** @test */
    public function it_can_accept_a_friend_request_from_another_user()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $anotherUser->sendFriendRequest($user);

        $user->acceptFriendRequest($anotherUser);

        $this->assertTrue($user->friends->contains($anotherUser));
    }

    /** @test */
    public function it_can_check_if_it_has_a_friend()
    {
        $user = $this->signIn();
        $anotherUser = factory(User::class)->create();

        $anotherUser->sendFriendRequest($user);
        $user->acceptFriendRequest($anotherUser);

        $this->assertTrue($user->hasFriend($anotherUser));
        $this->assertTrue($anotherUser->hasFriend($user));
    }

    /** @test */
    public function it_can_check_if_it_has_a_friend_request()
    {
        $user = $this->signIn();
        $anotherUser = factory(User::class)->create();

        $anotherUser->sendFriendRequest($user);

        $this->assertTrue($user->hasFriendRequest($anotherUser));
    }
}
