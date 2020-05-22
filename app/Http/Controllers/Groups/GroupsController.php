<?php

namespace App\Http\Controllers\Groups;

use App\User;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupsController extends Controller
{
    public function store()
    {
    	$attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
    	]);

        $attributes['user_id'] = auth()->id();

    	$group = Group::create($attributes);

        $group->addMember(auth()->user());
        $group->assignAdmin(auth()->user());

    	return redirect($group->path());
    }

    public function show(Group $group)
    {
    	return view('groups.show', compact('group'));
    }

    public function update(Group $group)
    {
        abort_if(auth()->user()->isNot($group->owner), 403);

        $group->fill(request([
            'name', 
            'description'
        ]));

        if ($group->isDirty()) {
            $group->save();
        }

        return ['redirect' => $group->path()];
    }

    public function destroy(Group $group)
    {
        abort_if(auth()->user()->isNot($group->owner), 403);

        $group->delete();

        return redirect('/');
    }
}
