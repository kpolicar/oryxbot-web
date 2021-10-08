<?php

namespace Kpolicar\OryxbotInstance;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Kpolicar\OryxbotInstance\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'oryxbot-instance');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            if (!in_array($event->request->user()->email, ['naltamer14@gmail.com', 'admin@oryxbot.coma']))
                abort(403);

            Nova::provideToScript([
                'pusherHost' => env('PUSHER_APP_HOST'),
                'pusherAppKey' => env('PUSHER_APP_KEY'),
                'pusherAppCluster' => env('PUSHER_APP_CLUSTER'),
            ]);
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('instances')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
