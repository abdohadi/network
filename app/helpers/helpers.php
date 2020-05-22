<?php 

use App\User;
use App\Group;

/*****************
 *
 * Here all the helper functions that u can use
 *
 *****************/

/**
 * Get user's profile picture
 * 
 * @param User $user
 * @return String
 */
function getProfilePicture($user, $size = 40)
{
	return '/uploads/images/user_images/profile_pictures/' . (is_array($user) ? $user['profile_picture'] : $user->profile_picture);

	// $email = is_array($user) ? $user['email'] : $user->email;

	// return gravatar($email, $size);
}

/**
 * Get the gravatar
 *
 * @param String $email
 * @param int $size
 * @return string
 */
function gravatar($email, $size) 
{
	return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
}


/**
 * get all users except the signed in user, his friends, 
 * the people who sent him a request and the people who received a request from him 
 *
 * @return array
 */
function peopleYouMayKnow() 
{
	$friends = auth()->user()->friends()->pluck('friend_id')->toArray();
	$sent = auth()->user()->sentFriendRequests()->pluck('to_user_id')->toArray();
	$received = auth()->user()->receivedFriendRequests()->pluck('from_user_id')->toArray();
	$others = [auth()->id()];
	$except = array_merge($friends, $sent, $received, $others);

	return User::latest()->get()->except($except)->toArray();
}

/**
 * Get all groups except ours and those we are members of 
 *
 * @return array
 */
function suggestedGroups(int $count) 
{
	$except = array_merge(
			auth()->user()->ownedGroups->pluck('id')->toArray(), 
			auth()->user()->joinedGroups->pluck('id')->toArray(), 
			auth()->user()->requestedGroups->pluck('id')->toArray()
		);

	$groups = Group::latest()
				->whereNotIn('id', $except)
				->get()
				->toArray();	

	return array_slice($groups, 0, $count);	
}


/**
 * Get localized URL
 * If current locale is en, it returns `/en/url`
 *
 * @param String $url
 * @return String
 */
function localizeURL($url) 
{
	return \LaravelLocalization::localizeURL($url);
}