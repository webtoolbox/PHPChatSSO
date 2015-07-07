<?php
require_once dirname(__FILE__).'/chat_room_sso_functions.php';
// Important Note:
// You also need to update the Website Toolbox chat room USERNAME on line 5 in chat_room_sso_functions.php.
// You also need to update the Website Toolbox chat room API Key on line 7 in chat_room_sso_functions.php.

// Your code to process the registration for the user on your website goes here.

// Fill in the user information in a way that the Website Toolbox chat room can understand.
$user = array();

// After successful registration to your website, assign the same user registration information to $user array to register at the Website Toolbox chat room.
// For example: You can assign your register POST/GET values to user array like below:
// $user['username'] = $_POST['username'].

// Assign username that's displayed on the Website Toolbox chat room
//$user['username'] = 'john';
// Assign email id for new registration
//$user['email'] = 'john.php@anonymous.com';	
// Assign password for new registration. This is optional parameter. 
//$user['password'] = 'john123';

$user['username'] = $_POST['username'];
$user['email'] = $_POST['email'];
$user['password'] = $_POST['password'];
$user['avatarUrl'] = $_POST['avatarUrl'];


// function called for registering a new user on the Website Toolbox chat room.
// Return user registeration status as boolean flag.
// true, if successfully registered
// false, if any error occurs.
$register_status = chatRoomSignup($user);
if($register_status) {
	// Redirect to your desired page since registeration was successful.
}
?>
