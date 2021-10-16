<?php

use DigitalOcean;
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
    \App\Events\RequestBotRunningChanged::dispatch($request->user(), 0, true);
});

Route::post('{instance}/stop', function (Request $request, $instance) {
    \App\Events\RequestBotRunningChanged::dispatch($request->user(), 0, false);
});

Route::post('{instance}/status', function (Request $request, $instance) {
    \App\Events\RequestStatus::dispatch($request->user(), 0);
});

Route::post('{instance}/server-reboot', function (Request $request, $instance) {
    if ($instance = $request->user()->instances->first()) {
        DigitalOcean::droplet()->powerCycle($instance->server->droplet_id);
    } else {
        abort(404, 'Server not found');
    }
})->middleware(['throttle:1,1']);
