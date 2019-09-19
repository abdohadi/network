<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Post;
use App\Group;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function path()
    {
        return '/users/'.$this->id;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
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
        return $this->belongsToMany(self::class, 'friends', 'friend_id', 'user_id')->withTimestamps();
    }

}
