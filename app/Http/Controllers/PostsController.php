<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;

class PostsController extends Controller
{

	public function show(Post $post)
	{
		$users = peopleYouMayKnow();

		return view('posts.show', compact(['post', 'users']));
	}

	public function store()
	{
		$attributes = request()->validate([
			'body' => 'required'
		]);

		auth()->user()->posts()->create($attributes);

		return redirect('/');
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
}
