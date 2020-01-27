<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Post;

class Like extends Model
{
	protected $guarded = [];
	
	public function owner()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function post()
	{
		return $this->belongsTo(Post::class);
	}
}
