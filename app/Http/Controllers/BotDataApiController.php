<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;

class BotDataApiController
{
    private const REQUEST_PARAM_BOT_STEP = 'bot_step';
    private const REQUEST_PARAM_CHARACTER_SPEED = 'character_speed';
    private const REQUEST_PARAM_CHARACTER_POSITION_X = 'character_x';
    private const REQUEST_PARAM_CHARACTER_POSITION_Y = 'character_y';
    private const REQUEST_PARAM_REMOTE_DESKTOP_RESOLUTION_X = 'remote_desktop_resolution_x';
    private const REQUEST_PARAM_REMOTE_DESKTOP_RESOLUTION_Y = 'remote_desktop_resolution_y';
    private const REQUEST_PARAM_REMOTE_DESKTOP_CONNECTED = 'remote_desktop_connected';
    private const REQUEST_PARAM_BOT_RUNNING = 'bot_running';


    public function BroadcastStepChanged(Request $request) {
        \App\Events\BotStepChanged::dispatch($request->user(), 0, $this->formatBotStepFromRequest($request));
    }

    public function BroadcastLocationChanged(Request $request) {
        \App\Events\BotLocationChanged::dispatch(
            $request->user(),
            0,
            $this->formatLocationFromRequest($request),
            $this->formatSpeedFromRequest($request));
    }

    public function BroadcastRemoteDesktop(Request $request) {
        \App\Events\RemoteDesktopConnectionChanged::dispatch(
            $request->user(),
            0,
            $request->boolean(static::REQUEST_PARAM_REMOTE_DESKTOP_CONNECTED),
            $this->formatRemoteDesktopResolutionFromRequest($request));
    }

    public function BroadcastRunningChanged(Request $request) {
        \App\Events\BotRunningChanged::dispatch(
            $request->user(),
            0,
            $request->boolean(static::REQUEST_PARAM_BOT_RUNNING));
    }

    public function BroadcastStatus(Request $request) {
        \Log::info('yes');
        \App\Events\Status::dispatch(
            $request->user(),
            0,
            $this->formatLocationFromRequest($request),
            $this->formatSpeedFromRequest($request),
            $request->boolean(static::REQUEST_PARAM_BOT_RUNNING),
            $this->formatBotStepFromRequest($request),
            $request->boolean(static::REQUEST_PARAM_REMOTE_DESKTOP_CONNECTED),
            $this->formatRemoteDesktopResolutionFromRequest($request),
            false
        );
    }

    protected function formatBotStepFromRequest(Request $request)
    {
        return [
            'finish-quest' => "Finish quest",
            'bank-items' => "Bank items",
            'progress-quest' => "Progress quest",
            'take-quest' => "Take quest",
            'run-route-back' => "Run route back",
            'run-route-to-destination' => "Run route",
            'run-to-bank' => "Run to bank",
            'run-to-quest' => "Run to quest",
            '' => "-",
        ][$request->input(static::REQUEST_PARAM_BOT_STEP)];
    }

    protected function formatSpeedFromRequest(Request $request)
    {
        return (string)((int)$request->input(static::REQUEST_PARAM_CHARACTER_SPEED));
    }

    protected function formatLocationFromRequest(Request $request)
    {
        [$x, $y] = [
            (int)$request->input(static::REQUEST_PARAM_CHARACTER_POSITION_X),
            (int)$request->input(static::REQUEST_PARAM_CHARACTER_POSITION_Y)];

        return $x && $y
            ? "({$x}, {$y})"
            : '-';
    }

    protected function formatRemoteDesktopResolutionFromRequest(Request $request)
    {
        [$x, $y] = [
            (int)$request->input(static::REQUEST_PARAM_REMOTE_DESKTOP_RESOLUTION_X),
            (int)$request->input(static::REQUEST_PARAM_REMOTE_DESKTOP_RESOLUTION_Y)];

        return $x && $y
            ? "{$x}x{$y}"
            : '-';
    }
}
