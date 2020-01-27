<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Like;

class PostsController extends Controller
{
	public function index()
	{
		abort(404);
	}

	public function show(Post $post)
	{
		$users = peopleYouMayKnow();

    	$groups = groupsYouMayJoin();

		return view('posts.show', compact(['post', 'users', 'groups']));
	}

	public function store()
	{
		$attributes = request()->validate([
			'body' => 'required'
		]);

		$post = auth()->user()->posts()->create($attributes);

		return redirect($post->path());
	}

	public function update(Post $post)
	{
		$this->authorize('update', $post);

		$attributes = request()->validate([
			'body' => 'required'
		]);

		$post->update($attributes);

		return back();
	}

	public function destroy(Post $post)
	{
		$this->authorize('update', $post);

		$post->delete();

		return redirect('/');
	}

	public function liked(Post $post)
	{
		$like = Like::where('user_id', auth()->id())->where('post_id', $post->id)->first();

		if (! $like) { 
			// if the logged in user didn't like this post yet
			auth()->user()->likes()->create(['post_id' => $post->id]);
		} else {
			// if the logged in user liked this post before
			$like->delete();
		}

		return $post->likes->count();
	}
}
