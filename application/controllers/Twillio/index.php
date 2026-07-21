<?php
if (!defined("ROOT_PATH")) {
    define("ROOT_PATH", dirname(__DIR__, 3) . '/');
}
require_once ROOT_PATH . 'application/config/config.php';
require __DIR__ . '/vendor/autoload.php';
use Twilio\Rest\Client;

$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
$client = new Client($sid, $token);



//$twilio_number = "+15017122661";


$message = $client->messages->create(
    // Where to send a text message (your cell phone?)
    '+917017618292',
    array(
        'from' => '+18592377620',
        'body' => 'hi londo msg aa gaya '
    )
);

   if($message){
	   echo 'hey';
   }else{
	   echo 'kuch ni';
   }
