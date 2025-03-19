<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GestionnaireAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('gestionnaire')) {
            return redirect()->route('chemin_connexion_gestionnaire')
                ->with('erreurs', ['Vous devez vous connecter comme gestionnaire pour accéder à cette page']);
        }

        return $next($request);
    }
} 