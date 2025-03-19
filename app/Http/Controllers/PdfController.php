<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;

class PdfController extends Controller
{
    public function genererPdfVisiteurs()
    {
        // Vérifier l'authentification manuellement
        if (!session('gestionnaire')) {
            return redirect()->route('chemin_connexion_gestionnaire')
                ->with('erreurs', ['Vous devez vous connecter comme gestionnaire pour accéder à cette page']);
        }
        
        // Récupérer tous les visiteurs
        $lesVisiteurs = PdoGsb::getLesVisiteurs();
        
        // Vérifier si les données sont récupérées correctement
        if (!$lesVisiteurs) {
            return back()->with('erreurs', ['Aucun visiteur trouvé']);
        }
        
        // Générer le PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.liste_visiteurs', [
            'lesVisiteurs' => $lesVisiteurs
        ]);
        
        // Télécharger le PDF
        return $pdf->download('liste-visiteurs.pdf');
    }
} 