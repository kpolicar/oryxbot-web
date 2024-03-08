<?php

namespace App\Providers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Kpolicar\OryxbotHelp\OryxbotHelp;
use Kpolicar\OryxbotInsights\OryxbotInsights;
use Kpolicar\OryxbotInstance\OryxbotInstance;
use Kpolicar\OryxbotLogs\OryxbotLogs;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        //dd($this->app['digitalocean.factory']->make([
        //    'token'   => 'abc',
        //    'method'  => 'token',
        //])->droplet()->getAll());
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->subscribedToTradeMissionBot();
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new OryxbotHelp,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new OryxbotInstance,
            new OryxbotLogs,
            new OryxbotInsights,
        ];
    }

    private $setupRoutes=[
        'setup',
        'setup.digitalocean',
        'setup.digitalocean.referral',
        'setup.digitalocean.validate',
        'setup.digitalocean.deploy',
        'setup.deploy',
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::serving(function (ServingNova $serving) {
            if (!$serving->request->routeIs($this->setupRoutes)) {
                throw new HttpResponseException(redirect()->to(route('setup')));
            }
        });
    }
}
