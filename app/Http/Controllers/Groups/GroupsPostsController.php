<?php

namespace App\Http\Controllers\Groups;

use App\Post;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupsPostsController extends Controller
{
	public function __construct()
	{
		$this->middleware('can:create-post,group');
		$this->middleware('can:manage,post')->except('store');
	}

    public function store(Group $group)
    {
    	$attributes = request()->validate([
			'body' => 'required'
		]);

		$attributes['group_id'] = $group->id;

		auth()->user()->posts()->create($attributes);

        return redirect(route('groups.show', $group));
    }

    public function update(Group $group, Post $post)
    {
    	$attributes = request()->validate([
			'body' => 'required'
		]);

    	$post->update($attributes);
    }

    public function destroy(Group $group, Post $post)
    {
    	$post->delete();
    }
}
