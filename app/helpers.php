<?php 

use App\User;

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
	return User::latest()->get();
}