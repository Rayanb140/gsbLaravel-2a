<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PdoGsb;

class AccueilController extends Controller
{
    public function afficherTableauBord() 
    {
        $visiteur = session('visiteur');
        
        if (!$visiteur) {
            return redirect()->route('chemin_connexion')
                ->with('erreurs', ['Vous devez vous connecter pour accéder à cette page.']);
        }
        
        // Récupération des données du visiteur
        $idVisiteur = $visiteur['id'];
        
        // Récupérer les statistiques des frais du visiteur
        // A remplacer par de vraies requêtes à la base de données
        $nbFraisEnCours = 2;
        $nbFraisValides = 4;
        $nbFraisAttente = 1;
        
        // Récupérer les dernières fiches de frais
        // A remplacer par de vraies requêtes à la base de données
        $dernieresFiches = [
            [
                'mois' => 'Mars 2023',
                'montant' => '120,50',
                'statut' => 'En cours'
            ],
            [
                'mois' => 'Février 2023',
                'montant' => '345,00',
                'statut' => 'Validée'
            ],
            [
                'mois' => 'Janvier 2023',
                'montant' => '230,75',
                'statut' => 'En attente'
            ]
        ];
        
        return view('sommaireVisiteur', [
            'visiteur' => $visiteur,
            'nbFraisEnCours' => $nbFraisEnCours,
            'nbFraisValides' => $nbFraisValides,
            'nbFraisAttente' => $nbFraisAttente,
            'dernieresFiches' => $dernieresFiches
        ]);
    }
} 