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
    	return $this->belongsToMany(User::class, 'group_join_requests');
    }
}
