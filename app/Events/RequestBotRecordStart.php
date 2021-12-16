<?php

namespace App\Events;

use App\Models\User;

class RequestBotRecordStart extends BotEvent
{
    public $name;
    public $city;
    public $destination;


    public function __construct(User $user, int $instanceId, string $name, string $city, string $destination)
    {
        parent::__construct($user, $instanceId);
        $this->name = $name;
        $this->city = $city;
        $this->destination = $destination;
    }
}
