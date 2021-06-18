<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController;

class CashierWebhookController extends WebhookController
{
    public function handlePaymentMethodAttached($payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);
        if ($user->hasDefaultPaymentMethod())
            return $this->successMethod();

        $paymentMethodId = $payload['data']['object']['id'];
        $user->updateDefaultPaymentMethod($paymentMethodId);

        return $this->successMethod();
    }

    protected function handleCustomerUpdated(array $payload)
    {
        $response = parent::handleCustomerUpdated($payload);

        if ($user = $this->getUserByStripeId($payload['data']['object']['id'])) {
            $user->stripe_balance = (int)$payload['data']['object']['balance'];
            $user->save();
        }

        return $response;
    }
}
