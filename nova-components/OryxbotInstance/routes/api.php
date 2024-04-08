<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::post('{instance}/start', function (Request $request, $instance) {
    $hearts = $request->input('hearts');
    \App\Events\RequestBotRunningChanged::dispatch($request->user(),
        0,
        true,
        $request->input('city'),
        $hearts ? (int) $hearts : null);
});

Route::post('{instance}/resume', function (Request $request, $instance) {
    $hearts = $request->input('hearts');
    \App\Events\RequestBotResume::dispatch($request->user(),
        0,
        $request->input('city'),
        $request->input('region'),
        $request->boolean('progressed'),
        $hearts ? (int) $hearts : null);
});

Route::post('{instance}/start-recording', function (Request $request, $instance) {
    \App\Events\RequestBotRecordStart::dispatch($request->user(),
        0,
        $request->input('name'),
        $request->input('city'),
        $request->input('destination'));
});

Route::post('{instance}/stop', function (Request $request, $instance) {
    \App\Events\RequestBotRunningChanged::dispatch($request->user(), 0, false);
});

Route::post('{instance}/status', function (Request $request, $instance) {
    \App\Events\RequestStatus::dispatch($request->user(), 0);
});

Route::post('{instance}/server-reboot', [\App\Http\Controllers\SshController::class, "reboot"])->middleware(['throttle:3,1']);
