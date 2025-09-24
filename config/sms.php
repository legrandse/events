<?php

use Illuminate\Support\Facades\Facade;

return [

    'vonage' => [
            
            'api_key' => env('VONAGE_API_KEY'),
            'api_secret' => env('VONAGE_API_SECRET'),
            'from' => env('VONAGE_FROM','012345678'),
            'to' => env('VONAGE_TO'),
            'jwt_token' => env('VONAGE_JWT_TOKEN'),
            
        ],

];
