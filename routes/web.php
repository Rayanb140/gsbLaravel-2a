<?php

use Illuminate\Support\Facades\Route;
// Chemin des contrôleurs
use App\Http\Controllers\connexionController;
use App\Http\Controllers\etatFraisController;
use App\Http\Controllers\gererFraisController;
use App\Http\Controllers\gestionnaireController;
use App\Http\Controllers\gestionVisiteurController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AccueilGestionnaireController;
use App\Http\Controllers\PdfController;

// Routes publiques
Route::get('/', [connexionController::class, 'connecter'])->name('chemin_connexion');
Route::post('/', [connexionController::class, 'valider'])
    ->middleware('throttle:5,1')
    ->name('chemin_valider');

// Routes pour gestionnaire
Route::get('/gestionnaire', [gestionnaireController::class, 'connecter'])->name('chemin_connexion_gestionnaire');
Route::post('/gestionnaire', [gestionnaireController::class, 'valider'])
    ->middleware('throttle:5,1')
    ->name('chemin_valider_gestionnaire');

// Groupe de routes protégées pour les visiteurs
Route::middleware([\App\Http\Middleware\VisiteurAuth::class])->group(function () {
    Route::get('/visiteurAccueil', function () {
        return view('sommaireVisiteur')
               ->with('visiteur', session('visiteur'));
    })->name('visiteurAccueil');
    
    Route::get('/gererFrais', [gererFraisController::class, 'saisirFrais'])->name('chemin_gestionFrais');
    Route::post('/sauvegarderFrais', [gererFraisController::class, 'sauvegarderFrais'])->name('chemin_sauvegardeFrais');
    
    // Corriger ces routes pour utiliser etatFraisController
    Route::get('/selectionMois', [etatFraisController::class, 'selectionnerMois'])->name('chemin_selectionMois');
    Route::post('/listeFrais', [etatFraisController::class, 'voirFrais'])->name('chemin_listeFrais');
});

// Routes gestionnaire (sans middleware de groupe)
Route::get('/gestionnaireAccueil', function () {
    // Vérification manuelle
    if (!session('gestionnaire')) {
        return redirect()->route('chemin_connexion_gestionnaire')
            ->with('erreurs', ['Vous devez vous connecter comme gestionnaire pour accéder à cette page']);
    }
    return view('sommaireGestionnaire')
          ->with('gestionnaire', session('gestionnaire'));
})->name('sommaire_gestionnaire');

Route::get('/listeVisiteurs', [gestionVisiteurController::class, 'listeVisiteurs'])->name('chemin_listeVisiteurs');
Route::get('/ajoutVisiteur', [gestionVisiteurController::class, 'formAjoutVisiteur'])->name('chemin_ajoutVisiteur');
Route::post('/validerVisiteur', [gestionVisiteurController::class, 'validerVisiteur'])->name('chemin_validerVisiteur');

// Routes ancien format pour compatibilité
Route::get('/gestionnaire/visiteurs/ajout/form', [gestionVisiteurController::class, 'formAjoutVisiteur'])->name('chemin_ajout_visiteur');
Route::post('/gestionnaire/visiteurs/ajout', [gestionVisiteurController::class, 'ajouterVisiteur'])->name('chemin_ajouter_visiteur');
Route::get('/gestionnaire/visiteurs', [gestionVisiteurController::class, 'listeVisiteurs'])->name('chemin_liste_visiteurs');
Route::get('/gestionnaire/visiteurs/{id}', [gestionVisiteurController::class, 'formVisiteur'])->name('chemin_form_visiteur');
Route::post('/gestionnaire/visiteurs/maj', [gestionVisiteurController::class, 'majVisiteur'])->name('chemin_maj_visiteur');
Route::get('/gestionnaire/visiteurs/pdf', [gestionVisiteurController::class, 'genererPDF'])->name('chemin_pdf_visiteurs');

// Routes de déconnexion
Route::get('/deconnexion', [connexionController::class, 'deconnecter'])->name('chemin_deconnexion');
Route::get('/gestionnaire/deconnexion', [gestionnaireController::class, 'deconnecter'])->name('chemin_deconnexion_gestionnaire');

// Route supplémentaire pour le tableau de bord gestionnaire
Route::get('/gestionnaire/sommaire', [AccueilGestionnaireController::class, 'afficherTableauBord'])->name('sommaire_gestionnaire');

// Groupe de routes protégées pour les gestionnaires
Route::middleware([\App\Http\Middleware\GestionnaireAuth::class])->group(function () {
    Route::get('/gestionnaireAccueil', function () {
        return view('sommaireGestionnaire')
               ->with('gestionnaire', session('gestionnaire'));
    })->name('sommaire_gestionnaire');
    
    Route::get('/listeVisiteurs', [gestionVisiteurController::class, 'listeVisiteurs'])->name('chemin_listeVisiteurs');
    Route::get('/ajoutVisiteur', [gestionVisiteurController::class, 'formAjoutVisiteur'])->name('chemin_ajoutVisiteur');
    Route::post('/validerVisiteur', [gestionVisiteurController::class, 'validerVisiteur'])->name('chemin_validerVisiteur');

    // Anciennes routes pour compatibilité
    Route::get('/gestionnaire/visiteurs/ajout/form', [gestionVisiteurController::class, 'formAjoutVisiteur'])->name('chemin_ajout_visiteur');
    Route::post('/gestionnaire/visiteurs/ajout', [gestionVisiteurController::class, 'ajouterVisiteur'])->name('chemin_ajouter_visiteur');
    Route::get('/gestionnaire/visiteurs', [gestionVisiteurController::class, 'listeVisiteurs'])->name('chemin_liste_visiteurs');
    Route::get('/gestionnaire/visiteurs/{id}', [gestionVisiteurController::class, 'formVisiteur'])->name('chemin_form_visiteur');
    Route::post('/gestionnaire/visiteurs/maj', [gestionVisiteurController::class, 'majVisiteur'])->name('chemin_maj_visiteur');
    Route::get('/gestionnaire/visiteurs/pdf', [gestionVisiteurController::class, 'genererPDF'])->name('chemin_pdf_visiteurs');
    Route::get('/gestionnaire/sommaire', [AccueilGestionnaireController::class, 'afficherTableauBord'])->name('sommaire_gestionnaire_tableau');
});

// Route pour le tableau de bord visiteur
Route::get('/visiteur/sommaire', [AccueilController::class, 'afficherTableauBord'])->name('sommaire_visiteur_tableau');

// Ajouter cette route pour assurer la compatibilité avec le code existant
Route::get('/sommaire', function () {
    return redirect()->route('visiteurAccueil');
})->name('sommaire');

// Ajouter cette route spécifique pour le PDF (avant les routes avec des paramètres)
Route::get('/gestionnaire/pdf/visiteurs', [App\Http\Controllers\PdfController::class, 'genererPdfVisiteurs'])
    ->name('chemin_pdf_visiteurs')
    ->middleware(\App\Http\Middleware\GestionnaireAuth::class);

