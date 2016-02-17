<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
        'client_id'     => '547547974282-jtk4pb11frq0842s498bf3kajbjlbda2.apps.googleusercontent.com',
        'client_secret' => 'twZZr7DczoVouzCvvldh-oag',
        'redirect'      => env('APP_URL', 'http://get-loc.ru') . '/google/callback',
    ],

    'twitter' => [
        'client_id'     => 'E5Ahcw784UGvB2sPp1Q11OOlh',
        'client_secret' => 'Du1MlV4sPSpmaEFWAVinx7kVlMwKMK6cqgdZyELcQTsuTxeT9V',
        'redirect'      => env('APP_URL', 'http://get-loc.ru') . '/twitter/callback',
    ],

    'facebook' => [
        'client_id'     => '443779859134217',
        'client_secret' => 'f7e34a6375f0f5087ae0bc15fece5873',
        'redirect'      => env('APP_URL', 'http://get-loc.ru') . '/facebook/callback',
    ],

];
