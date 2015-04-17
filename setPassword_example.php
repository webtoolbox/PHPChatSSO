<?php
require_once dirname(__FILE__).'/chat_room_sso_functions.php';
// Important Note:
// You also need to update the Website Toolbox chat room USERNAME on line 5 in chat_room_sso_functions.php.
// You also need to update the Website Toolbox chat room API Key on line 7 in chat_room_sso_functions.php.

// Your code to process the request to set password for the user on your website goes here.

// Fill in the user information in a way that the Website Toolbox chat room can understand.
$user = array();

// After successful password updation on your website, assign the user information to $user array to set the password at the Website Toolbox chat room.
// For example: You can assign your POST/GET values to user array like below:
// $user['user'] = $_POST['user'].

// Assign username, for which the password has to be set.
//$user['user'] = 'john';
//You can also set password using user's email address. For example: $user['user'] = 'john@gmail.com';
//Assign password needs to be set for the user. 
//$user['password'] = 'john123';

$user['user'] = $_POST['username'];
$user['password'] = $_POST['password'];

// function called for setting the password on the Website Toolbox chat room.
// Return the status as boolean flag.
// true, if successfully done.
// false, if any error occurs.
$set_password_status = chatRoomSetPassword($user);
if($set_password_status) {
	// Redirect to your desired page since "set password" was successful.
}
?>
