<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

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
        // on prend le host configuré (ex: myeventz.test)
        $domainRoot = parse_url(config('app.url'), PHP_URL_HOST);

        // Si la requête est directement sur le domaine racine (pas de sous-domaine)
        if ($host === $domainRoot) {
            // s'assurer que le root url correspond à APP_URL (pour assets, redirects, etc.)
            URL::forceRootUrl(config('app.url'));
            // ne pas définir de subdomain par défaut (important : on ne doit pas injecter 'myeventz' par erreur)
            return $next($request);
        }

        // Ici on est sur un host qui contient forcément un préfixe (ex: app.myeventz.test)
        // On retire ".myeventz.test" pour obtenir "app"
        $subdomain = $request->route('subdomain')
            ?? preg_replace('/\.' . preg_quote($domainRoot, '/') . '$/i', '', $host);

        // Si la détection donne encore le host entier, on prend le premier segment
        if ($subdomain === $host) {
            $parts = explode('.', $host);
            $subdomain = $parts[0] ?? null;
        }

        // Si on a bien un sous-domaine valide, on l'applique aux routes
        if (!empty($subdomain)) {
            URL::defaults(['subdomain' => $subdomain]);

            $expectedHost = $subdomain . '.' . $domainRoot;
            // Forcer la base only si nécessaire (évite doublons)
            if ($host !== $expectedHost) {
                URL::forceRootUrl($request->getScheme() . '://' . $expectedHost);
            }
        }

        return $next($request);
    }
}
