<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Merchant
    |--------------------------------------------------------------------------
    |
    | The merchant id of the Converge account.
    |
    */

    'merchant_id' => env('CONVERGE_MERCHANT_ID'),

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    |
    | The information on the authorized user to send the api requests.
    |
    */

    'user' => [
        'id' => env('CONVERGE_USER_ID'),
        'pin' => env('CONVERGE_USER_PIN'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Demo Mode
    |--------------------------------------------------------------------------
    |
    | Incidates if the requests should be sent to the demo environment instead
    | of the production environment.
    |
    */

    'demo' => env('CONVERGE_DEMO', false),

];
