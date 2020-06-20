<?php

namespace App;

use App\Like;
use App\Post;
use App\Group;
use App\Comment;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birth_date', 'phone', 'college', 'gender', 'bio', 'address', 'profile_picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'birth_date'
    ];

    public function getNameAttribute($value) {
        return ucfirst($value);
    }

    public function path()
    {
        return route('users.show', $this);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Groups created by the user
     */
    public function ownedGroups()
    {
        return $this->hasMany(Group::class);
    }

    /**
     * Groups of which the user is a member or an admin
     */
    public function joinedGroups()
    {
        return $this->groups()
                    ->wherePivot('member_status', 'accepted');
    }

    /**
     * Groups of which the user is a member or an admin
     */
    public function requestedGroups()
    {
        return $this->groups()
                    ->wherePivot('member_status', 'pending');
    }

    /**
     * All groups related to a user
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_member', 'member_id', 'group_id')
                    ->withPivot('member_status', 'member_position');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function sentFriendRequests()
    {
        return $this->belongsToMany(self::class, 'friend_requests', 'from_user_id', 'to_user_id')->withTimestamps();
    }

    public function receivedFriendRequests()
    {
        return $this->belongsToMany(self::class, 'friend_requests', 'to_user_id', 'from_user_id')->withTimestamps();
    }

    public function friends()
    {
        return $this->belongsToMany(self::class, 'friends', 'user_id', 'friend_id')->withTimestamps();
    }

    public function sendFriendRequest(self $user)
    {
        $this->sentFriendRequests()->attach($user);
    }

    public function cancelFriendRequest(self $user)
    {
        $this->sentFriendRequests()->detach($user);
    }

    public function acceptFriendRequest(self $user)
    {
        $this->friends()->attach($user);
        $user->friends()->attach($this);
        $this->receivedFriendRequests()->detach($user);
    }

    public function deleteFriendRequest(self $user)
    {
        $this->receivedFriendRequests()->detach($user);
    }

    public function unfriend(self $user)
    {
        $this->friends()->detach($user);
        $user->friends()->detach($this);
    }

    public function hasFriend(self $user)
    {
        return $this->friends->contains($user);
    }

    public function hasFriendRequest(self $user)
    {
        return $this->receivedFriendRequests->contains($user);
    }
}
