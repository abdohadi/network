<?php

namespace App\Policies;

use App\User;
use App\comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \App\User  $user
     * @param  \App\comment  $comment
     * @return mixed
     */
    public function manage(User $user, comment $comment)
    {
        return $user->is($comment->owner);
    }
}
