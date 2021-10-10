<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VpnConnectionChanged implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    private $user;
    public $established;
    public $instanceId;


    public function __construct(User $user, bool $established, int $instanceId)
    {
        $this->user = $user;
        $this->established = $established;
        $this->instanceId = $instanceId;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.'.$this->user->id);
    }
}
