<?php

namespace App\Observers;

use App\Events\UserSyncedWithDiscord;
use App\Models\User;

class UserObserver
{
    public function saving(User $user)
    {
        if ($user->wasChanged('discord_id') &&
            $user->discord_id &&
            !$user->wasChanged('optin_discord_notifications'))
        {
            $user->optin_discord_notifications = true;
        }
    }

    public function updated(User $user)
    {
        if ($user->wasChanged('discord_id')) {
            UserSyncedWithDiscord::dispatch($user);
        }
    }
}
