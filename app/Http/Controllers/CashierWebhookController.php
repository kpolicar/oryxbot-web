<?php

namespace App\Http\Controllers;

use App\Events\PaymentSucceeded;
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

    protected function handlePaymentIntentSucceeded(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $data = $payload['data']['object'];

            $paymentData = [
                'user_id' => $user->id,
                'source' => 'stripe',
                'transaction_id' => $data['id'],
                'amount' => $data['amount'],
                'currency' => $data['currency'],
            ];

            PaymentSucceeded::dispatch($paymentData);
        }

        return $this->successMethod();
    }

    protected function handleCustomerUpdated(array $payload)
    {
        $response = parent::handleCustomerUpdated($payload);

        if ($user = $this->getUserByStripeId($payload['data']['object']['id'])) {
            $user->stripe_balance = (int)$payload['data']['object']['balance'];
            $user->save();
        }
        dd('nmo');

        return $response;
    }
}
