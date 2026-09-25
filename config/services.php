<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Bale Messenger (OTP Service)
    |--------------------------------------------------------------------------
    */

    'bale' => [
        'token' => env('BALE_BOT_TOKEN'),
        'username' => env('BALE_BOT_USERNAME', 'GRAFIUM_bot'),
        'base_url' => env('BALE_BASE_URL', 'https://tapi.bale.ai'),
        'bot_link' => env('BALE_BOT_LINK', 'https://ble.ir/GRAFIUM_bot'),
        'otp_ttl' => 300, // 5 دقیقه به ثانیه
        'max_otp_per_5min' => 3,
    ],

];