<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
	public function show(User $user)
	{
		return view('users.show', compact(['user']));
	}

	public function editInfo(User $user)
	{
		abort_if(auth()->user()->isNot($user), 403);

		return view('users.edit_info');
	}

	public function updateInfo(User $user)
	{
		$attributes = request()->validate([
			'name' => 'required|max:50',
			'email' => 'required|email|unique:users,email,' . $user->id,
			'address' => 'max:100',
			'phone' => 'max:50',
			'birth_date' => 'nullable|date',
			'gender' => 'max:10|in:male,female',
			'college' => 'max:50',
			'bio' => 'max:120'
		]);

		auth()->user()->update($attributes);

		session()->flash('success', 'Your info has been updated successfully');

		return ["redirect" => route('users.show', auth()->user())];
	}

	public function updatePicture(User $user)
	{
		request()->validate([
			'profile_picture' => 'mimes:jpeg,jpg,png,gif|required|max:2000'
		]);

		\Image::make(request()->profile_picture)
			->resize(300, null, function($constraint) {
				$constraint->aspectRatio();
			})
			->save(public_path('uploads/images/user_images/profile_pictures/' . request()->profile_picture->hashName()));

		auth()->user()->update([
			'profile_picture' => request()->profile_picture->hashName()
		]);

		return redirect(auth()->user()->path());
	}

	public function updateCover(User $user)
	{
		request()->validate([
			'profile_cover' => 'mimes:jpeg,jpg,png,gif|required|max:2000'
		]);

		\Image::make(request()->profile_cover)
			->resize(800, null, function($constraint) {
				$constraint->aspectRatio();
			})
			->save(public_path('uploads/images/user_images/covers/' . request()->profile_cover->hashName()));

		auth()->user()->profile_cover = request()->profile_cover->hashName();
		auth()->user()->save();

		return redirect(auth()->user()->path());
	}

	public function destroy()
	{
		
	}
}
