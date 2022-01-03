<?php

namespace App\Http\Controllers;

use App\Events\CoinbaseWebhookReceived;
use App\Events\PaymentSucceeded;
use CoinbaseCommerce\Exceptions\InvalidResponseException;
use CoinbaseCommerce\Exceptions\SignatureVerificationException;
use App\Events\UserPurchasedSubscription;
use App\Models\User;
use App\Notifications\CoinbaseChargeCompleted;
use App\Notifications\CoinbaseChargeFailed;
use App\Notifications\CoinbaseChargePending;
use CoinbaseCommerce\Resources\Charge;
use CoinbaseCommerce\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Cashier\Events\WebhookHandled;
use Laravel\Cashier\Events\WebhookReceived;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CoinbaseWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        try {
            $signature = $request->header('X-CC-Webhook-Signature');
            $payload = $request->getContent();

            if (!is_string($signature))
                throw new SignatureVerificationException($signature, $payload);
            $event = Webhook::buildEvent($payload, $signature, config('services.coinbase.webhook_secret'));
        } catch (InvalidResponseException $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        } catch (SignatureVerificationException $exception) {
            throw new AccessDeniedHttpException('No signatures found matching the expected signature for payload', $exception);
        }

        CoinbaseWebhookReceived::dispatch($event);

        $method = 'handle'.Str::studly(str_replace(':', '_', $event['type']));

        if (method_exists($this, $method)) {
            $response = $this->{$method}($event['data']);
        }

        return $response ?? new Response;
    }

    public function handleChargePending(Charge $charge)
    {
        $user = User::findOrFail($charge['metadata']['user_id']);
        $user->notify(new CoinbaseChargePending($charge));
    }

    public function handleChargeFailed(Charge $charge)
    {
        $user = User::findOrFail($charge['metadata']['user_id']);

        $lastUpdate = collect($charge['timeline'])->last();
        if (data_get($lastUpdate, 'status') == 'UNRESOLVED')
            $user->notify(new CoinbaseChargeFailed($charge));

    }

    public function handleChargeConfirmed(Charge $charge)
    {
        $user = User::findOrFail($charge['metadata']['user_id']);
        PaymentSucceeded::dispatch($charge);

        if (!$user->hasStripeId())
            $user->createAsStripeCustomer();

        $pricing = $charge['pricing']['local'];
        $amount = (int)str_replace('.', '', $pricing['amount']);
        $currency = $pricing['currency'];

        if (strtolower($currency) != strtolower($user->preferredCurrency()))
            throw new \InvalidArgumentException();

        $customer = $user->asStripeCustomer();
        $customer->balance -= $amount;
        $customer->save();

        $subscription = $user->newSubscription('default', config('pricing.trade_mission_bot.stripe_id'));
        // Todo: Temporary sale
        if (app('cryptoPromo')) {
            $subscription->trialDays(3);
        }
        if ($user->subscriptions->isEmpty()) {
            $subscription->withPromotionCode(config('pricing.trade_mission_bot.promo_code_stripe_id'));
        }
        $subscription = $subscription->quantity($charge['metadata']['quantity'])
            ->noProrate()
            ->withMetadata([
                'coinbase_charge_id' => $charge->id
            ])
            ->create();


        UserPurchasedSubscription::dispatch($user);
        $user->notify(new CoinbaseChargeCompleted($charge, $subscription));
    }
}
