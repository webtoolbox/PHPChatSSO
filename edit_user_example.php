<?php
require_once dirname(__FILE__).'/chat_room_sso_functions.php';
// Important Note:
// You also need to update the Website Toolbox chat room USERNAME on line 5 in chat_room_sso_functions.php.
// You also need to update the Website Toolbox chat room API Key on line 7 in chat_room_sso_functions.php.

// Your code to process the request to edit the details of the user on your website goes here.

// Fill in the user information in a way that the Website Toolbox chat room can understand.
$user = array();

// After successful update of user details on your website, assign the user information to $user array to update the details at the Website Toolbox chat room.
// For example: You can assign your POST/GET values to user array like below:
// $user['user'] = $_POST['user'].

// Assign email of the user, whose details have to be updated.
//$user['user'] = 'john@yahoo.com';
//Assign details needs to be set for the user. 
//$user['password'] = 'john123';

$user['user'] = $_POST['user'];
$user['username'] = $_POST['newUsername'];
$user['password'] = $_POST['newPassword'];
$user['email'] = $_POST['newEmail'];
$user['avatarUrl'] = $_POST['newAvatarUrl'];

// function called for editing the user details on the Website Toolbox chat room.
// Return the status as boolean flag.
// true, if successfully done.
// false, if any error occurs.
$edit_user_status = editChatRoomUserDetails($user);
if($edit_user_status) {
	// Redirect to your desired page since "edit user details" was successful.
}
?>
