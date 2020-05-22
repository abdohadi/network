<?php

namespace App\Http\Controllers\Posts;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Like;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
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

		$post->update(request()->only('body'));

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

	public function shared(Post $post)
	{
		$shared_post = $post;

		$post = auth()->user()->posts()->create(request()->only('body'));

		$post->sharePost($shared_post);

		return redirect(localizeURL($post->path()));
	}
}
