<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccueilGestionnaireController extends Controller
{
    public function afficherTableauBord() 
    {
        $gestionnaire = session('gestionnaire');
        
        if (!$gestionnaire) {
            return redirect()->route('chemin_connexion_gestionnaire')
                ->with('erreurs', ['Vous devez vous connecter pour accéder à cette page.']);
        }
        
        // Données factices pour la démonstration
        $nbVisiteurs = 12;
        $nbFichesEnAttente = 8;
        $montantTotal = 2450;
        
        return view('sommaireGestionnaire', [
            'gestionnaire' => $gestionnaire,
            'nbVisiteurs' => $nbVisiteurs,
            'nbFichesEnAttente' => $nbFichesEnAttente,
            'montantTotal' => $montantTotal
        ]);
    }
} 