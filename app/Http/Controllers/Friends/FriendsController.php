<?php

namespace App\Http\Controllers\Friends;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

class FriendsController extends Controller
{
    public function index(User $user)
    {
    	return view('friends.index', compact(['user']));
    }

    public function destroy(User $user)
    {
    	abort_if(! auth()->user()->hasFriend($user), 404);

    	auth()->user()->unfriend($user);

    	return back();
    }
}
