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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'nexmo' => [
        'sms_from' => 'Zpayd',
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'indexing_quota' => env('GOOGLE_INDEXING_QUOTA', 200),
        'service_account_json' => env('GOOGLE_SERVICE_ACCOUNT_JSON', storage_path('app/google-service-account.json')),
    ],
    'Stripe' =>[
        'sk_key'=>env('Stripe_secret_key', 'none'),
        'pk_key'=>env('Stripe_public_key', 'none'),
        'sign'=>env('Stripe_Signature', 'none')
    ],


];
