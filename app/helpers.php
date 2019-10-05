<?php 

use App\User;
use App\Group;

/****************
*
* Here all the helper functions that u can use
*
*****************/

function gravatar($email, $size = 40) {
	$default = "http://www.moonparks.org/images/blank-user.jpg";
	
	return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
}


/**
* get all users except the signed in user, his friends, 
* the people who sent him a request and the people who received a request from him 
*/
function peopleYouMayKnow() {
	$friends = auth()->user()->friends()->pluck('friend_id')->toArray();
	$sent = auth()->user()->sentFriendRequests()->pluck('to_user_id')->toArray();
	$received = auth()->user()->receivedFriendRequests()->pluck('from_user_id')->toArray();
	$others = [auth()->id()];
	$except = array_merge($friends, $sent, $received, $others);
	return User::latest()->get()->except($except)->toArray();
}


function groupsYouMayJoin() {
	return Group::latest()->whereNotIn('user_id', [auth()->id()])->get()->toArray();		// we will need to except our groups 
}