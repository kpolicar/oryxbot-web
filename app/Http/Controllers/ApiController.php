<?php

namespace App\Http\Controllers;

use App\ClientVersion;
use App\Exceptions\ConfigMissingException;
use App\Http\Middleware\DecryptApiRequest;
use App\Http\Middleware\EncryptApiResponse;
use App\Http\Middleware\Subscribed;
use Illuminate\Http\Request;
use App\Http\Resources\ClientUser as ClientUserResource;

class ApiController extends Controller
{

    public function __construct()
    {
        $this->middleware(Subscribed::class)
            ->except(['Info', 'User']);
        $this->middleware(EncryptApiResponse::class)
            ->except(['Info']);
        $this->middleware(DecryptApiRequest::class)
            ->only(['NotifyRunStarting']);
    }


    public function Info($code, ClientVersion $versions) {
        $version = $versions->firstWhere('code', $code);

        return [
            'name' => $version['name'],
            'endpoint' => $version['code'],
            'number' => $version['number'],
        ];
    }

    public function User(Request $request) {
        return new ClientUserResource($request->user());
    }

    public function NotifyRunComplete(Request $request) {
        $message = "Trade mission run has been completed successfully.";
        $this->NotifyDiscord($request, $message);
        $this->NotifyOneSignal($request, $message);
    }

    public function NotifyRunStarting(Request $request) {
        $request->validate([
           'title' => 'max:43',
           'message' => 'max:100'
        ]);
        $message = $request->post('title')." | ".$request->post('message');
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
