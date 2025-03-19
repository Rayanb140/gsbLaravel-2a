@extends ('modeles/visiteur')
@section('menu')
    @include('partials.visiteur_menu')
@endsection
@section('contenu1')
<div id="contenu">
    <h2 class="form-title">
        <i class="fas fa-receipt form-icon"></i>Saisie de frais
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
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-coins"></i> Frais forfaitaires</h3>
            
            <form method="post" action="{{ route('chemin_sauvegardeFrais') }}">
                @csrf
                
                <div class="forfaits-grid">
                    @foreach($lesFrais as $unFrais)
                    <div class="forfait-item">
                        <div class="forfait-icon">
                            @if($unFrais['idfrais'] == 'ETP')
                                <i class="fas fa-parking"></i>
                            @elseif($unFrais['idfrais'] == 'KM')
                                <i class="fas fa-car"></i>
                            @elseif($unFrais['idfrais'] == 'NUI')
                                <i class="fas fa-bed"></i>
                            @elseif($unFrais['idfrais'] == 'REP')
                                <i class="fas fa-utensils"></i>
                            @else
                                <i class="fas fa-receipt"></i>
                            @endif
                        </div>
                        <div class="forfait-content">
                            <label for="frais_{{ $unFrais['idfrais'] }}">{{ $unFrais['libelle'] }}</label>
                            <input type="text" id="frais_{{ $unFrais['idfrais'] }}" 
                                   name="lesFrais[{{ $unFrais['idfrais'] }}]" 
                                   size="10" maxlength="5" 
                                   value="{{ $unFrais['quantite'] }}"
                                   class="form-control">
                            <input type="hidden" name="lesLibFrais[{{ $unFrais['idfrais'] }}]" 
                                   value="{{ $unFrais['libelle'] }}">
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Annuler
                    </button>
                </div>
            </form>
        </div>
        
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-file-invoice-dollar"></i> Frais hors forfait</h3>
            
            <div class="hf-list">
                @if(count($lesFraisHorsForfait) == 0)
                    <p class="empty-state">Aucun frais hors forfait enregistré pour cette période.</p>
                @else
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Libellé</th>
                                <th>Montant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lesFraisHorsForfait as $unFraisHorsForfait)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($unFraisHorsForfait['date'])->format('d/m/Y') }}</td>
                                <td>{{ $unFraisHorsForfait['libelle'] }}</td>
                                <td>{{ number_format($unFraisHorsForfait['montant'], 2, ',', ' ') }} €</td>
                                <td>
                                    <a href="#" class="table-action-btn">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="table-action-btn table-action-btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            
            <form method="post" action="{{ route('chemin_sauvegardeFrais') }}">
                @csrf
                <input type="hidden" name="typefrais" value="hf">
                
                <div class="form-section-title">Ajouter un frais hors forfait</div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="dateFrais">Date</label>
                        <input type="date" id="dateFrais" name="dateFrais" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="libelle">Libellé</label>
                        <input type="text" id="libelle" name="libelle" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="montant">Montant</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0" id="montant" name="montant" class="form-control" required>
                            <div class="input-group-append">
                                <span class="input-group-text">€</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Styles généraux du formulaire */
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
    color: #27ae60;
}

.form-container {
    margin-bottom: 30px;
}

.form-section {
    background-color: white;
    border-radius: 8px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    margin-bottom: 25px;
}

.section-title {
    font-size: 18px;
    color: #34495e;
    margin-top: 0;
    margin-bottom: 20px;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.section-title i {
    margin-right: 10px;
    color: #27ae60;
}

.forfaits-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.forfait-item {
    display: flex;
    align-items: center;
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    transition: all 0.3s;
    border: 1px solid #f1f1f1;
}

.forfait-item:hover {
    background-color: #f5fff9;
    border-color: #d2ffd5;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
}

.forfait-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #e6ffef;
    border-radius: 8px;
    margin-right: 15px;
    color: #27ae60;
}

.forfait-content {
    flex: 1;
}

.forfait-content label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #2c3e50;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #dce4ec;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.2s;
    background-color: white;
}

.form-control:focus {
    border-color: #27ae60;
    outline: none;
    box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
}

.form-row {
    display: flex;
    margin-bottom: 20px;
    gap: 20px;
}

.form-group {
    flex: 1;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #2c3e50;
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 25px;
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
}

.alert-success {
    background-color: #e6f7ef;
    color: #27ae60;
    border-left: 4px solid #27ae60;
}

.alert-danger {
    background-color: #fdf0f0;
    color: #e74c3c;
    border-left: 4px solid #e74c3c;
}

.alert-icon {
    margin-right: 10px;
    font-size: 16px;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 18px;
    border-radius: 6px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    min-width: 120px;
}

.btn i {
    margin-right: 8px;
}

.btn-primary {
    background-color: #27ae60;
    color: white;
}

.btn-primary:hover {
    background-color: #219653;
    box-shadow: 0 4px 10px rgba(39, 174, 96, 0.3);
}

.btn-secondary {
    background-color: #f1f5f9;
    color: #34495e;
}

.btn-secondary:hover {
    background-color: #e3e8ed;
    color: #2c3e50;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.form-section-title {
    font-size: 16px;
    color: #34495e;
    margin-bottom: 15px;
    font-weight: 500;
    padding-bottom: 10px;
    border-bottom: 1px solid #f1f1f1;
}

.input-group {
    display: flex;
    align-items: center;
}

.input-group-append {
    margin-left: -1px;
}

.input-group-text {
    display: flex;
    align-items: center;
    padding: 10px 12px;
    background-color: #f8f9fa;
    border: 1px solid #dce4ec;
    border-left: none;
    border-radius: 0 4px 4px 0;
    color: #7f8c8d;
}

.empty-state {
    color: #7f8c8d;
    font-style: italic;
    text-align: center;
    padding: 30px 0;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 25px;
}

.data-table th,
.data-table td {
    padding: 12px 15px;
    text-align: left;
}

.data-table th {
    background-color: #f8f9fa;
    color: #2c3e50;
    font-weight: 500;
}

.data-table tr {
    border-bottom: 1px solid #f1f1f1;
}

.data-table tr:last-child {
    border-bottom: none;
}

.data-table tr:hover {
    background-color: #f8f9fa;
}

.table-action-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 30px;
    height: 30px;
    border-radius: 4px;
    color: #27ae60;
    text-decoration: none;
    transition: all 0.3s;
    background-color: #f7f9fc;
    margin-right: 5px;
}

.table-action-btn:hover {
    background-color: #27ae60;
    color: white;
}

.table-action-btn-danger {
    color: #e74c3c;
    background-color: #fdf0f0;
}

.table-action-btn-danger:hover {
    background-color: #e74c3c;
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
    }
    
    .form-group {
        width: 100%;
    }
    
    .forfaits-grid {
        grid-template-columns: 1fr;
    }
    
    .data-table {
        display: block;
        overflow-x: auto;
    }
}
</style>
@endsection 