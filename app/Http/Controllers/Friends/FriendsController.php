<?php

namespace App\Http\Controllers\Friends;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

class FriendsController extends Controller
{
    public function show(User $user)
    {
    	return view('friends.show', compact(['user']));
    }
}
