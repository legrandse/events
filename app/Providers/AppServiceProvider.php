<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use App\Http\Middleware\TeamsPermission;
use App\Http\Middleware\TenantMiddleware;
use App\Http\Middleware\SetSubdomainDefault;
use App\Http\Middleware\VerifyUserOwner;

use Illuminate\Foundation\Http\Kernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(125);
        Paginator::useBootstrapFive();
        
        if (config('app.env') === 'production') {
        	URL::forceScheme('https');
    	}
    	
    	/** @var Kernel $kernel */
        $kernel = app()->make(Kernel::class);

        // Ajoute ton middleware AVANT SubstituteBindings
        $kernel->addToMiddlewarePriorityBefore(
        	TeamsPermission::class,
        	SetSubdomainDefault::class,
        	TenantMiddleware::class,
        	//VerifyUserOwner::class,
           
            SubstituteBindings::class,
        );
    	
    	
        
    }
}
