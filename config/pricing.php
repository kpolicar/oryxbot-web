<?php

return [

    'trade_mission_bot' => [
        'stripe_id' => env('STRIPE_PRICE_ID'),
        'price' => 1500,
        'discount_price' => 1000,
        'trial_period_days' => 3,
        'promo' => 'EARLYBIRD',
    ]

];
