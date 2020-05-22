<?php

namespace App\Http\Controllers\Friends;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

class FriendRequestsController extends Controller
{
    public function send(User $user)
    {
        abort_if($user->hasFriend(auth()->user()), 404);
        abort_if($user->hasFriendRequest(auth()->user()), 404);

    	auth()->user()->sendFriendRequest($user);
    }

    public function cancel(User $user)
    {
    	auth()->user()->cancelFriendRequest($user);
    }

    public function accept(User $user)
    {
    	auth()->user()->acceptFriendRequest($user);
    }

    public function delete(User $user)
    {
    	auth()->user()->deleteFriendRequest($user);
    }
}
