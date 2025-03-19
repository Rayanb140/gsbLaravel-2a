@extends ('modeles/visiteur')
@section('menu')
    @include('partials.visiteur_menu')
@endsection
    @section('contenu1')
      <div id="contenu">
    <h2 class="form-title">
        <i class="fas fa-calendar-alt form-icon"></i>Mes fiches de frais
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
    
    <!-- Conteneur principal -->
    <div class="form-container">
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-search"></i> Sélectionnez un mois</h3>
            
            <form method="post" action="{{ route('chemin_listeFrais') }}">
                @csrf
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="lstMois">Période disponible</label>
                        <select id="lstMois" name="lstMois" class="form-control">
                            @foreach($lesMois as $unMois)
                                <option value="{{ $unMois['mois'] }}" {{ isset($moisSelectionne) && $moisSelectionne == $unMois['mois'] ? 'selected' : '' }}>
                                    {{ $unMois['numMois'] }}/{{ $unMois['numAnnee'] }}{{ isset($unMois['libEtat']) && !empty($unMois['libEtat']) ? ' - '.$unMois['libEtat'] : '' }}
                    </option>
              @endforeach
          </select>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Consulter
                    </button>
                </div>
            </form>
        </div>
        
        @if(isset($lesFraisForfait))
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-file-invoice"></i> Fiche du mois {{ isset($numMois) ? $numMois.'/'.$numAnnee : '' }}</h3>
            
            <div class="fiche-status">
                <div class="status-badge {{ $libEta == 'Validée' ? 'status-validated' : ($libEta == 'Remboursée' ? 'status-reimbursed' : 'status-pending') }}">
                    <i class="fas {{ $libEta == 'Validée' ? 'fa-check-circle' : ($libEta == 'Remboursée' ? 'fa-money-bill-wave' : 'fa-clock') }}"></i>
                    {{ $libEta }}
                </div>
                
                @if($dateModif)
                <div class="status-date">
                    <i class="fas fa-calendar-check"></i> Dernière modification : {{ date('d/m/Y', strtotime($dateModif)) }}
                </div>
                @endif
                
                @if($libEta == 'Remboursée')
                <div class="status-date">
                    <i class="fas fa-check-double"></i> Date de remboursement : {{ date('d/m/Y', strtotime($dateRemb)) }}
                </div>
                @endif
            </div>
            
            <div class="card-title">Éléments forfaitisés</div>
            
            <div class="forfaits-grid">
                @foreach($lesFraisForfait as $unFrais)
                <div class="forfait-item">
                    <div class="forfait-icon">
                        @if($unFrais['idfrais'] == 'ETP')
                            <i class="fas fa-home"></i>
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
                        <div class="forfait-label">{{ $unFrais['libelle'] }}</div>
                        <div class="forfait-value">{{ $unFrais['quantite'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="card-title">Éléments hors forfait</div>
            
            @if(count($lesFraisHorsForfait) == 0)
                <p class="empty-state">Aucun frais hors forfait pour cette période.</p>
            @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Libellé</th>
                            <th>Montant</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lesFraisHorsForfait as $unFraisHorsForfait)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($unFraisHorsForfait['date'])->format('d/m/Y') }}</td>
                            <td>{{ $unFraisHorsForfait['libelle'] }}</td>
                            <td>{{ number_format($unFraisHorsForfait['montant'], 2, ',', ' ') }} €</td>
                            <td>
                                <span class="badge {{ $unFraisHorsForfait['etat'] == 'Validé' ? 'badge-success' : 'badge-info' }}">
                                    {{ $unFraisHorsForfait['etat'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            
            <div class="card-title">Justificatifs</div>
            
            <div class="justify-box">
                <div class="justify-count">
                    <i class="fas fa-paperclip"></i>
                    <span>{{ $nbJustificatifs }} justificatif(s)</span>
                </div>
                
                @if($libEta == 'Validée' || $libEta == 'Remboursée')
                <div class="justify-info">
                    <i class="fas fa-lock"></i>
                    <span>Fiche clôturée - Modifications impossibles</span>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<style>
/* Styles communs - reprendre les mêmes styles que gererFrais.blade.php */
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
    margin-bottom: 0;
    padding-bottom: 0;
}

.section-title {
    font-size: 18px;
    color: #27ae60;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.section-title i {
    margin-right: 10px;
    color: #27ae60;
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
    border-color: #27ae60;
    box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
    outline: none;
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

/* Styles spécifiques à cette page */
.fiche-status {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 25px;
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 50px;
    margin-right: 15px;
}

.status-badge i {
    margin-right: 5px;
}

.status-validated {
    background-color: #e6ffef;
    color: #27ae60;
}

.status-reimbursed {
    background-color: #e8f4f8;
    color: #3498db;
}

.status-pending {
    background-color: #fff5e6;
    color: #f39c12;
}

.status-date {
    color: #7f8c8d;
    margin-right: 15px;
    display: flex;
    align-items: center;
}

.status-date i {
    margin-right: 5px;
}

.card-title {
    font-size: 16px;
    font-weight: 500;
    color: #34495e;
    margin: 20px 0 15px;
    padding-left: 10px;
    border-left: 3px solid #3498db;
}

.forfaits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.forfait-item {
    display: flex;
    align-items: center;
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
    transition: all 0.3s;
}

.forfait-item:hover {
    background-color: #f5fff9;
    transform: translateY(-2px);
}

.forfait-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #e6ffef;
    color: #27ae60;
    border-radius: 50%;
    margin-right: 15px;
    font-size: 18px;
}

.forfait-content {
    flex: 1;
}

.forfait-label {
    font-weight: 500;
    color: #34495e;
    margin-bottom: 5px;
}

.forfait-value {
    font-size: 18px;
    font-weight: 500;
    color: #2c3e50;
}

.empty-state {
    text-align: center;
    padding: 20px;
    color: #7f8c8d;
    font-style: italic;
    background-color: #f9f9f9;
    border-radius: 6px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.data-table th {
    text-align: left;
    padding: 12px 15px;
    background-color: #f8f9fa;
    color: #2c3e50;
    font-weight: 500;
    border-bottom: 2px solid #e9ecef;
}

.data-table td {
    padding: 12px 15px;
    border-bottom: 1px solid #e9ecef;
    color: #333;
}

.data-table tr:hover {
    background-color: #f8f9fa;
}

.badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.badge-success {
    background-color: #e6f7ef;
    color: #27ae60;
}

.badge-info {
    background-color: #e8f4f8;
    color: #3498db;
}

.justify-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
    margin-top: 10px;
}

.justify-count {
    font-weight: 500;
    color: #2c3e50;
    display: flex;
    align-items: center;
}

.justify-count i {
    margin-right: 8px;
    color: #3498db;
}

.justify-info {
    color: #e74c3c;
    display: flex;
    align-items: center;
    font-style: italic;
}

.justify-info i {
    margin-right: 8px;
}

.form-actions {
    display: flex;
    justify-content: flex-start;
    margin-top: 20px;
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
    background-color: #27ae60;
    color: white;
}

.btn-primary:hover {
    background-color: #219653;
    box-shadow: 0 4px 10px rgba(39, 174, 96, 0.3);
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
    
    .fiche-status {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .status-badge,
    .status-date {
        margin-bottom: 10px;
    }
    
    .justify-box {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .justify-info {
        margin-top: 10px;
    }
}
</style>
  @endsection 
 