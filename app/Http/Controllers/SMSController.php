<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \Psr\Http\Message\ServerRequestInterface as SMSRequest;
use \Psr\Http\Message\ResponseInterface as SMSResponse;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class SMSController extends Controller
{
	
	/*
	public $phone;
	public $text;
	
     public function __construct($phone ,$text)
    {
    	$this->phone = $phone;
    	$this->text = $text;
    	
    }
	*/
    public function sendSmsNotification()
    {
       $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
        $client = new Client($basic);

        $response = $client->sms()->send(
			    new \Vonage\SMS\Message\SMS($this->phone, env('VONAGE_FROM'), $this->text)
			);

			$message = $response->current();

			if ($message->getStatus() == 0) {
			    echo "The message was sent successfully\n";
			} else {
			    echo "The message failed with status: " . $message->getStatus() . "\n";
			}
		
	
    }
    /*
    public function delivery()
    {
    $app = new \Slim\App; 	
    	
    $handler = function (SMSRequest $request, SMSResponse $response) {
    $receipt = \Vonage\SMS\Webhook\Factory::createFromRequest($request);

    error_log(print_r($receipt, true));

    return $response->withStatus(204);
	};

	$app->map(['GET', 'POST'], '/webhooks/delivery-receipt', $handler);

	$app->run();
    	
    }*/
    
    public function inbound()
    {
    	try {
		    $inbound = \Vonage\SMS\Webhook\Factory::createFromGlobals();
		    error_log($inbound->getText());
		} catch (\InvalidArgumentException $e) {
		    error_log('invalid message');
		}
    	
    	
    }
    
    
}
