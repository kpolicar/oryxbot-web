<?php namespace App\Events;

use App\Models\User;

class VpnConnectionChanged extends BotEvent
{
    public $established;


    public function __construct(User $user, int $instanceId, bool $established)
    {
        parent::__construct($user, $instanceId);
        $this->established = $established;
    }
}
