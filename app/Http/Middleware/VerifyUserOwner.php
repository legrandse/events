<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\OwnerUser;

class VerifyUserOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    	$user = Auth::user();
        $owner = app('currentOwner'); // récupéré via ton multi-domaine

        // ⚙️ Si pas d'utilisateur connecté ou pas d'owner défini, on continue sans bloquer
        if (!$user || !$owner) {
            return $next($request);
        }

        // 🔍 Vérifie que l'utilisateur est bien lié à l'owner
        $isLinked = OwnerUser::where('owner_id', $owner->id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$isLinked) {
            Auth::logout();
            session()->flash('message', 'Cet utilisateur ne fait pas partie de cette équipe.');
            return redirect()->route('login');
        }

    	
    	
        return $next($request);
    }
}
