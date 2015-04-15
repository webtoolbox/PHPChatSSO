<?php
require_once dirname(__FILE__).'/chat_room_sso_functions.php';
// Important Note:
// You also need to update chat room username on line 5 in chat_room_sso_functions.php.
// You also need to update chat room API Key on line 7 in chat_room_sso_functions.php.

// Your code to process the login for the user on your website goes here.

// Fill in the user information in a way that chat room can understand.
$user = array();
// After successful login to your website, assign the username and email in user array. 
//Here, the username and email both are required. Because, chat room provide auto registration feature while login, if user is not already registered at chat room.
$user['username'] = 'john';
$user['email'] = 'john.php@anonymous.com';	
// Assign avatarUrl (profile picture URL), if you want to set chat room profile picture same as your application. This image will be shown on chat room, if user has not set his/her avatar on chat room yet. This is optional parameter. 
$user['avatarUrl'] = 'http://fc09.deviantart.net/fs71/f/2010/330/9/e/profile_icon_by_art311-d33mwsf.png';

// The function will print an IMG tag to get login on websitetoolbox forum.
// You can also get access_token $_SESSION['access_token'] that can be further used for hiding "login" page after successful login and displaying "logout" page on your website.
// The function will return login status as boolean flag.
// true, if successfully logged in.
// false, if any error occurs.
$login_status = chatRoomLogin($user);
if($login_status) {
	// Redirect to secure members-only area since login was successful.
}
?>
