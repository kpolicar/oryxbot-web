<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RemoteDesktopConnectionChanged extends BotEvent
{
    public $connected;
    public $resolution;


    public function __construct(User $user, int $instanceId, bool $connected, string $resolution)
    {
        parent::__construct($user, $instanceId);
        $this->connected = $connected;
        $this->resolution = $resolution;
    }
}
