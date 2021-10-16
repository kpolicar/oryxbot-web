<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ServerOnlineStatus extends RequestServerOnlineStatus implements ShouldBroadcastNow
{
    public $online;

    public function __construct(User $user, bool $online, int $instanceId)
    {
        parent::__construct($user, $instanceId);
        $this->online = $online;
    }
}
