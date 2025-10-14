<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
        	// routes sous-domaine dynamique
            Route::middleware('web')
                ->domain('{subdomain}.' . config('app.url'))
                //->where('shortname', '^(?!www$).+') // Exclut explicitement 'www'
                //->middleware('throttle:subdomain')
                ->group(base_path('routes/subdomain.php'));
        	
        	
        	
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
        
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
        
       /* RateLimiter::for('subdomain', function (Request $request) {
        // Limiter à 1 tentative toutes les 10 secondes par IP
        return Limit::perMinutes(1/6, 2)->by($request->ip());
    });*/
        
    }
}
