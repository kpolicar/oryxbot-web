<?php

return [
    'trade_mission_bot' => [
        'stripe_id' => env('STRIPE_PRICE_ID'),
        'promo_code_stripe_id' => env('STRIPE_PROMO_CODE_ID'),
        'price' => 2000,
        'currency' => 'eur',
        'discount_price' => 2000,
        'trial_period_days' => 3,
        'promo' => 'RELEASE2024',
    ]

];
