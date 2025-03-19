@extends('modeles.gestionnaire')

@section('menu')
    @include('partials.gestionnaire_menu')
@endsection

@section('contenu1')
<div id="contenu">
    <h2>Liste des visiteurs</h2>
    
    @if(session('message'))
        <div class="message">{{ session('message') }}</div>
    @endif
    
    @if(session('infoVisiteur'))
        <div class="info-box" style="background-color: #f8f9fa; border: 1px solid #ddd; border-left: 5px solid #28a745; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
            <h3 style="color: #28a745; margin-top: 0;">Informations du nouveau visiteur</h3>
            <p><strong>ID:</strong> {{ session('infoVisiteur')['id'] }}</p>
            <p><strong>Login:</strong> {{ session('infoVisiteur')['login'] }}</p>
            <p><strong>Mot de passe:</strong> <span style="font-family: monospace; background-color: #e9ecef; padding: 2px 6px; border-radius: 3px;">{{ session('infoVisiteur')['mdp'] }}</span></p>
            <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #ddd;">
                <p style="color: #dc3545; font-weight: bold;">Important: Notez ces informations maintenant. Le mot de passe ne sera plus affiché.</p>
            </div>
        </div>
    @endif
    
    <div class="action-buttons">
        <a href="{{ route('chemin_ajout_visiteur') }}" class="btn btn-secondary">
            <i class="fas fa-plus-circle"></i> Ajouter un visiteur
        </a>
        <a href="{{ route('chemin_pdf_visiteurs') }}" class="btn btn-secondary">
            <i class="fas fa-file-pdf"></i> Exporter en PDF
        </a>
    </div>
    
    <table class="listeLegere">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date d'embauche</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lesVisiteurs as $visiteur)
            <tr>
                <td>{{ $visiteur['id'] }}</td>
                <td>{{ $visiteur['nom'] }}</td>
                <td>{{ $visiteur['prenom'] }}</td>
                <td>{{ \Carbon\Carbon::parse($visiteur['dateEmbauche'])->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('chemin_form_visiteur', ['id' => $visiteur['id']]) }}" class="action-link">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 