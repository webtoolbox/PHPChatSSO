<?php
require_once dirname(__FILE__).'/chat_room_sso_functions.php';

// Your code to process the logout for the user on your website goes here.

// Function call for logout from the the Website Toolbox chat room. This function will be called after successful user logout from your website.
// The function will print an IMG tag to get logout from the Website Toolbox chat room.
// Return logout status as boolean flag.
// true, if successfully logged out.
// false, if any error occurs.
$logout_status = chatRoomLogout();
if($logout_status) {
	// Redirect to your desired page since logout was successful.
}
?>
