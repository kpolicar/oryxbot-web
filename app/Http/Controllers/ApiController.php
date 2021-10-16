<?php

namespace App\Http\Controllers;

use App\ClientVersion;
use App\Exceptions\ConfigMissingException;
use App\Http\Middleware\DecryptApiRequest;
use App\Http\Middleware\EncryptApiResponse;
use App\Http\Middleware\Subscribed;
use Illuminate\Http\Request;
use App\Http\Resources\ClientUser as ClientUserResource;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{

    public function __construct()
    {
        $this->middleware(Subscribed::class)
            ->except(['Info', 'User']);
        $this->middleware(EncryptApiResponse::class)
            ->except(['Info']);
        $this->middleware(DecryptApiRequest::class)
            ->except(['Info', 'User']);
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
        if ($request->user()->on_free_trial) {
            $url = route('profile');
            $message .= "\nSince your account is on free trial the bot has stopped!";
            $message .= "\nSubscribe now to run the bot uninterrupted.\n$url";
        }

        $this->NotifyDiscord($request, $message);
        $this->NotifyOneSignal($request, $message, isset($url) ? $url : null);
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

    public function NotifyRunStuck(Request $request) {
        $message = 'Your character appears to have gotten stuck! The bot is now paused!';
        $this->NotifyDiscord($request, $message);
        $this->NotifyOneSignal($request, $message);
    }

    public function BroadcastStepChanged(Request $request) {
        $message = [
            'finish-quest' => "Finish quest",
            'bank-items' => "Bank items",
            'progress-quest' => "Progress quest",
            'take-quest' => "Take quest",
            'run-route-back' => "Run route back",
            'run-route-to-destination' => "Run route",
            'run-to-bank' => "Run to bank",
            'run-to-quest' => "Run to quest",
        ][$request->input('step')];

        \App\Events\BotStepChanged::dispatch($request->user(), $message, 0);
    }

    public function BroadcastLocationChanged(Request $request) {
        [$x, $y] = [(int)$request->input('x'), (int)$request->input('y')];
        $location = "($x, $y)";

        \App\Events\BotLocationChanged::dispatch(
            $request->user(),
            $location,
            (int)$request->input('speed'),
            0);
    }

    public function BroadcastRemoteDesktop(Request $request) {
        $resolution = (int)$request->input('resolution_x')."x".(int)$request->input('resolution_y');

        \App\Events\RemoteDesktopConnectionChanged::dispatch(
            $request->user(),
            $request->input('connected'),
            $resolution,
            0);
    }

    public function BroadcastRunningChanged(Request $request) {
        $running = $request->boolean('running');

        $request->user()->setTradeMissionRunning($running);

        \App\Events\BotRunningChanged::dispatch(
            $request->user(),
            $running,
            0);
    }

    public function BroadcastServerStatus(Request $request) {
        \Log::info('yes');
        \App\Events\ServerOnlineStatus::dispatch(
            $request->user(),
            $request->boolean('online'),
            0);
    }

    private function NotifyOneSignal(Request $request, $message, $url=null)
    {
        if ($request->user()->optin_web_notifications) {
            \OneSignal::sendNotificationToExternalUser(
                $message,
                $request->user()->id,
                $url,
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
