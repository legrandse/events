<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;
use App\Models\Owner;

class SetSubdomainDefault
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
		$domainRoot = parse_url(config('app.url'), PHP_URL_HOST);

		// Cas 1 : on est sur le domaine racine
		if ($host === $domainRoot) {
		    URL::forceRootUrl(config('app.url'));
		    return $next($request);
		}

		// Cas 2 : on a un sous-domaine
		$subdomain = $request->route('subdomain')
		    ?? preg_replace('/\.' . preg_quote($domainRoot, '/') . '$/i', '', $host);

		// Fallback si la regex n'a rien donné
		if ($subdomain === $host) {
		    $parts = explode('.', $host);
		    $subdomain = $parts[0] ?? null;
		}

		// 🚫 Cas spécial : sous-domaine "www"
		if ($subdomain === 'www') {
		    $rootUrl = config('app.url');

		    // On s'assure que l'URL se termine bien par un "/"
		    if (!str_ends_with($rootUrl, '/')) {
		        $rootUrl .= '/';
		    }

		    // Redirection permanente vers le domaine racine
		    return redirect()->to($rootUrl, 301);
		}

		// Cas 3 : on a un sous-domaine applicatif valide
		if (!empty($subdomain)) {
		    URL::defaults(['subdomain' => $subdomain]);

		    $owner = Owner::where('shortname', $subdomain)->first();
		   if (!$owner) {
                abort(404, "Propriétaire non trouvé pour le sous-domaine '{$subdomain}'");
            }
		    app()->instance('currentOwner', $owner);

		    $expectedHost = $subdomain . '.' . $domainRoot;

		    // Évite les doublons de host
		    if ($host !== $expectedHost) {
		        URL::forceRootUrl($request->getScheme() . '://' . $expectedHost);
		    }
		}

		


        return $next($request);
    }
}
