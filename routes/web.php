<?php

use App\ClientVersion;
use App\Http\Controllers\CashierWebhookController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\WebhookController;
use App\Http\Middleware\HasNeverSubscribed;
use App\Http\Middleware\HasntUsedFreeTrial;
use App\Http\Middleware\NotSubscribed;
use App\Http\Middleware\OnFreeTrial;
use App\Http\Middleware\Subscribed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {

    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get(LaravelLocalization::transRoute('routes.profile'), function (Request $request) {
        $message = $request->getSession()->get('notification');
        $action = "";
        if (!$message) {
            if (!optional($request->user())->hasVerifiedEmail()) {
                $message = __('forms.quick_verify_header');
                $action = 'partials.resend-verification';
            } elseif ($request->get('verified')) {
                $message = __('forms.quick_verify_success');
            }
        }

        return view('profile')
            ->with(compact('message', 'action'));
    })->middleware('auth')->name('profile');

    Route::view(LaravelLocalization::transRoute('routes.free-trial'), 'free-trial')
        ->name('free-trial')
        ->middleware('verified');

    Route::view(LaravelLocalization::transRoute('routes.install'), 'install')
        ->name('install');

    Route::get('/release/{version?}', function (ClientVersion $versions, $version) {
        $versionDetails = $version == "latest" ?
            $versions->latest() :
            $versions->firstWhere('code', $version);
        $view = $versionDetails['number'] ?? abort(404);

        return view("release.$view", ['version' => $versionDetails]);
    })->name('release');

    Route::post('/create-checkout-session', [StripeController::class, 'checkoutSession'])
        ->middleware(NotSubscribed::class)
        ->name('create-checkout-session');

    Route::post('/create-checkout-session-trial', [StripeController::class, 'checkoutSessionWithFreeTrial'])
        ->middleware([NotSubscribed::class, HasNeverSubscribed::class])
        ->name('create-checkout-session-trial');

    Route::post('/trial-cancel', [StripeController::class, 'cancelTrial'])
        ->middleware([Subscribed::class, OnFreeTrial::class])
        ->name('trial-cancel');

    Route::get('/billing-portal', [StripeController::class, 'billing'])
        ->middleware(Subscribed::class)
        ->name('billing');

    require_once 'fortify.php';
});

Route::post(
    config('cashier.path').'/webhook',
    [CashierWebhookController::class, 'handleWebhook']
);
