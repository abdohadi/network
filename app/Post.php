<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Like;
use App\Comment;

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

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function current_user_comments($comments)
    {
        return array_filter($comments->toArray(), function($comment) {
            return $comment['user_id'] == auth()->id();
        });
    }

    public function latestComments($limit = null)
    {
        if ($limit) {
            return $this->comments()->limit($limit)->get();
        }

        return $this->comments()->get();
    }

    public function addComment($attributes)
    {
        return $this->comments()->create(array_merge(['user_id' => auth()->id()], $attributes));
    }
}
