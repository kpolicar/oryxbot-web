<?php

namespace App\Providers;

use App\Events\CoinbaseWebhookReceived;
use App\Events\PaymentSucceeded;
use App\Events\UserPurchasedSubscription;
use App\Events\UserSyncedWithDiscord;
use App\Listeners\SaveCoinbaseWebhook;
use App\Listeners\SendUserSubscriptionStatusToDiscord;
use App\Listeners\StorePayment;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Passport\Events\AccessTokenCreated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserPurchasedSubscription::class => [
            SendUserSubscriptionStatusToDiscord::class,
        ],
        UserSyncedWithDiscord::class => [
            SendUserSubscriptionStatusToDiscord::class,
        ],
        CoinbaseWebhookReceived::class => [
            SaveCoinbaseWebhook::class
        ],
        PaymentSucceeded::class => [
            StorePayment::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
