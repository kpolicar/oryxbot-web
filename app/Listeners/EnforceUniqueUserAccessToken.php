<?php

namespace App\Listeners;

use App\Models\User;
use DB;
use Laravel\Passport\Events\AccessTokenCreated;

class EnforceUniqueUserAccessToken
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        $user = User::find($event->userId);
        if (!$user)
            return;

        $token = $user->tokens()->firstWhere('id', $event->tokenId);
        if ($token->name == null) {
            $user->tokens()
                ->where('revoked', 0)
                ->where('id', '!=', $event->tokenId)
                ->update([
                    'revoked' => true
                ]);
            return;
        }

        $skip = max($user->subscription_instances-1, 0);
        $tokensToDelete = $user->tokens()
            ->where('revoked', 0)
            ->where('id', '!=', $event->tokenId)
            ->get()
            ->groupBy('name')
            ->skip($skip);


        if (!empty($tokensToDelete)) {
            $user->tokens()
                ->where('revoked', 0)
                ->where('id', '!=', $event->tokenId)
                ->whereIn('name', $tokensToDelete->keys())
                ->update([
                    'revoked' => true
                ]);
        }
    }
}
