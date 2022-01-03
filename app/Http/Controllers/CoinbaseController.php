<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Models\User;
use Stripe\Price;
use Validator;
use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Exceptions\CoinbaseException;
use CoinbaseCommerce\Resources\Charge;
use Illuminate\Http\Request;

class CoinbaseController extends Controller
{
    public function subscribe(Request $request)
    {
        $price = config('pricing.trade_mission_bot.price');
        if (($discount=config('pricing.trade_mission_bot.discount_price')) && $request->user()->subscriptions->isEmpty()) {
            $price -= $discount;
            $description = ' (Applied €'.(number_format($discount/100, 2)).' discount)';
        }
        $currency = config('pricing.trade_mission_bot.currency');
        $charge = new Charge(
            [
                "name" => __('pricing.name'),
                "description" => __('pricing.package_default').($description ?? ''),
                "metadata" => [
                    "user_id" => $request->user()->id,
                    "user_email" => $request->user()->email,
                    "quantity" => 1,
                ],
                "pricing_type" => "fixed_price",
                "local_price" => [
                    "amount" => number_format($price/100, 2),
                    "currency" => $currency,
                ],
                'cancel_url' => route('subscribe')
            ]
        );
        $charge->save();


        $validator = Validator::make($charge->getAttributes(), [
            'hosted_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        return redirect($charge['hosted_url']);
    }
}
