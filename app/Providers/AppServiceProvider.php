<?php

namespace App\Providers;

use Str;
use App\ClientVersion;
use App\Models\Maging;
use App\Models\User;
use Illuminate\Http\Request;
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

        $currentVersion = $this->app[ClientVersion::class]->latest();
        \View::share('download_password', "oryxbot");
        \View::share('download_asset', "storage/Oryxbot_{$currentVersion['code']}.zip");
    }
}
