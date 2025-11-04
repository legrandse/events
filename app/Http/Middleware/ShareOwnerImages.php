<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;


class ShareOwnerImages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    	if (app()->bound('currentOwner')) {
            $owner = app('currentOwner');
            $files = Storage::files('public/' . $owner->id);
            $img = collect($files)->map(fn($file) => Storage::url($file))->toArray();
            View::share('img', $img);
        }
    	
        return $next($request);
    }
}
