<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User;

class MangeUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_access_the_login_page()
    {
        // $this->withoutExceptionHandling();
        $this->get(localizeURL('/login'))->assertOk();
    }

    /** @test */
    public function a_user_can_view_the_home_page()
    {
        $this->signIn();
        
        $this->get(localizeURL('/'))->assertOk();

        $this->get(localizeURL('/home'))->assertOk();
    }

    /** @test */
    public function a_user_can_view_a_profile_of_any_user()
    {
        // a user can view their profiles
        $user = factory(User::class)->create();
        $this->be($user)
            ->get(localizeURL($user->path()))
            ->assertOk();

        // a user can view profiles of others
        $this->signIn();
        $this->get(localizeURL($user->path()))->assertOk();
    }

    /** @test */
    public function a_gust_cannot_view_a_profile_of_any_user()
    {
        // guest
        $user = factory(User::class)->create();
        $this->get(localizeURL($user->path()))->assertRedirect(localizeURL('login'));
    }

    /** @test */
    public function a_user_can_send_a_friend_request_to_another_user()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $this->get(localizeURL('users/request/send/'.$anotherUser->id));

        $this->assertTrue($user->sentFriendRequests->contains($anotherUser));
    }

    /** @test */
    public function a_user_can_cancel_a_friend_request()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $this->get(localizeURL('users/request/cancel/'.$anotherUser->id));

        $this->assertFalse($user->sentFriendRequests->contains($anotherUser));
    }

    /** @test */
    public function a_user_can_accept_a_friend_request()
    {
        $user = $this->signIn();

        $anotherUser = factory(User::class)->create();

        $this->get(localizeURL('users/request/send/'.$anotherUser->id));

        $this->signIn($anotherUser);

        $this->get(localizeURL('users/request/accept/'.$user->id));

        $this->assertTrue($anotherUser->friends->contains($user));
    }

    /** @test */
    public function a_user_can_view_friends_list_of_another_user()
    {
        $this->signIn();

        $user = factory(User::class)->create();

        $this->get(localizeURL("users/{$user->id}/friends"))->assertOk();
    }

    /** @test */
    public function a_user_cannot_update_other_users_info()
    {
        $this->signIn();
        $user = factory('App\User')->create();

        $this->get(localizeURL($user->path()))->assertDontSee('Edit Your Info');
        $this->get(localizeURL($user->path() . '/edit_info'))->assertStatus(403);
        $this->patch(localizeURL($user->path() . '/update_info'), [])->assertStatus(403);
    }

    /** @test */
    public function a_user_can_update_their_info()
    {
        $user = $this->signIn();

        $this->get(localizeURL($user->path() . '/edit_info'))->assertOk();

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

        $this->patch(localizeURL($user->path() . '/update_info'), $info);

        $this->assertDatabaseHas('users', $info);

        $this->get(localizeURL($user->path()))->assertSee('I am John Doe');
    }

    /** @test */
    public function a_user_can_update_their_profile_picture()
    {
        $user = $this->signIn();

        $pic = UploadedFile::fake()->image('profile.jpg');

        $this->json('PATCH', localizeURL($user->path() . '/update_picture'), [
            'profile_picture' => $pic
        ])->assertRedirect($user->path());

        Storage::disk('public_uploads')->assertExists('images/user_images/profile_pictures/' . $pic->hashName());

        $this->assertDatabaseHas('users', ['profile_picture' => $pic->hashName()]);
    }
}
