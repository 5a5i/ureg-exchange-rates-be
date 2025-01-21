<?php
/*
|--------------------------------------------------------------------------
| External API's Configuration
|--------------------------------------------------------------------------
|
| This file is for storing the configuration of external API's that
| the application will be using. The configuration is stored in the
| form of an array, and should be used to store the base URL, API key,
| and further information of the API's that the application will be using.
|
*/

return [

    'exchange' => [
        'url' => env('EXCHANGE_RATES_API_URL', 'https://api.exchangeratesapi.io'),
        'key' => env('EXCHANGE_RATES_API_KEY', '')
    ]

];
