<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\Messages\Channel\WhatsApp\WhatsAppText;

class WhatsappController extends Controller
{
	
	
	
   public function message()
    {
        $jwt_token = env('VONAGE_JWT_TOKEN'); // Assurez-vous que votre token JWT est défini dans le fichier .env
        $TO_NUMBER = env('VONAGE_TO'); // Assurez-vous que le numéro de destination est correct

        $response = Http::withToken($jwt_token)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->post('https://messages-sandbox.nexmo.com/v1/messages', [
                'from' => '14157386102',
                'to' => $TO_NUMBER,
                'message_type' => 'text',
                'text' => 'This is a WhatsApp Message sent from the Messages API',
                'channel' => 'whatsapp',
            ]);

		if ($response->successful()) {
		    // Handle success
		    $data = $response->json();
		    // Do something with $data
		} else {
		    // Handle error
		    $error = $response->json();
		    dd($error);// Do something with $error
		}
	/*
		$basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
        $client = new Client($basic);

        $TO_NUMBER = env('VONAGE_TO'); // Assurez-vous que le numéro de destination est correct
        $FROM_NUMBER = '14157386102'; // Assurez-vous que le numéro de départ est correct

        $whatsAppText = new WhatsAppText(
            $FROM_NUMBER,
            $TO_NUMBER,
            'this is a WA text from vonage'
        );

        $client->messages()->send($whatsAppText);
        dd($whatsAppText);   	
        */
	}
	
	public function status()
	{
		
	}
	
	    
	public function inbound(Request $request)
	{
		
		$api_key = env('VONAGE_API_KEY');
    $api_secret = env('VONAGE_API_SECRET');
    $TO_NUMBER = env('VONAGE_FROM');
		
		$data = $request->all();
   	var_dump($data);
	}    
}
