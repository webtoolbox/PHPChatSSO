<?php
require_once dirname(__FILE__).'/chat_room_sso_functions.php';
// Important Note:
// You also need to update the Website Toolbox chat room USERNAME on line 5 in chat_room_sso_functions.php.
// You also need to update the Website Toolbox chat room API Key on line 7 in chat_room_sso_functions.php.

// Your code to process the user deletion on your website goes here.

// Fill in the user information in a way that the Website Toolbox chat room can understand.
$user = array();

// After successful deletion on your website, assign the user information to $user array to delete the user from the Website Toolbox chat room.
// For example: You can assign your POST/GET values to user array like below:
// $user['emails'] = $_POST['emails'].
$user['emails'] = $_POST['emails'];
// Assign comma (,) seperated emails of multiple users, who need to be deleted.
//$user['emails'] = 'john@yahoo.com,mark@gmail.com,aryan@hotmail.com';

// function called for deleting users from the Website Toolbox chat room.
// Return the response status as boolean flag.
// true, if successfully done.
// false, if any error occurs.
$deletion_status = userDeletionFromChatRoom($user);
if($deletion_status) {
	// Redirect to your desired page after "user(s) deletion" was successful.
}
?>
