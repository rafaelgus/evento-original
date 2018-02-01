<?php

return [
    'client_id' => env('PAYPAL_CLIENT_ID', ''),
    'client_secret' => env('PAYPAL_CLIENT_SECRET', ''),
    'sandbox_mode' => env('SANDBOX_MODE', true),

    'payouts_processor' => \EventoOriginal\Core\Infrastructure\Payouts\Services\PaypalPayoutService::class,
];
