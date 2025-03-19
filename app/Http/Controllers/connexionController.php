<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;
use App\Services\SecurityLogger;

class connexionController extends Controller
{
    function connecter(){
        return view('connexion')->with('erreurs', null);
    }
    
    function valider(Request $request){
        $login = $request['login'];
        $mdp = $request['mdp'];
        
        // Validation des entrées
        $request->validate([
            'login' => 'required|string|max:255',
            'mdp' => 'required|string',
        ]);
        
        $visiteur = PdoGsb::getInfosVisiteur($login, $mdp);
        
        if(!is_array($visiteur)){
            $erreurs[] = "Login ou mot de passe incorrect";
            SecurityLogger::logFailedLogin($login, $request->ip());
            return view('connexion')->with('erreurs', $erreurs);
        }
        else{
            session(['visiteur' => $visiteur]);
            
            // Réinitialiser le compteur de tentatives en cas de succès
            $key = $request->ip() . ':' . $login;
            \Illuminate\Support\Facades\Cache::forget($key);
            
            SecurityLogger::logSuccessfulLogin($login, $request->ip(), 'visiteur');
            return redirect()->route('visiteurAccueil');
        }
    }
    
    function deconnecter(){
        session(['visiteur' => null]);
        return redirect()->route('chemin_connexion');
    }
}
