<?php

use App\ClientVersion;
use App\Http\Controllers\CashierWebhookController;
use App\Http\Controllers\CoinbaseController;
use App\Http\Controllers\CoinbaseWebhookController;
use App\Http\Controllers\DigitalOceanController;
use App\Http\Controllers\LinkDiscordController;
use App\Http\Controllers\StripeController;
use App\Http\Middleware\HasNeverSubscribed;
use App\Http\Middleware\NotSubscribed;
use App\Http\Middleware\OnFreeTrial;
use App\Http\Middleware\SetLocaleFromSession;
use App\Http\Middleware\Subscribed;
use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;
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

Route::middleware(config('nova.middleware', []))
    ->domain(config('nova.domain', null))
    ->prefix(Nova::path())
    ->get('/billing-portal', [StripeController::class, 'billing'])
    ->name('billing');

Route::get('/vpnd', function () {
    dd(\DigitalOcean::snapshot()->getAll());
    /*$server = Auth::user()->instances->first()->server;
    $droplet = $server->droplet_id;
    dd($server->getAttributes());
    dd(\DigitalOcean::droplet()->getById($droplet));
    //$a = \DigitalOcean::create('bot1-oryxbot-s-1vcpu-1gb-fra1-01');*/
    $sub = Auth::user()->subscription();
    $sub->quantity = 1;
    $sub->save();
    //\App\Events\BotLocationChanged::dispatch(\Auth::user(), '(2,1)', '12', 0);
    \App\Events\VpnConnectionChanged::dispatch(\Auth::user(), 0, true);
});

Route::domain(config('app.domain'))->group(function () {
    Route::group(
        [
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => [ 'localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
        ], function() {

        Route::get('/', function () {
            return view('welcome');
        })->name('home');

        Route::middleware(['auth', Subscribed::class])->group(function () {

            Route::view(LaravelLocalization::transRoute('routes.install'), 'install')
                ->name('install');

            Route::view(LaravelLocalization::transRoute('routes.usage'), 'usage')
                ->name('usage');

            Route::get(LaravelLocalization::transRoute('routes.download'), function (ClientVersion $version) {
                    return redirect()->home();
                })->name('download');
        });

        Route::middleware('can:purchase-subscription')->group(function () {

            Route::get(LaravelLocalization::transRoute('routes.subscribe'), function (Request $request) {
                return view('subscribe');
            })->name('subscribe')->middleware('auth');

            Route::post(LaravelLocalization::transRoute('routes.subscribe-coinbase-checkout'), [CoinbaseController::class, 'subscribe'])
                ->name('subscribe.coinbase.checkout');

        });


        Route::get('/release/{version?}', function (ClientVersion $versions, $version) {
            $versionDetails = $version == "latest" ?
                $versions->latest() :
                $versions->firstWhere('code', $version);
            $view = $versionDetails['number'] ?? abort(404);

            return view("release.$view", ['version' => $versionDetails]);
        })->name('release');

        Route::post('/create-checkout-session', [StripeController::class, 'checkoutSession'])
            ->middleware([NotSubscribed::class])
            ->name('create-checkout-session');

        Route::post('/create-checkout-session-trial', [StripeController::class, 'checkoutSessionWithFreeTrial'])
            ->middleware([NotSubscribed::class, HasNeverSubscribed::class])
            ->name('create-checkout-session-trial');

        Route::post('/trial-cancel', [StripeController::class, 'cancelTrial'])
            ->middleware([Subscribed::class, OnFreeTrial::class])
            ->name('trial-cancel');

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
        })->name('profile');

        Route::view(LaravelLocalization::transRoute('routes.free-trial'), 'free-trial')
            ->name('free-trial');

        require_once 'fortify.php';

        Route::view(LaravelLocalization::transRoute('routes.login-discord'), 'discord-link')
            ->middleware(['guest'])
            ->name('login.discord');

        Route::view('terms', 'terms')
            ->name('terms');

        Route::redirect(LaravelLocalization::transRoute('routes.discord'), config('services.discord.invite_link'))
            ->name('discord');
    });


    Route::prefix('discord')->group(function () {
        Route::get('link/{id}', [LinkDiscordController::class, '__invoke'])
            ->middleware([SetLocaleFromSession::class, 'auth', 'signed', 'throttle:3,1'])
            ->name('discord.link');
    });

    Route::post(
        config('cashier.path').'/webhook',
        [CashierWebhookController::class, 'handleWebhook']
    );
    Route::post('coinbase/webhook', [CoinbaseWebhookController::class, 'handleWebhook']);

    Route::prefix('digitalocean')->group(function () {
        Route::post(
            'webhook',
            [DigitalOceanController::class, 'handleWebhook']
        )->name('digitalocean.webhook');

        Route::get(
            'vpn',
            [DigitalOceanController::class, 'vpnCredentials']
        )->name('digitalocean.vpn');

    });

});
