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
		$attributes = request()->validate([
			'body' => 'required'
		]);

		$post->update($attributes);

		return redirect('/');
	}
}
