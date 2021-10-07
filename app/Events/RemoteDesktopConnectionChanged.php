<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RemoteDesktopConnectionChanged implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    private $user;
    public $connected;
    public $resolution;
    public $instanceId;


    public function __construct(User $user, bool $connected, string $resolution, int $instanceId)
    {
        $this->user = $user;
        $this->connected = $connected;
        $this->resolution = $resolution;
        $this->instanceId = $instanceId;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.'.$this->user->id);
    }
}
