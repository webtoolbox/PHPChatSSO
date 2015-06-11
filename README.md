# PHPChatSSO
Contains client files for integrating Single Sign On and Single Registration in PHP with a [`Website Toolbox Chat Room`](http://www.websitetoolbox.com/chat_room/index.html).
The following files are included in this repo:

* [`chat_room_sso_functions.php`](https://github.com/webtoolbox/PHPChatSSO/blob/master/chat_room_sso_functions.php)
  This is the main file you need. You don't need any other file in your project. You just need to give your chat room address and API Key at the top of the script. Then you can drop this file anywhere that you can access it on your site. 
* [`registration_example.php`](https://github.com/webtoolbox/PHPChatSSO/blob/master/registration_example.php)
  This file offers an example usage for user registration. You can customize this page or start from scratch.
* [`login_example.php`](https://github.com/webtoolbox/PHPChatSSO/blob/master/login_example.php)
  This file offers an example usage for SSO login. You can customize this page or start from scratch.
* [`logout_example.php`](https://github.com/webtoolbox/PHPChatSSO/blob/master/logout_example.php)
  This file offers an example usage for SSO logout. You can customize this page or start from scratch.
* [`userDeletion_example.php`](https://github.com/webtoolbox/PHPChatSSO/blob/master/userDeletion_example.php)
  This file offers an example usage for user deletion via SSO API. You can customize this page or start from scratch.
* [`edit_user_example.php`](https://github.com/webtoolbox/PHPChatSSO/blob/master/edit_user_example.php)
  This file offers an example usage for editing the details of the chat room user via SSO API. You can customize this page or start from scratch.
* [`index.html`](https://github.com/webtoolbox/PHPChatSSO/blob/master/index.html)
  This file offers a very basic user interface to make HTTP requests for login, user registration, user deletion and edit user details. You can customize this page or start from scratch.  

This example uses [`cURL`](http://php.net/manual/en/book.curl.php) to make HTTP requests. Most servers have cURL pre-installed. If you don't have the cURL php extension installed on your server, you can [`install it`](http://php.net/manual/en/curl.installation.php) or use a different method to make HTTP requests.  
