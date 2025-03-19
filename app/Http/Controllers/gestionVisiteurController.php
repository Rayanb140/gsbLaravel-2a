<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class gestionVisiteurController extends Controller
{
    // Vérification si l'utilisateur est connecté en tant que gestionnaire
    private function estGestionnaireConnecte() {
        return session('gestionnaire') != null;
    }
    
    // Affiche la liste des visiteurs
    function listeVisiteurs(){
        if(!$this->estGestionnaireConnecte()){
            return redirect()->route('chemin_connexion_gestionnaire');
        }
        
        $gestionnaire = session('gestionnaire');
        $lesVisiteurs = PdoGsb::getLesVisiteurs();
        
        return view('listeVisiteurs')
            ->with('gestionnaire', $gestionnaire)
            ->with('lesVisiteurs', $lesVisiteurs);
    }
    
    // Affiche le formulaire pour un visiteur spécifique
    function formVisiteur($id){
        if(!$this->estGestionnaireConnecte()){
            return redirect()->route('chemin_connexion_gestionnaire');
        }
        
        $gestionnaire = session('gestionnaire');
        $leVisiteur = PdoGsb::getUnVisiteur($id);  // Utiliser getUnVisiteur()
        
        return view('formVisiteur')
            ->with('gestionnaire', $gestionnaire)
            ->with('leVisiteur', $leVisiteur)  // Conserver leVisiteur comme nom de variable dans la vue
            ->with('erreurs', null);
    }
    
    // Sauvegarde les modifications d'un visiteur
    function majVisiteur(Request $request){
        if(!$this->estGestionnaireConnecte()){
            return redirect()->route('chemin_connexion_gestionnaire');
        }
        
        $gestionnaire = session('gestionnaire');
        
        // Validation des données (sans exiger le mot de passe)
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'login' => 'required',
            'adresse' => 'required',
            'cp' => 'required|digits:5',
            'ville' => 'required',
            'dateEmbauche' => 'required|date'
        ]);
        
        if ($validator->fails()) {
            return view('formVisiteur')
                ->with('gestionnaire', $gestionnaire)
                ->with('leVisiteur', $request->all())
                ->with('erreurs', $validator->errors()->all());
        }
        
        // Obtenir les informations actuelles du visiteur
        $visiteurActuel = PdoGsb::getUnVisiteur($request->id);
        
        // Vérifier si un nouveau mot de passe a été fourni
        $mdp = !empty($request->mdp) ? $request->mdp : null;
        
        // Mise à jour des informations
        PdoGsb::majVisiteur(
            $request->id,
            $request->nom,
            $request->prenom,
            $request->login,
            $request->adresse,
            $request->cp,
            $request->ville,
            $request->dateEmbauche,
            $mdp  // Passez le mot de passe seulement s'il a été modifié
        );
        
        return redirect()
            ->route('chemin_liste_visiteurs')
            ->with('message', 'Visiteur modifié avec succès');
    }
    
    // Affiche le formulaire d'ajout d'un visiteur
    function formAjoutVisiteur(){
        if(!$this->estGestionnaireConnecte()){
            return redirect()->route('chemin_connexion_gestionnaire');
        }
        
        $gestionnaire = session('gestionnaire');
        
        return view('ajoutVisiteur')
            ->with('gestionnaire', $gestionnaire)
            ->with('erreurs', null);
    }
    
    // Ajoute un nouveau visiteur
    function ajouterVisiteur(Request $request){
        if(!$this->estGestionnaireConnecte()){
            return redirect()->route('chemin_connexion_gestionnaire');
        }
        
        $gestionnaire = session('gestionnaire');
        
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'prenom' => 'required',
            'adresse' => 'required',
            'cp' => 'required|digits:5',
            'ville' => 'required',
            'dateEmbauche' => 'required|date'
        ]);
        
        if ($validator->fails()) {
            return view('ajoutVisiteur')
                ->with('gestionnaire', $gestionnaire)
                ->with('visiteur', $request->all())
                ->with('erreurs', $validator->errors()->all());
        }
        
        // Ajout du visiteur - le login est généré automatiquement
        $infoVisiteur = PdoGsb::ajouterVisiteur(
            $request->nom,
            $request->prenom,
            $request->adresse,
            $request->cp,
            $request->ville,
            $request->dateEmbauche
        );
        
        return redirect()
            ->route('chemin_liste_visiteurs')
            ->with('message', 'Visiteur ajouté avec succès (ID: ' . $infoVisiteur['id'] . ')')
            ->with('infoVisiteur', $infoVisiteur);
    }
    
    // Génère un PDF avec la liste des visiteurs
    function genererPDF(){
        if(!$this->estGestionnaireConnecte()){
            return redirect()->route('chemin_connexion_gestionnaire');
        }
        
        $lesVisiteurs = PdoGsb::getLesVisiteurs();
        
        $pdf = PDF::loadView('pdfVisiteurs', [
            'lesVisiteurs' => $lesVisiteurs
        ]);
        
        return $pdf->download('liste_visiteurs.pdf');
    }
} 