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
    \App\Events\RequestBotRunningChanged::dispatch($request->user(), true, 0);
});

Route::post('{instance}/stop', function (Request $request, $instance) {
    \App\Events\RequestBotRunningChanged::dispatch($request->user(), false, 0);
});

Route::post('{instance}/server-status', function (Request $request, $instance) {
    \App\Events\RequestServerOnlineStatus::dispatch($request->user(), 0);
});
