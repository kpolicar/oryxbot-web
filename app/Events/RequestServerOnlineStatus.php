<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestServerOnlineStatus implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    private $user;
    public $instanceId;


    public function __construct(User $user, int $instanceId)
    {
        $this->user = $user;
        $this->instanceId = $instanceId;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.'.$this->user->id);
    }
}
