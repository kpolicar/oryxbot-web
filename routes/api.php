<?php

use App\ClientVersion;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DiscordController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\Subscribed;
use App\Http\Resources\ClientUser as ClientUserResource;
use App\Models\User;
use Illuminate\Http\Request;
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


Route::middleware(['auth:api', 'throttle:3,1,notification', Subscribed::class])->prefix('/notify')->group(function () {
    Route::prefix('trademission')->group(function () {
        Route::post('complete', [NotificationController::class, "RunComplete"]);
    });
});

Route::middleware('auth:api')->get('/user', [ApiController::class, 'User']);
Route::get('/', [ApiController::class, 'Info']);
