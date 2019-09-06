<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
	public function index()
	{
		$posts = Post::latest()->get();

		return view('posts.index', compact('posts'));
	}

	public function show(Post $post)
	{
		return view('posts.show', compact(['post']));
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

		return redirect('/');
	}

	public function destroy(Post $post)
	{
		$this->authorize('update', $post);

		$post->delete();

		return redirect('/');
	}
}
