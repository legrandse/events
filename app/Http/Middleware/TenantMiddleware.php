<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Owner;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    	 // 🔹 Étape 1 : récupérer le sous-domaine
        $host = $request->getHost(); // ex: team1.monapp.com
        $parts = explode('.', $host);
        $subdomain = count($parts) > 2 ? $parts[0] : null;

        // 🔹 Étape 2 : trouver l’owner associé
        $owner = null;
        if ($subdomain) {
            $owner = Owner::where('shortname', $subdomain)->first();
            if (!$owner){
            	$owner = '';
            }
        }

        // 🔹 Étape 3 : si aucun owner valide, bloquer proprement
       /* if (!$owner) {
            // Tu peux rediriger vers une page d’erreur personnalisée
            abort(404, 'Sous-domaine invalide ou non associé à un propriétaire.');
        }*/

        // 🔹 Étape 4 : stocker l’owner globalement (pour toute la requête)
        app()->instance('currentOwner', $owner);

        // ou dans la session si besoin ailleurs
       // session(['owner_id' => $owner->id]);

        
    	
    	
        return $next($request);
    }
}
