<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;

class gestionnaireController extends Controller
{
    function connecter(){
        return view('connexionGestionnaire')->with('erreurs', null);
    }
    
    function valider(Request $request){
        $login = $request['login'];
        $mdp = $request['mdp'];
        $gestionnaire = PdoGsb::getInfosGestionnaire($login, $mdp);
        
        if(!is_array($gestionnaire)){
            $erreurs[] = "Login ou mot de passe incorrect(s)";
            return view('connexionGestionnaire')->with('erreurs', $erreurs);
        }
        else{
            session(['gestionnaire' => $gestionnaire]);
            return redirect()->route('sommaire_gestionnaire');
        }
    }
    
    function deconnecter(){
        session(['gestionnaire' => null]);
        return redirect()->route('chemin_connexion_gestionnaire');
    }
} 