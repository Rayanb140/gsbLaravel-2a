<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseVisiteurController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!session('visiteur')) {
                return redirect()->route('chemin_connexion')
                     ->with('erreurs', ['Vous devez vous connecter pour accéder à cette page']);
            }
            return $next($request);
        });
    }
} 