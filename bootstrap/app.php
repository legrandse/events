<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\SetSubdomainDefault;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
      /*  web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    */
    using: function () {
    	            
    	// routes sous-domaine dynamique
            Route::middleware('web')
                ->domain('{subdomain}.' . config('app.url'))
                ->group(base_path('routes/subdomain.php'));

    	
            // routes API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            
            // routes domaine principal
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
	        
	        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
	    	'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
	    	'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    	]);
        
        // ✅ Faire confiance aux proxys Docker / Nginx
        $middleware->trustProxies(
            at: '*', // ou une liste d’IP si tu veux être plus restrictif
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO
        );
        
        
        
        // 👇 Ajout du middleware global
        $middleware->append(SetSubdomainDefault::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
