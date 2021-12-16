<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BotRunningChanged extends BotEvent
{
    public $running;
    public $recordingRunning;


    public function __construct(User $user, int $instanceId, bool $running, bool $recordingRunning)
    {
        parent::__construct($user, $instanceId);
        $this->running = $running;
        $this->recordingRunning = $recordingRunning;
    }
}
