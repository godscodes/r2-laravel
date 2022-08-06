<?php

use godscodes\R2Laravel\R2ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | R2 SDK Configuration
    |--------------------------------------------------------------------------
    */
    'region' => env('R2_REGION', 'auto'),
    'version' => 'latest',
];