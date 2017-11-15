<?php
    ini_set('error_reporting', E_ALL);
    
	define('BOT_TOKEN', '385293774:AAHJ22xJWpeXn5yjQV9w0clruTzhxocVJO0'); 
	define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN. '/');
	
	// read incoming info and grab the chatID
	$update = json_decode(file_get_contents('php://input' ), true);

	$chat_id = $update["message"]["chat"]["id"];
	$message = $update["message"]["text"];
	$command = trim($message);
	
    switch($command) {
    	case '/new':    		
    		$reply = 'Howdy! Welcome to the AgerignaMuziqa. This is a new videos';    		
		$sendto = API_URL. "sendmessage?chat_id=". $chat_id. "&text=". $reply;
		file_get_contents($sendto);
		break;
	case '/weeklytop':    		
		$reply = 'Howdy! Welcome to the AgerignaMuziqa. This is a weekly top 10 videos';    		
		$sendto = API_URL. "sendmessage?chat_id=". $chat_id. "&text=". $reply;
		file_get_contents($sendto);
		break;
	default:
		$reply = 'Howdy! Welcome to the AgerignaMuziqa.';
		$sendto = API_URL. "sendmessage?chat_id=". $chat_id. "&text=". $reply;
		file_get_contents($sendto);
		break;
    }
?>
