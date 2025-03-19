@extends('modeles.gestionnaire')

@section('menu')
    @include('partials.gestionnaire_menu')
@endsection 

@section('contenu1')
<div id="contenu">
    <h2><i class="fas fa-user-plus"></i> Ajouter un visiteur</h2>
    
    <div class="form-container">
        <div class="action-buttons">
            <a href="{{ route('chemin_liste_visiteurs') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
        
        @includeWhen($erreurs != null, 'msgerreurs', ['erreurs' => $erreurs])
        
        <form method="post" action="{{ route('chemin_ajouter_visiteur') }}" id="formAjoutVisiteur">
            {{ csrf_field() }}
            
            <div class="corpsForm">
                <fieldset>
                    <legend>Informations visiteur</legend>
                    <p>
                        <label for="nom">Nom<span class="mandatory">*</span></label>
                        <input id="nom" type="text" name="nom" value="{{ old('nom') }}" required>
                    </p>
                    
                    <p>
                        <label for="prenom">Prénom<span class="mandatory">*</span></label>
                        <input id="prenom" type="text" name="prenom" value="{{ old('prenom') }}" required>
                    </p>
                    
                    <p>
                        <label for="adresse">Adresse<span class="mandatory">*</span></label>
                        <input id="adresse" type="text" name="adresse" value="{{ old('adresse') }}" required>
                    </p>
                    
                    <p>
                        <label for="cp">Code postal<span class="mandatory">*</span></label>
                        <input id="cp" type="text" name="cp" value="{{ old('cp') }}" required>
                    </p>
                    
                    <p>
                        <label for="ville">Ville<span class="mandatory">*</span></label>
                        <input id="ville" type="text" name="ville" value="{{ old('ville') }}" required>
                    </p>
                    
                    <p>
                        <label for="dateEmbauche">Date d'embauche<span class="mandatory">*</span></label>
                        <input id="dateEmbauche" type="date" name="dateEmbauche" value="{{ old('dateEmbauche') }}" required>
                    </p>
                </fieldset>
                
                <p class="form-note">
                    Le login sera généré automatiquement (première lettre du prénom + nom).<br>
                    Un identifiant et un mot de passe seront également générés automatiquement.
                </p>
            </div>
            
            <div class="piedForm">
                <input id="ok" type="submit" value="Ajouter" size="20">
                <button id="annuler" type="button" onclick="reinitialiserFormulaire()" size="20">Effacer</button>
            </div>
        </form>
    </div>
</div>

<script>
function reinitialiserFormulaire() {
    // Sélectionner tous les champs du formulaire et les vider
    document.getElementById('nom').value = '';
    document.getElementById('prenom').value = '';
    document.getElementById('adresse').value = '';
    document.getElementById('cp').value = '';
    document.getElementById('ville').value = '';
    document.getElementById('dateEmbauche').value = '';
    
    // Focus sur le premier champ
    document.getElementById('nom').focus();
}
</script>
@endsection 