<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestBotRunningChanged extends BotEvent
{
    public $running;
    public $city;
    public $hearts;


    public function __construct(User $user, int $instanceId, bool $running, string $city=null, int $hearts=null)
    {
        parent::__construct($user, $instanceId);
        $this->running = $running;
        $this->city = $city;
        $this->hearts = $hearts;
    }
}
