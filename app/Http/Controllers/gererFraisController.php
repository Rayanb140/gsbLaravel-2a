<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;
use MyDate;
use App\Http\Requests\FraisRequest;
use App\Models\Frais;
use App\Traits\RequiresVisiteurAuth;

class gererFraisController extends Controller {
    use RequiresVisiteurAuth;

    function saisirFrais(Request $request){
        $redirect = $this->checkVisiteurAuth();
        if ($redirect) return $redirect;

        $visiteur = session('visiteur');
        $idVisiteur = $visiteur['id'];
        $anneeMois = MyDate::getAnneeMoisCourant();
        $mois = $anneeMois['mois'];
        if(PdoGsb::estPremierFraisMois($idVisiteur,$mois)){
             PdoGsb::creeNouvellesLignesFrais($idVisiteur,$mois);
        }
        $lesFrais = PdoGsb::getLesFraisForfait($idVisiteur,$mois);
        $view = view('majFraisForfait')
                ->with('lesFrais', $lesFrais)
                ->with('numMois',$anneeMois['numMois'])
                ->with('erreurs',null)
                ->with('numAnnee',$anneeMois['numAnnee'])
                ->with('visiteur',$visiteur)
                ->with('message',"")
                ->with ('method',$request->method());
        return $view;
    }
    function sauvegarderFrais(FraisRequest $request){
        $redirect = $this->checkVisiteurAuth();
        if ($redirect) return $redirect;

        $visiteur = session('visiteur');
        $idVisiteur = $visiteur['id'];
        $anneeMois = MyDate::getAnneeMoisCourant();
        $mois = $anneeMois['mois'];
        $lesFrais = $request->validated()['lesFrais'];
        $lesLibFrais = $request->validated()['lesLibFrais'];
        $nbNumeric = 0;
        foreach($lesFrais as $unFrais){
            if(is_numeric($unFrais))
                $nbNumeric++;
        }
        $view = view('majFraisForfait')->with('lesFrais', $lesFrais)
                ->with('numMois',$anneeMois['numMois'])
                ->with('numAnnee',$anneeMois['numAnnee'])
                ->with('visiteur',$visiteur)
                ->with('lesLibFrais',$lesLibFrais)
                ->with ('method',$request->method());
        if($nbNumeric == 4){
            $message = "Votre fiche a été mise à jour";
            $erreurs = null;
            PdoGsb::majFraisForfait($idVisiteur,$mois,$lesFrais);
    	}
	    else{
            $erreurs[] ="Les valeurs des frais doivent être numériques";
            $message = '';
        }
        return $view->with('erreurs',$erreurs)
                    ->with('message',$message);
    }

    public function majFraisForfait($idVisiteur, $mois, $lesFrais)
    {
        // Utilisation de l'ORM Eloquent
        foreach ($lesFrais as $idFrais => $quantite) {
            Frais::where('idvisiteur', $idVisiteur)
                ->where('mois', $mois)
                ->where('idfrais', $idFrais)
                ->update(['quantite' => $quantite]);
        }
    }

    function selectionnerMois() {
        $redirect = $this->checkVisiteurAuth();
        if ($redirect) return $redirect;
        
        $visiteur = session('visiteur');
        $idVisiteur = $visiteur['id'];
        $lesMois = PdoGsb::getLesMoisDisponibles($idVisiteur);
        
        // Si le visiteur n'a encore aucune fiche
        if (empty($lesMois)) {
            $lesMois = [];
            $message = "Pas de fiche de frais pour ce visiteur";
        } else {
            $message = '';
        }
        
        return view('listemois')
               ->with('lesMois', $lesMois)
               ->with('visiteur', $visiteur)
               ->with('message', $message);
    }

    function voirFrais(Request $request) {
        $redirect = $this->checkVisiteurAuth();
        if ($redirect) return $redirect;
        
        $idVisiteur = session('visiteur')['id'];
        $leMois = $request['lstMois']; 
        $lesMois = PdoGsb::getLesMoisDisponibles($idVisiteur);
        $lesFraisForfait = PdoGsb::getLesFraisForfait($idVisiteur, $leMois);
        $lesInfosFicheFrais = PdoGsb::getLesInfosFicheFrais($idVisiteur, $leMois);
        $numAnnee = substr($leMois, 0, 4);
        $numMois = substr($leMois, 4, 2);
        
        return view('listefrais')
               ->with('lesMois', $lesMois)
               ->with('lesFraisForfait', $lesFraisForfait)
               ->with('lesInfosFicheFrais', $lesInfosFicheFrais)
               ->with('numAnnee', $numAnnee)
               ->with('numMois', $numMois)
               ->with('visiteur', session('visiteur'));
    }
}














