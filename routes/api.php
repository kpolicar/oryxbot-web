<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BotDataApiController;
use App\Http\Controllers\DiscordController;
use App\Http\Middleware\Subscribed;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Broadcast::routes(['middleware' => 'auth:api']);

Route::prefix('/discord')->group(function () {
    Route::post('login', [DiscordController::class, "Login"]);

    Route::post('link-generate', [DiscordController::class, 'Url'])
        ->name('discord.send');
});


Route::middleware(['auth:api', 'throttle:notification_rate_limit_per_minute,1,notification'])
    ->prefix('/notify')
    ->group(function () {
        Route::prefix('trademission')->group(function () {
            Route::post('starting', [ApiController::class, "NotifyRunStarting"]);
            Route::post('complete', [ApiController::class, "NotifyRunComplete"]);
            Route::post('stuck', [ApiController::class, "NotifyRunStuck"]);
        });
});

Route::middleware(['auth:api', Subscribed::class])
    ->prefix('/data')
    ->group(function () {
        Route::post('stepchanged', [BotDataApiController::class, "BroadcastStepChanged"]);
        Route::post('moved', [BotDataApiController::class, "BroadcastLocationChanged"]);
        Route::post('remotedesktop', [BotDataApiController::class, "BroadcastRemoteDesktop"]);
        Route::post('runningchanged', [BotDataApiController::class, "BroadcastRunningChanged"]);
        Route::post('status', [BotDataApiController::class, "BroadcastStatus"]);
});

Route::middleware('auth:api')->get('/user', [ApiController::class, 'User']);
Route::get('/', [ApiController::class, 'Info']);
