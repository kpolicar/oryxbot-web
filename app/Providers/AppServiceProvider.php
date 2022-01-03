<?php

namespace App\Providers;

use App\Contracts\ApiEncrypter as ApiEncrypterContract;
use App\Models\Subscription;
use CoinbaseCommerce\ApiClient as CoinbaseClient;
use Illuminate\Encryption\Encrypter;
use Laravel\Cashier\Cashier;
use Str;
use App\ClientVersion;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(ClientVersion::class, new ClientVersion);
        $this->app->bind(ApiEncrypterContract::class, function () {
            $key = config('app.api_key');
            if (Str::startsWith($key, 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }
            return new Encrypter($key, config('app.cipher'));
        });
        if ($key=config('services.coinbase.key'))
            CoinbaseClient::init($key);
        Cashier::useSubscriptionModel(Subscription::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money', function ($amount) {
            return "<?php echo number_format($amount, 2) . ' €'; ?>";
        });

        Blade::if('subscribed', function () {
            return optional(auth()->user())->is_subscribed;
        });

        if (config('app.env') == 'production') {
            \URL::forceScheme('https');
        }
        \URL::forceRootUrl(\Config::get('app.url'));
        \View::share('download_password', "oryxbot");

        $this->app->singleton('cryptoPromo', function () {
            return now()->isBefore('2022-01-10');
        });
        \View::share('cryptoPromo', $this->app['cryptoPromo']);
    }
}
