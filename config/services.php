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
    // 'google' => [
    //     'client_id' => '293299106402-u7o02qr83gdi976ge7rf5qb00ta613er.apps.googleusercontent.com',
    //     'client_secret' => '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',
    //     'redirect' => env('APP_URL').'/auth/google/callback',
    // ],
    'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],

    'facebook' => [
        'client_id' => '615240171137628',
        'client_secret' => '6be7018ec3d6b0be565bf325bf28fa97',
        'redirect' => env('APP_URL').'/auth/facebook/callback',
    ],

];
