<?php

namespace App\Listeners;

use App\Models\User;
use DB;
use App\Events\PaymentSucceeded;
use CoinbaseCommerce\Resources\Charge;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StorePayment
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PaymentSucceeded $event)
    {
        $data = [];
        if ($event->payment instanceof Charge) {
            $data = [
                'user_id' => $event->payment['metadata']['user_id'],
                'source' => 'coinbase',
                'transaction_id' => $event->payment['code'],
                'amount' => (int)str_replace('.', '', $event->payment['pricing']['local']['amount']),
                'currency' => $event->payment['pricing']['local']['currency'],
            ];
        } else if (is_array($event->payment)) {
            $data = $event->payment;
        }

        if (empty($data)) {
            throw new \InvalidArgumentException();
        }
        $data['created_at'] = now();

        DB::table('payments')
            ->insert($data);
    }
}
