<?php

namespace App;

use App\Like;
use App\User;
use App\Group;
use App\Comment;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use likeablity;
    
    protected $fillable = ['group_id', 'body'];

    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function path()
    {
    	return route('posts.show', $this);
    }

    public function likes()
    {
    	return $this->morphMany(Like::class, 'likeable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
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

    public function basePosts()
    {
        return $this->hasMany(Post::class, 'shared_post_id');
    }

    public function sharedPost()
    {
        return $this->belongsTo(Post::class);
    }

    public function isSharing()
    {
        return !! $this->sharedPost()->count();
    }

    public function addComment($attributes)
    {
        return $this->comments()->create(array_merge(['user_id' => auth()->id()], $attributes));
    }

    public function sharePost(Post $shared_post)
    {
        $this->sharedPost()->associate($shared_post);

        $this->save();
    }
}
