<?php

return [
    'secret' => env('RECAPTCHA_SECRET'),
    'sitekey' => env('RECAPTCHA_SITEKEY'),
    'verifyurl' => 'https://www.google.com/recaptcha/api/siteverify',
];
