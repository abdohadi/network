<?php

namespace App\Http\Controllers\Groups;

use App\User;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupsUsersController extends Controller
{
    public function join(Group $group)
    {
        abort_if($group->hasRequest(auth()->user()), 403);

        $group->join(auth()->user());
    }

    public function cancelRequest(Group $group)
    {
        abort_if(! $group->hasRequest(auth()->user()), 403);

        $group->removeRequest(auth()->user());
    }

    public function leaveGroup(Group $group)
    {
        abort_if(! $group->hasAcceptedMember(auth()->user()), 403);

        $group->removeMember(auth()->user());

        return redirect(route('groups.show', $group));
    }

    public function viewAdmins(Group $group)
    {
        abort_if(! $group->hasAcceptedMember(auth()->user()), 403);

        return view('groups.admins', compact('group'));
    }

    public function assignAdmin(Group $group, User $user)
    {
        abort_if(! $group->hasAcceptedMember($user), 404);
        abort_if(! $group->hasAdmin(auth()->user()), 403);

        $group->assignAdmin($user);
    }

    public function dismissAdmin(Group $group, User $user)
    {
        abort_if(! $group->hasAdmin($user), 404);
        abort_if(! $group->hasAdmin(auth()->user()) || ($group->owner->isNot(auth()->user()) && $user->isNot(auth()->user())), 403);

        $group->dismissAdmin($user);
    }

    public function viewRequests(Group $group)
    {
        abort_if(! $group->hasAdmin(auth()->user()), 403);

        return view('groups.requests', compact('group'));
    }

    public function acceptRequest(Group $group, User $user)
    {
        abort_if(! $group->hasRequest($user), 404);
        abort_if(! $group->hasAdmin(auth()->user()), 403);

        $group->acceptRequest($user);
    }

    public function removeRequest(Group $group, User $user)
    {
        abort_if(! $group->hasRequest($user), 404);
        abort_if(! $group->hasAdmin(auth()->user()), 403);

        $group->removeRequest($user);
    }

    public function viewFriends(Group $group)
    {
        abort_if(! $group->hasAdmin(auth()->user()), 403);

        return view('groups.add_member', compact('group'));
    }

    public function addMember(Group $group, User $user)
    {
        abort_if(! auth()->user()->hasFriend($user), 404);
        abort_if(! $group->hasAdmin(auth()->user()), 403);
        abort_if(! auth()->user()->hasFriend($user), 403);

        $group->addMember($user);
    }

    public function viewMembers(Group $group)
    {
        abort_if(! $group->hasAcceptedMember(auth()->user()), 403);

        return view('groups.members', compact('group'));
    }

    public function removeMember(Group $group, User $user)
    {
        abort_if(! $group->hasAcceptedMember($user), 404);
        abort_if(! $group->hasAdmin(auth()->user()), 403);

        $group->removeMember($user);
    }
}
