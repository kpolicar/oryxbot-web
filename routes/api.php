<?php

use App\ClientVersion;
use App\Http\Controllers\DiscordController;
use App\Http\Controllers\NotificationController;
use App\Http\Resources\ClientFreeTrial as ClientFreeTrialResource;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return new ClientUserResource($request->user());
});

Route::middleware(['auth:api', 'throttle:3,1,notification'])->prefix('/notify')->group(function () {
    Route::prefix('trademission')->group(function () {
        Route::post('complete', [NotificationController::class, "RunComplete"]);
    });
});

Route::get('/', function (ClientVersion $versions) {
    $last = $versions->latest();

    return [
        'name' => $last['name'],
        'endpoint' => $last['code'],
        'number' => $last['number'],
    ];
});
