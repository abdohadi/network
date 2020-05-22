<?php

namespace App\Http\Controllers\Users;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $ownedGroups = $user->ownedGroups;
        $joinedGroups = $user->joinedGroups()->whereNotIn('user_id', [$user->id])->get();
        $requestedGroups = $user->requestedGroups;

        return view('users.groups.index', compact(['user', 'ownedGroups', 'joinedGroups', 'requestedGroups']));
    }
}
