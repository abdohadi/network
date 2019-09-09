<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();

        $users = peopleYouMayKnow();

        return view('home', compact(['posts', 'users']));
    }
}
