@extends ('modeles/visiteur')
@section('menu')
    @include('partials.visiteur_menu')
@endsection
@section('contenu1')
<div id="contenu">
    <h2 class="form-title">
        <i class="fas fa-edit form-icon"></i>Modification des frais forfaitaires
    </h2>
    
    <!-- Messages de statut -->
    @includeWhen($erreurs != null, 'msgerreurs', ['erreurs' => $erreurs]) 
    @includeWhen($message != "", 'message', ['message' => $message])
    
    <div class="form-container">
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-coins"></i> Éléments forfaitisés</h3>
            
            <form method="post" action="{{ route('chemin_sauvegardeFrais') }}">
                @csrf
                
                <div class="forfaits-grid">
                    @foreach ($lesFrais as $key => $frais)
                    <div class="forfait-item">
                        <div class="forfait-icon">
                            @if(isset($frais['idfrais']) && $frais['idfrais'] == 'ETP')
                                <i class="fas fa-parking"></i>
                            @elseif(isset($frais['idfrais']) && $frais['idfrais'] == 'KM')
                                <i class="fas fa-car"></i>
                            @elseif(isset($frais['idfrais']) && $frais['idfrais'] == 'NUI')
                                <i class="fas fa-bed"></i>
                            @elseif(isset($frais['idfrais']) && $frais['idfrais'] == 'REP')
                                <i class="fas fa-utensils"></i>
                            @else
                                <i class="fas fa-receipt"></i>
                            @endif
                        </div>
                        <div class="forfait-content">
                            <input type="hidden" name="lesLibFrais[]" 
                                   value="{{ $method == 'GET' ? $frais['libelle'] : $lesLibFrais[$loop->index] }}">
                            <label for="frais_{{ $loop->index }}">
                                {{ $method == 'GET' ? $frais['libelle'] : $lesLibFrais[$loop->index] }}
                            </label>
                            <input type="text" id="frais_{{ $loop->index }}" 
                                   class="form-control" required
                                   @if($method == 'GET')
                                       name="lesFrais[{{ $frais['idfrais'] }}]"
                                       value="{{ $frais['quantite'] }}"
                                   @else
                                       name="lesFrais[{{ $key }}]"
                                       value="{{ $frais }}"
                                   @endif>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-secondary btn-submit">
                        <i class="fas fa-save"></i> Valider
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Annuler
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
    background-color: #e6ffeF;
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

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 25px;
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

.btn-secondary {
    background-color: #f1f5f9;
    color: #34495e;
}

.btn-secondary:hover {
    background-color: #e3e8ed;
    color: #2c3e50;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.btn-submit {
    background-color: #27ae60;
    color: white;
}

.btn-submit:hover {
    background-color: #219653;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .forfaits-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
