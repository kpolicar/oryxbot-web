<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Status extends BotEvent
{
    public $characterLocation;
    public $characterSpeed;
    public $botRunning;
    public $botRecordingRunning;
    public $botStep;
    public $remoteDesktopConnected;
    public $remoteDesktopResolution;
    public $vpnEstablished;

    public function __construct(
        User $user,
        int $instanceId,
        string $characterLocation,
        string $characterSpeed,
        bool $botRunning,
        bool $botRecordingRunning,
        string $botStep,
        bool $remoteDesktopConnected,
        string $remoteDesktopResolution,
        bool $vpnEstablished)
    {
        parent::__construct($user, $instanceId);
        $this->characterLocation = $characterLocation;
        $this->characterSpeed = $characterSpeed;
        $this->botRunning = $botRunning;
        $this->botRecordingRunning = $botRecordingRunning;
        $this->botStep = $botStep;
        $this->remoteDesktopConnected = $remoteDesktopConnected;
        $this->remoteDesktopResolution = $remoteDesktopResolution;
        $this->vpnEstablished = $vpnEstablished;
    }
}
