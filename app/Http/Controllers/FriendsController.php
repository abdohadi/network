<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FriendsController extends Controller
{
    public function show(User $user)
    {
    	return view('friends.show', compact(['user']));
    }
}
