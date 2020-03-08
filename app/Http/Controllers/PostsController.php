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
		return view('posts.show', compact('post'));
	}

	public function store()
	{
		$attributes = request()->validate([
			'body' => 'required'
		]);

		$post = auth()->user()->posts()->create($attributes);

		return ['redirect' => $post->path()];
	}

	public function update(Post $post)
	{
		$this->authorize('update', $post);

		$attributes = request()->validate([
			'body' => 'required'
		]);

		$post->update($attributes);

		return ['redirect' => $post->path()];
	}

	public function destroy(Post $post)
	{
		$this->authorize('update', $post);

		$post->delete();

		return redirect('/');
	}

	public function liked(Post $post)
	{
		return $post->toggleLike();
	}
}
