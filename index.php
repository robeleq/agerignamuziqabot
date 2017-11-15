<?php
    ini_set('error_reporting', E_ALL);
    
	define('BOT_TOKEN', '385293774:AAHJ22xJWpeXn5yjQV9w0clruTzhxocVJO0'); 
	define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN. '/');
	define('API_URL_ENDPOINT', 'http://www.agerignamuziqa.com/api/v1/');

	function apiRequestJson($method) {
	   if (!is_string($method)) {
		error_log("Method name must be a string\n");
	    	return false;
	   }

	   $headers = array(
	   	'Accept: application/json',
	    	'Content-type: application/json',
	    	'X-API-KEY: NjEyZTY0OGJmOTU5NGFkYjUwODQ0Y2FkNjg5NWYyY2Y=',
	   );

	   $url = API_URL_ENDPOINT. $method;

	   $ch = curl_init($url);
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	   curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	   $response = curl_exec($ch);

	   if ($response === false) {
		$errno = curl_errno($ch);
		$error = curl_error($ch);
		echo "Curl returned error $errno: $error\n";
		curl_close($ch);
	   	return FALSE;
	   }

	   $http_code = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
           curl_close($ch);
	   echo $response;
	}
	
	// read incoming info and grab the chatID
	$update = json_decode(file_get_contents('php://input' ), true);

	$chat_id = $update["message"]["chat"]["id"];
	$message = $update["message"]["text"];
	$command = trim($message);
	
    switch($command) {
    	case '/new':    		
    		$reply = apiRequestJson('tags');    		
		$sendto = API_URL. "sendmessage?chat_id=". $chat_id. "&text=". $reply;
		file_get_contents($sendto);
		break;
	case '/weeklytop':    		
		$reply = 'Howdy! Welcome to the AgerignaMuziqa. This is a weekly top 10 videos';    		
		$sendto = API_URL. "sendmessage?chat_id=". $chat_id. "&text=". $reply;
		file_get_contents($sendto);
		break;
	case '/tags':    		
    		$reply = apiRequestJson('tags');    		
		$sendto = API_URL. "sendmessage?chat_id=". $chat_id. "&text=". $reply;
		file_get_contents($sendto);
	default:
		$reply = 'Howdy! Welcome to the AgerignaMuziqa.';
		$sendto = API_URL. "sendmessage?chat_id=". $chat_id. "&text=". $reply;
		file_get_contents($sendto);
		break;
    }
?>
