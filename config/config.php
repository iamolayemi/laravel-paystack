<?php

/*
 * This file is part of the Laravel Paystack package.
 *
 * (c) Olayemi Olatayo <olatayo.olayemi.peter@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Paystack Keys
    |--------------------------------------------------------------------------
    |
    | The Paystack public key and secret key. You can get these from your Paystack dashboard.
    |
    */
    'public_key' => env('PAYSTACK_PUBLIC_KEY', 'pk_*'),

    'secret_key' => env('PAYSTACK_SECRET_KEY', 'sk_*'),

//    /*
//    |--------------------------------------------------------------------------
//    | Callback URL - Optional
//    |--------------------------------------------------------------------------
//    |
//    | This should correspond to the callback URL set in your Paystack dashboard:
//    | https://dashboard.paystack.com/#/settings/developer.
//    |
//    | Remember to also add this as an exception in your VerifyCsrfToken middleware.
//    |
//    */
//    'callback_url' => env('PAYSTACK_CALLBACK_URL', 'https://example.com'),
//
//    /*
//    |--------------------------------------------------------------------------
//    | Webhooks URL
//    |--------------------------------------------------------------------------
//    |
//    | This should correspond to the webhooks URL set in your Paystack dashboard:
//    | https://dashboard.paystack.com/#/settings/developer.
//    |
//    | Remember to also add this as an exception in your VerifyCsrfToken middleware.
//    |
//    */
//    'webhook_url' => env('PAYSTACK_WEBHOOK_URL', 'https://example.com'),
];
