<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Stripe API Keys
    |--------------------------------------------------------------------------
    |
    | Stripe uses two keys: a "publishable" key used in the browser and a
    | "secret" key used only server-side. You can find both in your Stripe
    | Dashboard under Developers > API keys.
    |
    */

    'key' => env('STRIPE_KEY'),

    'secret' => env('STRIPE_SECRET'),

    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | Currency used for Stripe charges. Amounts are sent to Stripe in the
    | smallest unit of the currency (e.g. cents for "usd").
    |
    */

    'currency' => env('STRIPE_CURRENCY', 'usd'),

];