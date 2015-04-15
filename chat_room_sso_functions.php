<?php
# This file contains functions for the chat room single sign on.

# Replace USERNAME with your chat room username.
define("HOST","USERNAME.discussionchatroom.com");
# Get The API Key from the Settings -> Single Sign On section of the Website Toolbox chat room admin area and replace APIKEY.
define("API_KEY","APIKEY");

# Initializing session if it is not started in client project files to assign SSO login access_token into $_SESSION['access_token']. The $_SESSION['access_token'] is used in chatRoomLogout function to logout from the chat room.
# Checking current session status if it does not exist in client project files then session will be started.
if (!$_SESSION) {session_start();}

#Purpose: Function for registering a new user on the chat room. 
#parmeter: Param $user an array containing information about the new user. The array user will contain mandatory values (username and email) which will be used to build URL query string to register a new user on the chat room. The array $user can also contain optional value such as password.
# URL with all parameter from $user array passed in doHTTPCall function to create a request using curl or file and getting response from the chat room.
#return: Parse and return user registration response status.

function chatRoomSignup($user) {
	# Changes the case of all keys in an array
	$user = array_change_key_case($user);	
	foreach ($user as $key => $value) {
	  if ($value === NULL)
		 $user[$key] = '';
	}
	# Generating a URL-encoded query string from the $user array.	
	$parameters = http_build_query($user, NULL, '&');   
	$URL = "/sso/user/register?apikey=".API_KEY."&".$parameters;
	# making a request using curl or file and getting response from the chat room.
	$response = doHTTPCall($URL);
	$response_json = json_decode($response, true);
	echo $response_json['message'];
	# returning sso register response
	return $response_json['success'];		  
}

#Purpose: Function for deleting user(s) from the chat room. 
#parmeter: Param $user an array containing information about users, need to be deleted. The array user will contain comma seperated username or email, which will be used to build URL query string to delete user(s) from the chat room. # URL with all parameter from $user array passed in doHTTPCall function to create a request using curl or file and getting response from the chat room.
#return: Parse and return user deletion response status. 
function userDeletionFromChatRoom($user) {
	# Changes the case of all keys in an array
	$user = array_change_key_case($user);	
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
	echo $response_json['message'];
	# returning sso register response
	return $response_json['success'];		  
}

function chatRoomSetPassword($user) {
	# Changes the case of all keys in an array
	$user = array_change_key_case($user);	
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
	echo $response_json['message'];
	# returning sso register response
	return $response_json['success'];		  
}

# Purpose: function for login to the chat room. If email does not exist in the chat room, then the user is auto-regisered on chat room.
# parmeter: Param $user an array containing information about the currently logged in user. The array user will contain mandatory (username and email) value which passed with apikey in request URL.
# URL with user and apikey parameter passed in doHTTPCall function to create a request using curl or file and return access_token from the chat room.
# Assigned access_token into $_SESSION['access_token'].  
# The returned access_token is checked for null. If it's not null then loaded with "sso/token/login?access_token" url through IMG src to login to the chat room.
# return: Returns user's login status as true or false from the chat room.
function chatRoomLogin($user) {
	# Changes the case of all keys in an array
	$user = array_change_key_case($user);	
	foreach ($user as $key => $value) {
	  if ($value === NULL)
		 $user[$key] = '';
	}
	# Generating a URL-encoded query string from the $user array.	
	$login_parameters = http_build_query($user, NULL, '&');
	# user details stored in session which will used later in chatRoomLogout function. 
	$_SESSION['login_parameters'] = $login_parameters;
	$URL = "/sso/token/generate?apikey=".API_KEY."&".$login_parameters;
	# making a request using curl or file and getting response from the chat room.
	$response = doHTTPCall($URL);
	$response_json = json_decode($response, true);
	$response_message = $response_json['message'];
	$access_token = $response_json['access_token'];
	echo $response_message;
	# Check access_token for null. If access_token not null then load with "sso/token/login?access_token" url through IMG src to login to the chat room.
	if ($access_token) {
		$_SESSION['access_token'] = $access_token;
		echo "<img src='http://".HOST."/sso/token/login?access_token=$access_token' border='0' width='1' height='1' alt=''>";
	} 
	return $response_json['success']; 	
}
#Purpose: function for log out from the chat room.
# It check for $_SESSION['access_token'] if it's not null then the "sso/token/logout?access_token" is loaded with IMG src to logout user from the chat room.
# Reset access_token session variable $_SESSION['access_token'] after successful log out.
# return: the function will return log out status message as true or false from the chat room.
function chatRoomLogout() {
	# Check for access_token value. If it is not null then load /sso/token/logout?access_token url through IMG src to log out from the chat room.
	if($_SESSION['access_token']) {
		echo "<img src='http://".HOST."/sso/token/logout?access_token=".$_SESSION['access_token']."' border='0' width='1' height='1' alt=''>";
		# Reset access_token session variable after log out.
		$_SESSION['access_token'] = '';
		return true;	
	} else {
		# If access_token is missing from session variable then making a HTTP request using curl and getting access_token from the chat room. 
		# Passing user details via $_SESSION['login_parameters'] which stored in session during user login.
		# If access_token not null then the "register/logout?authtoken" is loaded with IMG src to logout user from the chat room and return log out status message as true
		# If access_token returned as null then appropriate error message will be returned. 
		$URL = "/sso/token/getToken?apikey=".API_KEY."&".$_SESSION['login_parameters'];
		$response = doHTTPCall($URL);
		$response_json = json_decode($response, true);
		$response_message = $response_json['message'];
		$access_token = $response_json['access_token'];
		echo $response_message;
		if($authtoken) {
			echo "<img src='http://".HOST."/sso/token/logout?access_token=".$access_token."' border='0' width='1' height='1' alt=''>";
		} 
		return $response_json['success'];
	}	
}



#Purpose: Create a request using curl or file and getting response from the chat room.
#parmeter: request URL which will use to make curl request to the chat room.
#return: return response from the chat room.
function doHTTPCall($URL){
	if (_checkBasicFunctions("curl_init,curl_setopt,curl_exec,curl_close")) {
		echo "invoking URL\n";
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
