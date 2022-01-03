<?php

namespace App\Listeners;

use Carbon\Carbon;
use DB;
use App\Events\CoinbaseWebhookReceived;

class SaveCoinbaseWebhook
{
    /**
     * Handle the event.
     *
     * @param CoinbaseWebhookReceived $data
     * @return void
     */
    public function handle(CoinbaseWebhookReceived $data)
    {
        DB::table('coinbase_webhook_calls')
            ->insert([
                'type' => $data->event['type'],
                'payload' => $data->event,
                'created_at' => Carbon::now(),
            ]);
    }
}
