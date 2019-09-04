<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
	public function create()
	{
		return view('posts.create');
	}

	public function store()
	{
		Post::create(request(['body']));
	}
}
