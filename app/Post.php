<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

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
}
