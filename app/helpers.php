<?php 

use App\User;
use App\Group;

/****************
*
* Here all the helper functions that u can use
*
*****************/

function gravatar($email, $size = 40) {
	$default = "http://icons.iconarchive.com/icons/hopstarter/halloween-avatars/256/Zombie-icon.png";
	
	return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
}


function peopleYouMayKnow() {
	return User::latest()->get()->except([auth()->id()]);
}


function groupsYouMayJoin() {
	return Group::latest()->whereNotIn('user_id', [auth()->id()])->get();		// we will need to except our groups 
}