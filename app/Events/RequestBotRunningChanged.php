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


    public function __construct(User $user, int $instanceId, bool $running)
    {
        parent::__construct($user, $instanceId);
        $this->running = $running;
    }
}
