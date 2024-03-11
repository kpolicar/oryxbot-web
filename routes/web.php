<?php

use App\ClientVersion;
use App\Http\Controllers\CashierWebhookController;
use App\Http\Controllers\CoinbaseController;
use App\Http\Controllers\CoinbaseWebhookController;
use App\Http\Controllers\DigitalOceanController;
use App\Http\Controllers\LinkDiscordController;
use App\Http\Controllers\SetupController;
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
    ->group(function () {

        Route::get('/billing-portal', [StripeController::class, 'billing'])
            ->name('billing');

        Route::get('/setup/{instance}', [SetupController::class, 'index'])
            ->name('setup');

        Route::get('/setup/{instance}/reset', [SetupController::class, 'reset'])
            ->name('setup.reset');

        Route::get('/setup/{instance}/digitalocean', [SetupController::class, 'setup'])
            ->name('setup.digitalocean');

        Route::get('/setup/{instance}/deploy', [SetupController::class, 'deploy'])
            ->name('setup.deploy');

        Route::post('/setup/{instance}/reset', [DigitalOceanController::class, 'reset'])
            ->name('setup.reset.submit');

        Route::post('/setup/{instance}/digitalocean/validate', [DigitalOceanController::class, 'validateToken'])
            ->middleware(['throttle:3,1'])
            ->name('setup.digitalocean.validate');

        Route::post('/setup/{instance}/digitalocean/deploy', [DigitalOceanController::class, 'deployServer'])
//            ->middleware(['throttle:2,1'])
            ->name('setup.digitalocean.deploy');

        Route::get('/setup/{instance}/vncserver/tightvnc', [SetupController::class, 'vncServer'])
            ->name('setup.vncserver.tightvnc');

        Route::get('/setup/{instance}/vpn', [SetupController::class, 'vpn'])
            ->name('setup.vpn');

        Route::redirect('/setup/digitalocean/referral', 'https://www.digitalocean.com/?refcode=a7974130a08b&utm_campaign=Referral_Invite&utm_medium=Referral_Program&utm_source=badge')
            ->name('setup.digitalocean.referral');
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

            Route::get('/storage/releases/latest', function () {
                return response()->download(storage_path('app/subscribed/oryxbot.tar'));
            })->name('releases.latest');

            Route::get('/storage/vnc-releases/latest', function () {
                return response()->download(storage_path('app/subscribed/VncClient.jar'));
            })->name('vnc-releases.latest');
        });

        Route::middleware('can:purchase-subscription')->group(function () {

            Route::get(LaravelLocalization::transRoute('routes.subscribe'), function (Request $request) {
                // todo: Temporary
                return redirect('disabled');
                return view('subscribe');
            })->name('subscribe')->middleware('auth');

            Route::post(LaravelLocalization::transRoute('routes.subscribe-coinbase-checkout'), [CoinbaseController::class, 'subscribe'])
                ->name('subscribe.coinbase.checkout');

        });

        Route::get('disabled', function (Request $request) {
            return view('disabled');
        })->name('disabled');


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
        })->middleware('auth')->name('profile');

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
});
