<?php
    ini_set('error_reporting', E_ALL);
    
	define('BOT_TOKEN', '385293774:AAHJ22xJWpeXn5yjQV9w0clruTzhxocVJO0'); 
	define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN. '/');
	
	function apiRequestJson($method, $parameters) {
		if (!is_string($method)) {
			error_log("Method name must be a string\n");
		    return false;
		}

		if (!$parameters) {
		    $parameters = array();
		} else if (!is_array($parameters)) {
		    error_log("Parameters must be an array\n");
		    return false;
		}

		foreach ($parameters as $key => &$val) {
	    	// encoding to JSON array parameters, for example reply_markup
	    	if (!is_numeric($val) && !is_string($val)) {
	      		$val = json_encode($val);
	    	}
	  	}
	  	
	  	$url = API_URL. $method. '?'. http_build_query($parameters);

	  	$ch = curl_init($url);
	  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	  	curl_setopt($ch, CURLOPT_TIMEOUT, 60);

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

	    $response = json_decode($response, TRUE);
	    if($http_code != 200){
	        echo "Request has failed with error {$response['error_code']}: {$response['description']}\n";
	        if ($http_code == 401) {
	            throw new \Exception('Invalid access token provided');
	        }
	        return FALSE;
	    }else {
	        // $response = $response['result'];
	        $response = json_decode($response, true);
    		if (isset($response['description'])) {
      			error_log("Request was successfull: {$response['description']}\n");
    		}
    		$response = $response['result'];
	    }
	    return $response;
	}

    // read incoming info and grab the chatID
	$update = json_decode(file_get_contents('php://input' ), true);

	$chat_id = $update["message"]["chat"]["id"];
	$message = $update["message"]["text"];
	$command = trim($message);
	
    switch($command) {
    	case '/new':    		
    		$reply = 'Howdy! Welcome to the AgerignaMuziqa. This is a new videos';    		
		apiRequest("sendmessage", array('chat_id' => $chat_id, "text" => $reply));
		break;
	case '/weeklytop':    		
		$reply = 'Howdy! Welcome to the AgerignaMuziqa. This is a weekly top 10 videos';    		
		apiRequest("sendmessage", array('chat_id' => $chat_id, "text" => $reply));
		break;
	default:
		$reply = 'Howdy! Welcome to the AgerignaMuziqa.';
		apiRequest("sendmessage", array('chat_id' => $chat_id, "text" => $reply));
		break;
    }
?>
