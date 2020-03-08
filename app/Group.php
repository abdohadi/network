<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'description', 'cover'];

    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function path()
    {
    	return '/groups/'.$this->id;
    }

    public function join(User $user)
    {
    	$this->groupJoinRequests()->attach($user);
    }

    public function groupJoinRequests()
    {
    	return $this->belongsToMany(User::class, 'join_group_requests');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
