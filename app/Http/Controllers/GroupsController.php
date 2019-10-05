<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class GroupsController extends Controller
{
    public function store()
    {
    	$attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
    	]);

    	$group = auth()->user()->groups()->create($attributes);

    	return redirect($group->path());
    }

    public function show(Group $group)
    {
    	return view('groups.show', compact('group'));
    }

    public function join(Group $group)
    {
        $group->join(auth()->user());
    }
}
