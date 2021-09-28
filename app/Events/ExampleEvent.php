<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExampleEvent implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    public $info='what am I doing here?';


    public function broadcastOn()
    {
        return new Channel('example-1');
    }
}
