@extends('modeles/visiteur')
@section('menu')
    @include('partials.visiteur_menu')
@endsection
@section('contenu1')
<div id="contenu">
    <h2>Renseigner ma fiche de frais du mois {{ $numMois }}-{{ $numAnnee }}</h2>
    <form method="post"  action="{{ route('chemin_sauvegardeFrais') }}">
        @csrf <!-- laravel va ajouter un champ caché avec un token -->
        <div class="corpsForm">
            <fieldset>
                <legend>Eléments forfaitisés</legend>
                 
                @foreach($lesFraisForfait as $unFrais)
                    <p>
                    <input type = "hidden" name = "lesLibFrais[]"
                            @if($unFrais['idfrais'] == 'ETP')
                            value = "Forfait Etape"
                            @elseif($unFrais['idfrais'] == 'KM')
                            value = "Frais Kilométrique"
                            @elseif($unFrais['idfrais'] == 'NUI')
                            value = "Nuitée Hôtel"
                            @elseif($unFrais['idfrais'] == 'REP')
                            value = "Repas Restaurant"
                            @endif> 
                    <label name = "libelle" for="idFrais">
                            @if($unFrais['idfrais'] == 'ETP')
                                Forfait Etape
                            @elseif($unFrais['idfrais'] == 'KM')
                                Frais Kilométrique
                            @elseif($unFrais['idfrais'] == 'NUI')
                                Nuitée Hôtel
                            @elseif($unFrais['idfrais'] == 'REP')
                                Repas Restaurant
                            @endif
                    </label>
                    <input type="text" required
                            @if($unFrais['idfrais'] == 'ETP')
                                name = "lesFrais[ETP]"
                    @elseif($unFrais['idfrais'] == 'KM')
                                name = "lesFrais[KM]"
                    @elseif($unFrais['idfrais'] == 'NUI')
                                name = "lesFrais[NUI]"
                    @elseif($unFrais['idfrais'] == 'REP')
                                name = "lesFrais[REP]"
                    @endif
                         value = "{{ $unFrais['quantite'] }}"
                         
                      >
                        </p>
                @endforeach
            </fieldset>
        </div>
        <div class="piedForm">
            <p>
            <input id="ok" type="submit" value="Valider" size="20" />
            <input id="annuler" type="reset" value="Annuler" size="20" />
            </p> 
        </div>
    </form>
</div>
@endsection 