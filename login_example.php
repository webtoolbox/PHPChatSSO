<?php
require_once dirname(__FILE__).'/chat_room_sso_functions.php';
// Important Note:
// You also need to update the Website Toolbox chat room username on line 5 in chat_room_sso_functions.php.
// You also need to update the Website Toolbox chat room API Key on line 7 in chat_room_sso_functions.php.

// Your code to process the login for the user on your website goes here.

// Fill in the user information in a way that the Website Toolbox chat room can understand.
$user = array();
// After successful login to your website, assign the username and email in user array. 
// The email address is a mandatory field for login.
//$user['email'] = 'john.php@anonymous.com';
// The username and password are optional parameters that will only be used if the account needs to be created because it doesn't already exist.
//$user['username'] = 'john';
//$user['password'] = 'john123';
// Assign avatarUrl (profile picture URL), if you want to set the Website Toolbox chat room profile picture same as your application. This image will be shown on the Website Toolbox chat room, if user has not set his/her avatar yet on the chat room. This is optional parameter. 
//$user['avatarUrl'] = 'http://fc09.deviantart.net/fs71/f/2010/330/9/e/profile_icon_by_art311-d33mwsf.png';

$user['username'] = $_POST['username'];
$user['email'] = $_POST['email'];
$user['password'] = $_POST['password'];
$user['avatarUrl'] = $_POST['avatarUrl'];
$user['rememberMe'] = $_POST['rememberMe'];
// The function will print an IMG tag to get login on the Website Toolbox chat room.
// You can also get access_token $_SESSION['access_token'] that can be further used for hiding "login" page after successful login and displaying "logout" page on your website.
// The function will return login status as boolean flag.
// true, if successfully logged in.
// false, if any error occurs.
$login_status = chatRoomLogin($user);
if($login_status) {
	// Redirect to secure members-only area since login was successful.
}
?>
