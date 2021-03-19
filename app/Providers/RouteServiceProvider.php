<?php

namespace App\Providers;

use App\ClientVersion;
use App\Http\Middleware\EncryptApiResponse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;

class RouteServiceProvider extends ServiceProvider
{
    use LoadsTranslatedCachedRoutes;

    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/profile';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api/{version}')
                ->where(['version' => 'v([0-9.]+(beta)?)'])
                ->middleware('api')
                ->middleware(function (Request $request, $next) {
                    $versions = app(ClientVersion::class);
                    $code = $request->segment(2);
                    $version = $versions->firstWhere('code', $code);

                    abort_if($version === null, 404);
                    return $next($request);
                })
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
