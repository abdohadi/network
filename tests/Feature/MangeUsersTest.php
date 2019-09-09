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
}
