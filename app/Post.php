<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Like;

class Post extends Model
{
    protected $fillable = ['body'];

    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function path()
    {
    	return '/posts/'.$this->id;
    }

    public function likes()
    {
    	return $this->hasMany(Like::class);
    }
}
