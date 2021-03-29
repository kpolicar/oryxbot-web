<?php

namespace App\Http\Controllers;

use App\Events\UserSyncedWithDiscord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class DiscordController extends Controller
{
    public function Login(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
            'discord_id' => 'required',
        ]);
        $user = User::where('email', $request->input('email'))->first();
        $user->discord_id = $request->input('discord_id');
        $user->save();
    }

    public function Url(Request $request)
    {
        return URL::temporarySignedRoute(
            'discord.link',
            Carbon::now()->addMinutes(10),
            [
                'id' => $request->input('id'),
            ]
        );
    }
}
