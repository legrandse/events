<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlanLimits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $resource): Response
    {
    	$owner = app('currentOwner');
        //dd($resource);

        switch ($resource) {
            case 'events':
                $count = $owner->events()->count();
                $limit = $owner->product->max_events;
                if (!is_null($limit) && $count >= $limit) {
                    return redirect()->back()->with([
                        'limit' => 'Vous avez atteint la limite de ' . $limit . ' événement(s) pour votre plan.'
                    ]);
                }
                break;

            case 'volunteers':
                //$event = $request->route('event');
                $count = $owner->users()->count();
                $limit = $owner->product->max_volunteers;
                if (!is_null($limit) && $count >= $limit) {
                    return redirect()->back()->with([
                        'limit' => 'Vous avez atteint la limite de bénévoles autorisés.'
                    ]);
                }
                break;
            
           
        }
    	
        return $next($request);
    }
}
