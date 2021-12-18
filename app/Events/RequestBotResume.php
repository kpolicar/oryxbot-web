<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestBotResume extends BotEvent
{
    public $city;
    public $alias;
    public $progressed;
    public $hearts;


    public function __construct(User $user, int $instanceId, string $city, string $alias, bool $progressed, int $hearts)
    {
        parent::__construct($user, $instanceId);
        $this->city = $city;
        $this->alias = $alias;
        $this->progressed = $progressed;
        $this->hearts = $hearts;
    }
}
