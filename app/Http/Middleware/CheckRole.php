<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Vérifie si l'utilisateur a le rôle requis.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if ($role === 'visiteur' && !session('visiteur')) {
            return redirect()->route('chemin_connexion')->with('erreurs', ['Vous devez vous connecter pour accéder à cette page']);
        }

        if ($role === 'gestionnaire' && !session('gestionnaire')) {
            return redirect()->route('chemin_connexion_gestionnaire')->with('erreurs', ['Vous devez vous connecter comme gestionnaire pour accéder à cette page']);
        }

        return $next($request);
    }
} 