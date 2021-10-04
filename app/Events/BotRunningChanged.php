<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BotRunningChanged implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    public $user;
    public $running;
    public $instanceId;


    public function __construct(User $user, bool $running, int $instanceId)
    {
        $this->user = $user;
        $this->running = $running;
        $this->instanceId = $instanceId;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.'.$this->user->id);
    }
}
