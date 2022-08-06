<?php

use godscodes\R2Laravel\R2ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | R2 SDK Configuration
    |--------------------------------------------------------------------------
    */
    'credentials' => [
        'key'    => env('AWS_ACCESS_KEY_ID', ''),
        'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
    ],
    'region' => env('R2_REGION', 'auto'),
    'version' => env('R2_VERSION', 'latest'),    
    'bucket_name' => env('AWS_BUCKET'),
    'account_id' => env('R2_ACCOUNT_ID'),
    'access_key_id' => env('AWS_ACCESS_KEY_ID'),
    'access_key_secret' => env('AWS_SECRET_ACCESS_KEY'),
    'endpoint' => env('R2_ENDPOINT')
];