<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DiscordController;
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
            Route::post('stepchanged', [ApiController::class, "BroadcastStepChanged"]);
            Route::post('moved', [ApiController::class, "BroadcastLocationChanged"]);
            Route::post('remotedesktop', [ApiController::class, "BroadcastRemoteDesktop"]);
        });
});

Route::middleware('auth:api')->get('/user', [ApiController::class, 'User']);
Route::get('/', [ApiController::class, 'Info']);
