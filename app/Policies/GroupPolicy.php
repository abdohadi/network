<?php

namespace App\Policies;

use App\User;
use App\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user is a member.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function createPost(User $user, Group $group)
    {
        return $group->hasAcceptedMember($user);
    }
}
