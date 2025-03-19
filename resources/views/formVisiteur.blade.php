@extends('modeles/gestionnaire')

@section('menu')
    @include('partials.gestionnaire_menu')
@endsection

@section('contenu1')
<div id="contenu">
    <h2 class="form-title">
        <i class="fas fa-user-edit form-icon"></i>Modifier un visiteur
    </h2>
    
    <!-- Message de statut/erreur amélioré -->
    @if(session()->has('message'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle alert-icon"></i>
        {{ session()->get('message') }}
    </div>
    @endif

    @if(session()->has('erreurs'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle alert-icon"></i>
        {{ session()->get('erreurs')[0] }}
    </div>
    @endif
    
    <!-- Formulaire avec style moderne -->
    <div class="form-container">
        <form method="post" action="{{ route('chemin_maj_visiteur') }}">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $leVisiteur['id'] }}">
            
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-id-card"></i> Informations personnelles</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom" class="form-control" value="{{ $leVisiteur['nom'] }}" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" value="{{ $leVisiteur['prenom'] }}" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="login">Login *</label>
                        <input type="text" id="login" name="login" class="form-control" value="{{ $leVisiteur['login'] }}" required>
                    </div>
                    <div class="form-group">
                        <label for="mdp">Mot de passe *</label>
                        <div class="password-field">
                            <input type="password" id="mdp" name="mdp" class="form-control" required>
                            <span class="toggle-password" onclick="togglePasswordVisibility()">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <small class="form-text text-muted">Saisissez le mot de passe à utiliser pour ce visiteur.</small>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-address-book"></i> Coordonnées</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="adresse">Adresse *</label>
                        <input type="text" id="adresse" name="adresse" class="form-control" value="{{ $leVisiteur['adresse'] }}" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="cp">Code postal *</label>
                        <input type="text" id="cp" name="cp" class="form-control" value="{{ $leVisiteur['cp'] }}" required>
                    </div>
                    <div class="form-group">
                        <label for="ville">Ville *</label>
                        <input type="text" id="ville" name="ville" class="form-control" value="{{ $leVisiteur['ville'] }}" required>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-calendar-alt"></i> Date d'embauche</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="dateEmbauche">Date d'embauche *</label>
                        <input type="date" id="dateEmbauche" name="dateEmbauche" class="form-control" value="{{ $leVisiteur['dateEmbauche'] }}" required>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
                <a href="{{ route('chemin_liste_visiteurs') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    const passwordField = document.getElementById('mdp');
    const toggleIcon = document.querySelector('.toggle-password i');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>

<style>
/* Styles pour le formulaire */
.form-title {
    display: flex;
    align-items: center;
    font-size: 24px;
    margin-bottom: 25px;
    color: #2c3e50;
    font-weight: 500;
}

.form-icon {
    margin-right: 12px;
    color: #3498db;
}

.form-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    padding: 30px;
    margin-bottom: 30px;
}

.form-section {
    margin-bottom: 30px;
    border-bottom: 1px solid #f1f1f1;
    padding-bottom: 20px;
}

.form-section:last-child {
    border-bottom: none;
}

.section-title {
    font-size: 18px;
    color: #3498db;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.section-title i {
    margin-right: 10px;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -10px 15px;
}

.form-group {
    flex: 1;
    padding: 0 10px;
    margin-bottom: 15px;
    min-width: 200px;
}

.form-control {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #dce4ec;
    border-radius: 4px;
    font-size: 15px;
    color: #333;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    outline: none;
}

.password-field {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #95a5a6;
    transition: color 0.3s;
}

.toggle-password:hover {
    color: #3498db;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #34495e;
    font-weight: 500;
}

.form-actions {
    display: flex;
    justify-content: flex-start;
    padding-top: 20px;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    border-radius: 4px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
    border: none;
    margin-right: 10px;
}

.btn i {
    margin-right: 8px;
}

.btn-primary {
    background-color: #3498db;
    color: white;
}

.btn-primary:hover {
    background-color: #2980b9;
    box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
}

.btn-secondary {
    background-color: #f1f5f9;
    color: #34495e;
    text-decoration: none;
}

.btn-secondary:hover {
    background-color: #e3e8ed;
    color: #2c3e50;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.alert {
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.alert-icon {
    margin-right: 10px;
    font-size: 18px;
}

.alert-success {
    background-color: #e6f7ef;
    color: #27ae60;
    border-left: 4px solid #27ae60;
}

.alert-danger {
    background-color: #fceef0;
    color: #e74c3c;
    border-left: 4px solid #e74c3c;
}

/* Responsive */
@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
    }
    
    .form-group {
        width: 100%;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>
@endsection 