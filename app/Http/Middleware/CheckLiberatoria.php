<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLiberatoria
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Se l'utente non ha compilato i dati obbligatori della liberatoria
        // e non sta cercando di accedere alla pagina della liberatoria stessa
        if (!$user->real_name || !$user->tax_code || !$user->accepted_terms) {
            if (!$request->routeIs('profile.liberatoria') && !$request->routeIs('profile.liberatoria.update')) {
                return redirect()->route('profile.liberatoria')->with('error', 'Devi compilare la liberatoria per accedere allo studio.');
            }
        }

        return $next($request);
    }
}
