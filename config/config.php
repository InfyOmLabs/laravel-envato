<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Endpoint
    |--------------------------------------------------------------------------
    |
    */
    'api_endpoint' => env('ENVATO_API_ENDPOINT', 'https://api.envato.com'),

    /*
    |--------------------------------------------------------------------------
    | Envato Authentication Type
    |--------------------------------------------------------------------------
    |
    */
    'auth_type' => env('ENVATO_AUTH_TYPE', 'oauth'),

    /*
    |--------------------------------------------------------------------------
    | Envato OAuth Credentials
    |--------------------------------------------------------------------------
    |
    */
    'oauth' => [

        'client_id' => env('ENVATO_CLIENT_ID'),

        'client_secret' => env('ENVATO_CLIENT_SECRET'),

        'redirect_uri' => env('ENVATO_REDIRECT_URI'),

    ],

    /*
    |--------------------------------------------------------------------------
    | Envato Personal Token
    |--------------------------------------------------------------------------
    |
    | If you are planning to use personal token instead of OAuth then
    | you can use personal token as access token while settings up
    | credentials in auth session.
    |
    */
    'personal_token' => env('ENVATO_PERSONAL_TOKEN'),

];
