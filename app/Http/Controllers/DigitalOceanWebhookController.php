<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController;

class DigitalOceanWebhookController extends Controller
{
    protected function handleWebhook(array $payload)
    {
    }
}
