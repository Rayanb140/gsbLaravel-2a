<?php

namespace App\Traits;

trait RequiresVisiteurAuth
{
    protected function checkVisiteurAuth()
    {
        if (!session('visiteur')) {
            return redirect()->route('chemin_connexion')
                ->with('erreurs', ['Vous devez vous connecter pour accéder à cette page']);
        }
        return null;
    }
} 