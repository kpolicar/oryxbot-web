<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BotStepChanged extends BotEvent
{
    public $step;


    public function __construct(User $user, int $instanceId, string $step)
    {
        parent::__construct($user, $instanceId);
        $this->step = $step;
    }
}
