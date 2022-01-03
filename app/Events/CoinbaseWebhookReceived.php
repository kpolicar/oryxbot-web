<?php

namespace App\Events;

use CoinbaseCommerce\Resources\Event;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CoinbaseWebhookReceived
{
    use Dispatchable, SerializesModels;

    public $event;

    /**
     * Create a new event instance.
     *
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }
}
