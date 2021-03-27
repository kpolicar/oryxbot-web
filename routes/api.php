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
});


Route::middleware(['auth:api', 'throttle:3,1,notification'])->prefix('/notify')->group(function () {
    Route::prefix('trademission')->group(function () {
        Route::post('starting', [ApiController::class, "NotifyRunStarting"]);
        Route::post('complete', [ApiController::class, "NotifyRunComplete"]);
    });
});

Route::middleware('auth:api')->get('/user', [ApiController::class, 'User']);
Route::get('/', [ApiController::class, 'Info']);
