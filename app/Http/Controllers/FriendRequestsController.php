<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FriendRequestsController extends Controller
{
    public function send(User $user)
    {
    	auth()->user()->sendFriendRequest($user);
    }

    public function cancel(User $user)
    {
    	auth()->user()->cancelFriendRequest($user);
    }
}
