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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'boleto' => [
        'itau' => [
            'api_key' => env('ITAU_API_KEY'),
            'api_secret' => env('ITAU_API_SECRET'),
            'endpoint' => env('ITAU_API_ENDPOINT'),
        ],
        'banco_do_brasil' => [
            'api_key' => env('BANCO_DO_BRASIL_API_KEY'),
            'api_secret' => env('BANCO_DO_BRASIL_API_SECRET'),
            'endpoint' => env('BANCO_DO_BRASIL_API_ENDPOINT'),
        ],
        'bradesco' => [
            'api_key' => env('BRADESCO_API_KEY'),
            'api_secret' => env('BRADESCO_API_SECRET'),
            'endpoint' => env('BRADESCO_API_ENDPOINT'),
        ],
        'santander' => [
            'api_key' => env('SANTANDER_API_KEY'),
            'api_secret' => env('SANTANDER_API_SECRET'),
            'endpoint' => env('SANTANDER_API_ENDPOINT'),
        ],
    ]

];
