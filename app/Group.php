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
    	$this->members()->attach($user);
    }

    public function members()
    {
    	return $this->belongsToMany(User::class, 'group_members');
    }
}
