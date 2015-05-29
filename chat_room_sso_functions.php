<?php
# This file contains functions for the Website Toolbox chat room single sign on.

# Replace USERNAME with your chat room username.
define("HOST","USERNAME.discussionchatroom.com");
# Get The API Key from the Settings -> Single Sign On section of the Website Toolbox chat room admin area and replace APIKEY.
define("API_KEY","APIKEY");

# Initializing session if it is not started in client project files to assign SSO login access_token into $_SESSION['access_token']. The $_SESSION['access_token'] is used in chatRoomLogout function to logout from the Website Toolbox chat room.
# Checking current session status if it does not exist in client project files then session will be started.
if (!$_SESSION) {session_start();}

#Purpose: Function for registering a new user on the Website Toolbox chat room. 
#parmeter: Param $user an array containing information about the new user. The array user will contain mandatory values (username and email) which will be used to build URL query string to register a new user on the Website Toolbox chat room. The array $user can also contain optional value such as password.
# URL with all parameter from $user array passed in doHTTPCall function to create a request using curl or file and getting response from the Website Toolbox chat room.
#return: Parse and return user registration response status.

function chatRoomSignup($user) {
	foreach ($user as $key => $value) {
	  if ($value === NULL)
		 $user[$key] = '';
	}
	# Generating a URL-encoded query string from the $user array.	
	$parameters = http_build_query($user, NULL, '&');   
	$URL = "/sso/user/register?apikey=".API_KEY."&".$parameters;
	# making a request using curl or file and getting response from the Website Toolbox chat room.
	$response = doHTTPCall($URL);
	$response_json = json_decode($response, true);
	# returning sso register response
	return $response_json['success'];		  
}

# Purpose: function for login to the Website Toolbox chat room. If given email does not exist, then the user is auto-regisered on the Website Toolbox chat room.
# parmeter: Param $user an array containing information about the currently logged in user. The array user will contain mandatory (username and email) value which passed with apikey in request URL.
# URL with user and apikey parameter passed in doHTTPCall function to create a request using curl or file and return access_token from the Website Toolbox chat room.
# Assigned access_token into $_SESSION['access_token'].  
# The returned access_token is checked for null. If it's not null then loaded with "sso/token/login?access_token" url through IMG src to login to the Website Toolbox chat room.
# return: Returns user's login status as true or false.
function chatRoomLogin($user) {
	foreach ($user as $key => $value) {
	  if ($value === NULL)
		 $user[$key] = '';
	}
	# Generating a URL-encoded query string from the $user array.	
	$login_parameters = http_build_query($user, NULL, '&');
	# user details stored in session which will used later in chatRoomLogout function. 
	$_SESSION['login_parameters'] = $login_parameters;
	$URL = "/sso/token/generate?apikey=".API_KEY."&".$login_parameters;
	# making a request using curl or file and getting response from the Website Toolbox chat room.
	$response = doHTTPCall($URL);
	$response_json = json_decode($response, true);
	$access_token = $response_json['access_token'];
	# Check access_token for null. If access_token not null then load with "sso/token/login?access_token" url through IMG src to login to the Website Toolbox chat room.
	if ($access_token) {
		$_SESSION['access_token'] = $access_token;
		$avatarUrl = $user['avatarUrl'];
		$rememberMe = $user['rememberMe'];
		echo "<br/><img src='http://".HOST."/sso/token/login?access_token=$access_token&avatarUrl=$avatarUrl&rememberMe=$rememberMe' border='0' width='1' height='1' alt=''/><a href='http://".HOST."/chatroom'>CHATROOM</a><br/><a href='logout_example.php'>LOGOUT</a>";
		//echo "<a href='http://".HOST."/chatroom'>CHATROOM</a>";
	} 
	return $response_json['success']; 	
}

#Purpose: function for log out from the Website Toolbox chat room.
# It check for $_SESSION['access_token'] if it's not null then the "sso/token/logout?access_token" is loaded with IMG src to logout user from the Website Toolbox chat room.
# Reset access_token session variable $_SESSION['access_token'] to blank after successful log out.
# return: the function will return log out status as true or false.
function chatRoomLogout() {
	# Check for access_token value. If it is not null then load /sso/token/logout?access_token url through IMG src to log out from the Website Toolbox chat room.
	if($_SESSION['access_token']) {
		echo "<img src='http://".HOST."/sso/token/logout?access_token=".$_SESSION['access_token']."' border='0' width='1' height='1' alt=''>";
		# Reset access_token session variable after log out.
		$_SESSION['access_token'] = '';
		return true;	
	} else {
		# If access_token is missing from session variable then making a HTTP request using curl and getting access_token from the Website Toolbox chat room. 
		# Fetching user details from $_SESSION['login_parameters'], which was stored in session during user login.
		# If access_token not null then the "/sso/token/logout?access_token" is loaded with IMG src to logout user from the Website Toolbox chat room. 
		$URL = "/sso/token/getToken?apikey=".API_KEY."&".$_SESSION['login_parameters'];
		$response = doHTTPCall($URL);
		$response_json = json_decode($response, true);
		$response_message = $response_json['message'];
		$access_token = $response_json['access_token'];
		if($access_token) {
			echo "<img src='http://".HOST."/sso/token/logout?access_token=".$access_token."' border='0' width='1' height='1' alt=''>";
		} 
		return $response_json['success'];
	}	
}

#Purpose: Function for deleting user(s) from the Website Toolbox chat room. 
#parmeter: Param $user an array containing information about users, who need to be deleted. The array user will contain comma seperated username or email, which will be used to build URL query string to delete user(s) from the Website Toolbox chat room. 
#URL with all parameter from $user array passed in doHTTPCall function to create a request using curl or file and getting response from the Website Toolbox chat room.
#return: Parse and return user deletion response status. 
function userDeletionFromChatRoom($user) {
	foreach ($user as $key => $value) {
	  if ($value === NULL)
		 $user[$key] = '';
	}
	# Generating a URL-encoded query string from the $user array.	
	$parameters = http_build_query($user, NULL, '&');   
	$URL = "/sso/user/delete?apikey=".API_KEY."&".$parameters;
	# making a request using curl or file and getting response from the Website Toolbox.
	$response = doHTTPCall($URL);
	$response_json = json_decode($response, true);
	# returning sso register response
	return $response_json['success'];		  
}

#Purpose: Function for setting the password of the user for the Website Toolbox chat room. This password can be used by the user for direct login to the Website Toolbox chat room. 
#parmeter: Param $user an array containing information about user. The array user will contain user's username/email and password, which will be used to build URL query string to set the password for the user at the Website Toolbox chat room. 
#URL with all parameter from $user array passed in doHTTPCall function to create a request using curl or file and getting response from the Website Toolbox chat room.
#return: Parse and return response status. 
function chatRoomSetPassword($user) {
	foreach ($user as $key => $value) {
	  if ($value === NULL)
		 $user[$key] = '';
	}
	# Generating a URL-encoded query string from the $user array.	
	$parameters = http_build_query($user, NULL, '&');   
	$URL = "/sso/user/setPassword?apikey=".API_KEY."&".$parameters;
	# making a request using curl or file and getting response from the Website Toolbox.
	$response = doHTTPCall($URL);
	$response_json = json_decode($response, true);
	# returning sso register response
	return $response_json['success'];		  
}


#Purpose: Create a request using curl or file and getting response from the Website Toolbox chat room.
#parmeter: request URL which will use to make curl request to the Website Toolbox chat room.
#return: return response from the Website Toolbox chat room.
function doHTTPCall($URL){
	if (_checkBasicFunctions("curl_init,curl_setopt,curl_exec,curl_close")) {
		$ch = curl_init("http://".HOST.$URL);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);      
		curl_close($ch);
	} else if (_checkBasicFunctions("fsockopen,fputs,feof,fread,fgets,fclose")) {
		$fsock = fsockopen(HOST, 80, $errno, $errstr, 30);
		if (!$fsock) {
			echo "Error! $errno - $errstr";
		} else {
			$headers .= "POST $URL HTTP/1.1\r\n";
			$headers .= "HOST: ".HOST."\r\n";
			$headers .= "Connection: close\r\n\r\n";
			fputs($fsock, $headers);
			// Needed to omit extra initial information
			$get_info = false;
			while (!feof($fsock)) {
				if ($get_info) {
					$response .= fread($fsock, 1024);
				} else {
					if (fgets($fsock, 1024) == "\r\n") {
						$get_info = true;
					}
				}
			}
			fclose($fsock);
		}
	}
	return $response;
}


#Purpose: Check php basic functions exist or not
#parmeter: Accept parameter functionslist with values such as  'fsockopen,fputs,feof,fread,fgets,fclose'
function _checkBasicFunctions($functionList) {
	$functions = split(",",$functionList);
	foreach ($functions as $key=>$val) {
		$function = trim($val);
		if (!function_exists($function)) {
			return false;
		}
	}
	return true;
} 
?>
