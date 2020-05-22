<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MangeUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_view_the_home_page()
    {
        // $this->withoutExceptionHandling();
        // a guest cannot view the home page
        $this->get(localizeURL('/login'))->assertOk();

        // authenticated user
        $this->signIn();
        
        $this->get(localizeURL('/'))->assertOk();

        $this->get(localizeURL('/home'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_can_view_the_profile_of_any_user()
    {
        // a guest cannot view profiles
        $user = factory(User::class)->create();
        $this->get(localizeURL($user->path()))->assertRedirect(localizeURL('login'));

        // an authenticated user can view their profiles
        $user = factory(User::class)->create();
        $this->be($user)
            ->get(localizeURL($user->path()))
            ->assertOk();

        // an authenticated user can view profiles of others
        $this->signIn();
        $this->get(localizeURL($user->path()))->assertOk();
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
    public function an_authenticated_user_can_view_friends_list_of_another_user()
    {
        // a guest cannot view friends list
        $user = factory(User::class)->create();
        $this->get(localizeURL("users/{$user->id}/friends"))->assertRedirect(localizeURL('login'));

        // an authenticated user
        $this->signIn();

        $user = factory(User::class)->create();

        $this->get(localizeURL("users/{$user->id}/friends"))->assertOk();
    }

    /** @test */
    public function an_unauthorized_and_unauthenticated_user_cannot_edit_other_users_info()
    {
        // an unauthenticated user
        $user = factory(User::class)->create();
        $this->get(localizeURL($user->path() . '/edit_info'))->assertRedirect(localizeURL('login'));

        // an unauthorized user
        $this->signIn();
        $this->get(localizeURL($user->path()))->assertDontSee('Edit Your Info');
        $this->get(localizeURL($user->path() . '/edit_info'))->assertStatus(403);
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

        $this->patch(localizeURL($user->path() . '/update_info'), $info)
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

        $this->patch(localizeURL($user->path() . '/update_info'), $info)
            ->assertSessionHasErrors('email');

        // check for unique email
        $user2 = factory(User::class)->create();
        $info = [
            'email' => $user2->email
        ];

        $this->patch(localizeURL($user->path() . '/update_info'), $info)
            ->assertSessionHasErrors('email');

        // a user can update their info whithout changing their email address 
        $info = [
            'name' => 'name',
            'email' => $user->email
        ];

        $this->patch(localizeURL($user->path() . '/update_info'), $info)
            ->assertSessionHasNoErrors('email');
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
        ])
        ->assertRedirect($user->path());

        Storage::disk('public_uploads')->assertExists('images/user_images/profile_pictures/' . $pic->hashName());

        $this->assertDatabaseHas('users', ['profile_picture' => $pic->hashName()]);
    }

    /** @test */
    public function a_user_can_update_their_profile_cover()
    {
        $this->withoutExceptionHandling();
        $user = $this->signIn();

        $cover = UploadedFile::fake()->image('profile.png');

        $this->json('PATCH', localizeURL($user->path() . '/update_cover'), [
            'profile_cover' => $cover
        ])
        ->assertRedirect($user->path());

        Storage::disk('public_uploads')->assertExists('images/user_images/covers/' . $cover->hashName());

        $this->assertDatabaseHas('users', ['profile_cover' => $cover->hashName()]);
    }
}
