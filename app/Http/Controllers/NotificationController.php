<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function RunComplete(Request $request) {
        $message = "Trade mission run has been completed successfully.";
        $this->NotifyDiscord($request, $message);
        $this->NotifyOneSignal($request, $message);
    }

    private function NotifyOneSignal(Request $request, $message)
    {
        if ($request->user()->optin_web_notifications) {
            \OneSignal::sendNotificationToExternalUser(
                $message,
                $request->user()->id,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
            );
        }
    }

    private function NotifyDiscord(Request $request, $message)
    {
        if ($request->user()->optin_discord_notifications) {
            $content = "!notify {$request->user()->discord_id} \":bell: $message\"";
            \Http::post(
                config('discord.webhook_url'),
                compact('content')
            );
        }
    }
}
