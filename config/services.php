<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google' => [
        'client_id' => '37008971380-276tied5ac6ntor54hm9k7c7okn2bo2s.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => env('APP_URL').'/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => '615240171137628',
        'client_secret' => '6be7018ec3d6b0be565bf325bf28fa97',
        'redirect' => env('APP_URL').'/auth/facebook/callback',
    ],

];
