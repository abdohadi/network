<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_view_the_home_page()
    {
        // $this->withoutExceptionHandling();
        // a guest cannot view the home page
        $this->get(route('login'))->assertOk();

        // authenticated user
        $this->signIn();
        
        $this->get(route('/'))->assertOk();

        $this->get(route('home'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_can_view_the_profile_of_any_user()
    {
        // a guest cannot view profiles
        $user = factory(User::class)->create();
        $this->get(route('users.show', $user))->assertRedirect(route('login'));

        // an authenticated user can view their profiles
        $user = factory(User::class)->create();
        $this->be($user)
            ->get(route('users.show', $user))
            ->assertOk();

        // an authenticated user can view profiles of others
        $this->signIn();
        $this->get(route('users.show', $user))->assertOk();
    }

    /** @test */
    public function a_user_can_send_a_friend_request_to_another_user()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $this->post(route('users.send_request', $anotherUser));

        $this->assertTrue($user->sentFriendRequests->contains($anotherUser));
        $this->assertTrue($anotherUser->receivedFriendRequests->contains($user));
    }

    /** @test */
    public function a_user_can_cancel_a_friend_request()
    {
        // A user has a friend
        $user = $this->signIn();
        $anotherUser = factory(User::class)->create();

        $this->post(route('users.send_request', $anotherUser));
        $this->assertTrue($user->sentFriendRequests->contains($anotherUser));
        $this->assertTrue($anotherUser->receivedFriendRequests->contains($user));

        // The user can cancel the request
        $this->delete(route('users.cancel_request', $anotherUser));
        $this->assertFalse($user->sentFriendRequests->contains($anotherUser));
        $this->assertFalse($anotherUser->receivedFriendRequests->contains($user));
    }

    /** @test */
    public function a_user_can_accept_a_friend_request()
    {
        // A user has a friend
        $user = $this->signIn();
        $anotherUser = factory(User::class)->create();

        $this->post(route('users.send_request', $anotherUser));
        $this->assertTrue($user->sentFriendRequests->contains($anotherUser));
        $this->assertTrue($anotherUser->receivedFriendRequests->contains($user));

        // The user can accept the request
        $this->be($anotherUser)->post(route('users.accept_request', $user));

        $this->assertTrue($anotherUser->friends->contains($user));
        $this->assertTrue($user->friends->contains($anotherUser));
    }

    /** @test */
    public function a_user_can_delete_a_friend_request()
    {
        // A user has a friend
        $user = $this->signIn();
        $anotherUser = factory(User::class)->create();

        $this->post(route('users.send_request', $anotherUser));
        $this->assertTrue($user->sentFriendRequests->contains($anotherUser));
        $this->assertTrue($anotherUser->receivedFriendRequests->contains($user));

        // The user can delete the request
        $this->be($anotherUser)->delete(route('users.delete_request', $user));

        $this->assertFalse($anotherUser->receivedFriendRequests->contains($user));
        $this->assertFalse($user->sentFriendRequests->contains($anotherUser));
    }

    /** @test */
    public function a_user_can_unfriend_a_friend()
    {
        // A user has a friend
        $user = $this->signIn();
        $anotherUser = factory(User::class)->create();

        $this->post(route('users.send_request', $anotherUser));
        $this->assertTrue($user->sentFriendRequests->contains($anotherUser));

        $this->be($anotherUser)->post(route('users.accept_request', $user));
        $this->assertTrue($anotherUser->friends->contains($user));
        $this->assertTrue($user->friends->contains($anotherUser));

        // the user can unfriend their friend
        $this->be($user)->delete(route('users.unfriend', $anotherUser));

        $this->assertFalse($user->friends->contains($anotherUser));
        $this->assertFalse($anotherUser->friends->contains($user));
    }

    /** @test */
    public function an_authenticated_user_can_view_friends_list_of_another_user()
    {
        // a guest cannot view friends list
        $user = factory(User::class)->create();
        $this->get(route('users.friends.index', $user))->assertRedirect(route('login'));

        // an authenticated user can view friends list
        $this->signIn();

        $user = factory(User::class)->create();

        $this->get(route('users.friends.index', $user))->assertOk();
    }

    /** @test */
    public function an_unauthorized_and_unauthenticated_user_cannot_edit_other_users_info()
    {
        // an unauthenticated user
        $user = factory(User::class)->create();
        $this->get(route('users.edit_info', $user))->assertRedirect(route('login'));

        // an unauthorized user
        $this->signIn();
        $this->get(route('users.show', $user))->assertDontSee('Edit Your Info');
        $this->get(route('users.edit_info', $user))->assertStatus(403);
    }

    /** @test */
    public function updating_user_info_validation()
    {
        $user = $this->signIn();

        $info = [
            'name' => '',
            'email' => '',
            'address' => \Str::random(101),
            'phone' => \Str::random(51),
            'birth_date' => 'invalid date',
            'gender' => 'other',
            'college' => \Str::random(51),
            'bio' => \Str::random(121)
        ];

        $this->patch(route('users.update_info', $user), $info)
            ->assertSessionHasErrors('name')
            ->assertSessionHasErrors('email')
            ->assertSessionHasErrors('address')
            ->assertSessionHasErrors('phone')
            ->assertSessionHasErrors('birth_date')
            ->assertSessionHasErrors('gender')
            ->assertSessionHasErrors('college')
            ->assertSessionHasErrors('bio');

        $info = [
            'email' => 'invalid email'
        ];

        $this->patch(route('users.update_info', $user), $info)
            ->assertSessionHasErrors('email');

        // check for unique email
        $user2 = factory(User::class)->create();
        $info = [
            'email' => $user2->email
        ];

        $this->patch(route('users.update_info', $user), $info)
            ->assertSessionHasErrors('email');

        // a user can update their info whithout changing their email address 
        $info = [
            'name' => 'name',
            'email' => $user->email
        ];

        $this->patch(route('users.update_info', $user), $info)
            ->assertSessionHasNoErrors('email');
    }

    /** @test */
    public function a_user_can_update_their_info()
    {
        $user = $this->signIn();

        $this->get(route('users.edit_info', $user))->assertOk();

        $info = [
            'name' => 'John Doe',
            'email' => 'example@example.com',
            'birth_date' => '2020-03-17 00:00:00',
            'address' => 'Cairo',
            'phone' => '1111111111',
            'gender' => 'male',
            'college' => 'Harvard',
            'bio' => 'I am John Doe' 
        ];

        $this->patch(route('users.update_info', $user), $info);

        $this->assertDatabaseHas('users', $info);

        $this->get(route('users.show', $user))->assertSee('I am John Doe');
    }

    /** @test */
    public function a_user_can_update_their_profile_picture()
    {
        $user = $this->signIn();

        $pic = UploadedFile::fake()->image('profile.jpg');

        $this->json('PATCH', route('users.update_picture', $user), [
            'profile_picture' => $pic
        ])
        ->assertRedirect($user->path());

        Storage::disk('public_uploads')->assertExists('images/user_images/profile_pictures/' . $pic->hashName());

        $this->assertDatabaseHas('users', ['profile_picture' => $pic->hashName()]);
    }

    /** @test */
    public function a_user_can_update_their_profile_cover()
    {
        $user = $this->signIn();

        $cover = UploadedFile::fake()->image('profile.png');

        $this->json('PATCH', route('users.update_cover', $user), [
            'profile_cover' => $cover
        ])
        ->assertRedirect($user->path());

        Storage::disk('public_uploads')->assertExists('images/user_images/covers/' . $cover->hashName());

        $this->assertDatabaseHas('users', ['profile_cover' => $cover->hashName()]);
    }
}
