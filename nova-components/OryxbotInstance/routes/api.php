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

Route::get('/run', function (Request $request) {
    \App\Events\RequestBotRunningChanged::dispatch($request->user(), true, 0);
});

Route::get('/stop', function (Request $request) {
    \App\Events\RequestBotRunningChanged::dispatch($request->user(), false, 0);
});
