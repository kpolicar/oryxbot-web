<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BotLocationChanged extends BotEvent
{
    public $location;
    public $speed;


    public function __construct(User $user, int $instanceId, string $location, string $speed)
    {
        parent::__construct($user, $instanceId);
        $this->location = $location;
        $this->speed = $speed;
    }
}
