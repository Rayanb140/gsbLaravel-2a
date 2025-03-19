# GSB Laravel - Application de Gestion des Frais

Application de gestion des frais pour Galaxy Swiss Bourdin, développée avec le framework Laravel.

## Contexte du projet

### Activités du portefeuille de compétences
• Participer à l'évolution d'un site Web exploitant les données de l'organisation
• Analyser les objectifs et les modalités d'organisation d'un projet
• Planifier les activités
• Évaluer les indicateurs de suivi d'un projet et analyser les écarts
• Réaliser les tests d'intégration et d'acceptation d'un service

### Cahier des charges
#### Définition de l'objet
Le suivi des frais est actuellement géré de plusieurs façons selon le laboratoire d'origine des visiteurs.
On souhaite uniformiser cette gestion. L'application doit permettre d'enregistrer tout frais engagé, aussi bien pour l'activité directe
(déplacement, restauration et hébergement) que pour les activités annexes (événementiel,
conférences, autres), et de présenter un suivi daté des opérations menées par le service comptable
(réception des pièces, validation de la demande de remboursement, mise en paiement,
remboursement effectué).

#### Forme de l'objet
L'application Web destinée aux visiteurs, délégués et responsables de secteur sera en ligne,
accessible depuis un ordinateur. La partie utilisée par les services comptables sera aussi sous forme d'une interface Web.

#### Accessibilité/Sécurité
L'environnement doit être accessible aux seuls acteurs de l'entreprise.
Une authentification préalable sera nécessaire pour l'accès au contenu.

#### Contraintes
**Architecture** : L'application respectera l'architecture MVC.  
**Ergonomie** : Les pages fournies ont été définies suite à une consultation et constituent une référence ergonomique.  
**Environnement** : Le langage de script côté serveur doit être le même que celui utilisé dans les pages fournies.

#### Modules
L'application présente trois modules :
• Enregistrement et suivi par les visiteurs (code fourni)
• Enregistrement des opérations par les comptables
• Gestion des visiteurs

### Spécifications fonctionnelles
Cette application web est destinée aux visiteurs médicaux et personnels du service comptable. Les visiteurs peuvent renseigner et consulter leurs états de frais, tandis que le service comptable réalise le suivi des états de frais jusqu'à leur règlement et gère les visiteurs.

#### Cas d'utilisation : Se connecter (Gestionnaire)
**Scénario nominal :**
1. Le système affiche un formulaire de connexion
2. L'utilisateur saisit son login et son mot de passe et valide
3. Le système contrôle les informations de connexion, informe que le profil gestionnaire est activé, et maintient affichée l'identité du gestionnaire. Seules les options du gestionnaire sont accessibles

**Exceptions :**
- 3-a : le nom et/ou le mot de passe n'est pas validé
  - 3-a.1 Le système en informe l'utilisateur ; retour à l'étape 1
- 4- L'utilisateur demande à se déconnecter
- 5- Le système déconnecte l'utilisateur

## Installation et Mise en oeuvre

### Installation
La première étape consiste à installer une version standard de LARAVEL. Pour cela, il est plus facile d'utiliser 
l'application **composer**. Pour tester si composer est actif saisir dans le terminal :
> composer -V

S'il n'y a rien et que vous utilisez Laragon allez dans le repertoire de composer en saisissant :
>cd le/chemin/de/composer

Une fois **composer** identifié saisissez :
> composer selfupdate

Composer sera mis à jour. En cas d'erreur, rien de grave, vous pouvez continuer le process.
* Déplacez-vous pour aller dans le répertoire de publication (www sous Windows).
* Ouvrez une console dans ce répertoire. Saisissez la première fois :
> composer create-project --prefer-dist laravel/laravel gsbLaravel

### Copie des fichiers de gsb
* Téléchargez gsb-laravel-master
* Copiez les fichiers du zip dans votre répertoire
* Répondez que vous voulez modifier à chaque fois que la question est posée.
* Il faudra modifier si nécessaire les paramètres de connexion du fichier d'environnement :
>  .env
* Allez dans le repertoire `gsbLaravel` et saisir
>php artisan migrate

## Bugs à l'utilisation
### Erreur 404
Une fois installé, avec laragon, vous pouvez rencontrer des erreurs avec les routes (erreur 404).  
Dans ce cas, il faut lancer le serveur interne de laravel.
1. Lancer le terminal
2. se déplacer dans le répertoire ou se trouve gsbLaravel
3. saisir : `php artisan serve`
4. Dans le navigateur saisir http://127.0.0.1:8000 

### Pas d'erreur affichée
Dans certains cas l'application "tourne" sans afficher d'erreurs.
Avec Laragon choisissez :
* le serveur apache
* la version 8.x.x de php

## Debugger votre programme
1. L'instruction **dd()** affiche les données passées en paramètre et stoppe le programme
2. L'instruction **dump()** affiche les données passées en paramètre et continue l'exécution
3. L'instruction **@dump()** a la même fonctionnalité que **dump()** mais s'exécute dans la vue.
4. Les logs sont visibles dans le répertoire **storage/logs**
5. Si la page d'erreur n'apparait pas, vous pouvez installer telescope : `php artisan telescope:install` 

2 outils pour debugger :
#### [laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)
> composer require barryvdh/laravel-debugbar --dev
#### [laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
> composer require --dev barryvdh/laravel-ide-helper

Cela donne accès à des commandes **artisan**
## Exemple créer une page test
Cet Exemple est valable pour le visiteur, à vous de l'adapter pour un autre type d'intervenant. 
### Étape 1 créer le lien dans le sommaire
```
<li class="smenu">  
<a href="{{ route('chemin_test') }}" title="test">test</a> 
</li>
```
### Étape 2 créer la route
Ici, on affiche des données, d'où la méthode GET.
```
Route::controller(etatFraisController::class)->group(function () {
  ...
 Route::get('/test', 'test')->name('chemin_test');
});

```
### Étape 31 Ajouter une méthode au contrôleur EtatFraisController
```
function test(){ 
    if( session('visiteur')!= null){    //Sans la session l'insertion du sommaire  
    $visiteur = session('visiteur');    //provoque une erreur 
    $idVisiteur = $visiteur['id']; 
    return view('test') ->with('visiteur',$visiteur); 
    } 
    else{ 
        return view('connexion')->with('erreurs',null); 
    } 
}
```
### Étape 32 Ajouter une méthode à un nouveau contrôleur
Dans ce cas il est préférable de créer le contrôleur avec **artisan**
>php artisan make:controller MonController

La suite est identique :
```
function test(){ 
    if( session('visiteur')!= null){    //Sans la session l'insertion du sommaire  
    $visiteur = session('visiteur');    //provoque une erreur 
    $idVisiteur = $visiteur['id']; 
    return view('test') ->with('visiteur',$visiteur); 
    } 
    else{ 
        return view('connexion')->with('erreurs',null); 
    } 
}
```
### Étape 4 Créer la vue 
```
@extends ('sommaire') 
    @section('contenu1') 
     <h1>titre</h1> 
    @endsection 
```
