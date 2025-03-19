<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VisiteurAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('visiteur')) {
            // Journaliser la tentative d'accès non autorisée
            \App\Services\SecurityLogger::logUnauthorizedAccess(
                $request->path(),
                $request->ip()
            );
            
            return redirect()->route('visiteurAccueil')
                ->with('erreurs', ['Vous devez vous connecter pour accéder à cette page']);
        }

        return $next($request);
    }
} 