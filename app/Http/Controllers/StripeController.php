<?php

namespace App\Http\Controllers;

use App\Exceptions\ConfigMissingException;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;

class StripeController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'verified']);
        $this->middleware('customer');
    }

    public function billing(Request $request) {
        return $request->user()->redirectToBillingPortal(route('profile'));
    }

    public function cancelTrial(Request $request) {
        $request->user()->subscription()->endTrial();
    }

    public function checkoutSession(Request $request) {
        return $request->user()
            ->allowPromotionCodes()
            ->checkout(config('pricing.trade_mission_bot.stripe_id'), [
            'mode' => 'subscription',
            'payment_method_types' => ['card'],
            'success_url' => route('profile', ['checkout' => true]),
            'cancel_url' => route('profile', ['checkout' => false]),
        ])->asStripeCheckoutSession();
    }

    public function checkoutSessionWithFreeTrial(Request $request) {
        return $request->user()
            ->allowPromotionCodes()
            ->checkout(config('pricing.trade_mission_bot.stripe_id'), [
            'mode' => 'subscription',
            'payment_method_types' => ['card'],
            'subscription_data' => [
                'trial_period_days' => config('pricing.trade_mission_bot.trial_period_days')
            ],
            'success_url' => route('profile', ['checkout' => true]),
            'cancel_url' => route('profile', ['checkout' => false]),
        ])->asStripeCheckoutSession();
    }
}
