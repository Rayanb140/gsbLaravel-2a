@extends('modeles.gestionnaire')
@section('menu')
    @include('partials.gestionnaire_menu')
@endsection
@section('contenu1')
<div id="contenu">
    <!-- Titre principal -->
    <h2 class="dashboard-title">
        <i class="fas fa-tachometer-alt dashboard-icon"></i>
        Bienvenue dans votre espace gestionnaire
    </h2>

    <!-- Bannière d'information -->
    <div class="info-banner">
        <div class="ribbon">DÉMO</div>
        <div class="info-content">
            <i class="fas fa-info-circle info-icon"></i>
            <p>
                <strong>Projet à but scolaire.</strong>
                Certaines données affichées ne sont pas représentatives de la réalité.
            </p>
        </div>
    </div>

    <!-- Bannière de bienvenue -->
    <div class="welcome-banner">
        <div class="welcome-icon">
            <i class="fas fa-user-tie"></i>
        </div>
        <div class="welcome-text">
            <h3>Bonjour {{ $gestionnaire['prenom'] ?? 'Gestionnaire' }},</h3>
            <p>Bienvenue sur votre espace administrateur. Vous pouvez gérer les visiteurs, valider leurs fiches de frais et suivre les remboursements.</p>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="stats-container">
        <!-- 1ère carte : Visiteurs -->
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--role-color);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $nbVisiteurs ?? 0 }}</span>
                <span class="stat-label">Visiteurs</span>
            </div>
        </div>

        <!-- 2ème carte : Fiches à valider -->
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--role-color-secondary);">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $nbFichesAValider ?? 0 }}</span>
                <span class="stat-label">Fiches à valider</span>
            </div>
        </div>

        <!-- 3ème carte : Montant total -->
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--role-color-accent);">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $montantTotal ?? 0 }}</span>
                <span class="stat-label">Montant total (€)</span>
            </div>
        </div>
    </div>

    <!-- Actions rapides et rappels -->
    <div class="action-cards">
        <!-- Actions rapides -->
        <div class="action-card">
            <h4><i class="fas fa-tasks"></i> Actions rapides</h4>
            <div class="quick-actions">
                <a href="{{ route('chemin_liste_visiteurs') }}" class="quick-action-btn">
                    <i class="fas fa-users"></i> Gérer les visiteurs
                </a>
                <a href="{{ route('chemin_ajout_visiteur') }}" class="quick-action-btn">
                    <i class="fas fa-check-circle"></i> Ajouter un visiteur
                </a>
                <a href="{{ route('chemin_pdf_visiteurs') }}" class="quick-action-btn">
                    <i class="fas fa-file-pdf"></i> Exporter en PDF
                </a>
            </div>
        </div>

        <!-- Rappels -->
        <div class="action-card">
            <h4><i class="fas fa-bell"></i> Rappels</h4>
            <ul class="reminder-list">
                <li><i class="fas fa-check-circle text-success"></i> Validation des fiches avant le 20 du mois</li>
                <li><i class="fas fa-info-circle text-primary"></i> Signaler les demandes non conformes</li>
                <li><i class="fas fa-exclamation-circle text-warning"></i> Vérifier les justificatifs obligatoires</li>
            </ul>
        </div>
    </div>

    <!-- Tableau des dernières fiches -->
    <div class="recent-additions">
        <h4><i class="fas fa-file-invoice-dollar"></i> Dernières fiches à traiter</h4>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Visiteur</th>
                        <th>Mois</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($dernieresFiches) && count($dernieresFiches) > 0)
                        @foreach($dernieresFiches as $fiche)
                            <tr>
                                <td>{{ $fiche['visiteur'] ?? 'John Doe' }}</td>
                                <td>{{ $fiche['mois'] ?? 'Mars 2023' }}</td>
                                <td>{{ $fiche['montant'] ?? '120,50' }} €</td>
                                <td>
                                    <span class="badge badge-{{ 
                                        $fiche['statut'] == 'Validée' ? 'success' : 
                                        ($fiche['statut'] == 'En attente' ? 'warning' : 'info')
                                    }}">
                                        {{ $fiche['statut'] ?? 'En cours' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="#" class="table-action-btn"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="table-action-btn"><i class="fas fa-check"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">Aucune fiche récente à afficher</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script d'animation pour les compteurs -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.stat-value').forEach(function(el) {
        const target = parseInt(el.textContent);
        let count = 0;
        const step = Math.max(1, Math.floor(target / 30));
        const timer = setInterval(function() {
            count += step;
            if(count >= target) {
                el.textContent = target;
                clearInterval(timer);
            } else {
                el.textContent = count;
            }
        }, 50);
    });
});
</script>

<!-- Style unifié : bleu pour le gestionnaire -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

:root {
  /* Couleurs pour le gestionnaire */
  --role-color: #3498db;          /* Bleu principal */
  --role-color-secondary: #2ecc71;/* Vert secondaire */
  --role-color-accent: #f39c12;   /* Orange accent */
  --text-color: #2c3e50;
  --subtext-color: #7f8c8d;
  --bg-color: #f0f2f5;
  --white: #ffffff;
}

body {
  font-family: 'Poppins', sans-serif;
  background: var(--bg-color);
  margin: 0; 
  padding: 0;
}

#contenu {
  max-width: 1200px;
  margin: 40px auto;
  padding: 30px;
  background: var(--white);
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Titre principal */
.dashboard-title {
  display: flex;
  align-items: center;
  font-size: 24px;
  margin-bottom: 25px;
  color: var(--text-color);
  font-weight: 600;
}
.dashboard-icon {
  margin-right: 15px;
  font-size: 28px;
  color: var(--role-color);
}

/* Bannière d'information */
.info-banner {
  position: relative;
  background: #fff8ee;
  border-left: 5px solid var(--role-color-accent);
  padding: 20px;
  margin-bottom: 20px;
  border-radius: 5px;
}
.ribbon {
  position: absolute;
  top: 10px; 
  left: -40px;
  background: var(--role-color-accent);
  color: var(--white);
  padding: 5px 20px;
  transform: rotate(-45deg);
  font-size: 12px; 
  font-weight: bold;
}
.info-content {
  display: flex;
  align-items: center;
  gap: 15px;
}
.info-icon {
  font-size: 28px;
  color: var(--role-color-accent);
}
.info-content p {
  margin: 0;
  font-size: 15px;
  color: var(--text-color);
}

/* Bannière de bienvenue */
.welcome-banner {
  display: flex;
  align-items: center;
  background: var(--white);
  border-left: 5px solid var(--role-color);
  padding: 25px;
  margin-bottom: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  transition: transform 0.3s;
}
.welcome-banner:hover {
  transform: translateY(-3px);
}
.welcome-icon {
  background: var(--role-color);
  color: var(--white);
  width: 60px; 
  height: 60px;
  border-radius: 50%;
  display: flex; 
  align-items: center; 
  justify-content: center;
  font-size: 28px;
  margin-right: 20px;
}
.welcome-text h3 {
  margin: 0 0 8px;
  font-size: 20px;
  color: var(--text-color);
}
.welcome-text p {
  margin: 0;
  font-size: 15px;
  color: var(--subtext-color);
}

/* Cartes de statistiques */
.stats-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-bottom: 25px;
}
.stat-card {
  flex: 1; 
  min-width: 200px;
  background: var(--white);
  padding: 20px;
  border-radius: 5px;
  display: flex; 
  align-items: center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  transition: transform 0.3s;
}
.stat-card:hover {
  transform: translateY(-3px);
}
.stat-icon {
  width: 50px; 
  height: 50px;
  border-radius: 5px;
  color: var(--white);
  font-size: 22px;
  display: flex; 
  align-items: center; 
  justify-content: center;
  margin-right: 15px;
}
.stat-value {
  font-size: 24px; 
  font-weight: 600; 
  color: var(--text-color);
}
.stat-label {
  font-size: 14px; 
  color: var(--subtext-color);
}

/* Actions rapides et rappels */
.action-cards {
  display: flex; 
  flex-wrap: wrap;
  gap: 20px;
  margin-bottom: 25px;
}
.action-card {
  flex: 1; 
  min-width: 280px;
  background: var(--white);
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.action-card h4 {
  margin: 0 0 15px;
  font-size: 18px; 
  font-weight: 600;
  color: var(--text-color);
  display: flex; 
  align-items: center;
  gap: 8px;
}
.quick-actions {
  display: flex; 
  gap: 15px; 
  flex-wrap: wrap;
}
.quick-action-btn {
  display: inline-flex; 
  align-items: center;
  background: var(--bg-color);
  border: 2px solid var(--role-color);
  color: var(--role-color);
  padding: 8px 15px;
  border-radius: 5px;
  font-size: 14px; 
  text-decoration: none;
  transition: background 0.3s, color 0.3s;
}
.quick-action-btn i {
  margin-right: 6px;
}
.quick-action-btn:hover {
  background: var(--role-color);
  color: var(--white);
}
.reminder-list {
  list-style: none;
  padding: 0; 
  margin: 0;
  font-size: 14px;
}
.reminder-list li {
  margin-bottom: 8px;
  color: var(--text-color);
}

/* Tableau des fiches */
.recent-additions {
  background: var(--white);
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.recent-additions h4 {
  margin: 0 0 15px;
  font-size: 18px; 
  font-weight: 600;
  color: var(--text-color);
  display: flex; 
  align-items: center;
  gap: 8px;
}
.table-container {
  overflow-x: auto;
}
.data-table {
  width: 100%; 
  border-collapse: collapse;
}
.data-table th, 
.data-table td {
  padding: 12px 15px; 
  text-align: left;
  font-size: 14px;
  border-bottom: 1px solid #eee;
}
.data-table th {
  background: var(--bg-color);
  color: var(--text-color);
  font-weight: 500;
}
.data-table tr:hover {
  background: #fafafa;
}
.table-action-btn {
  display: inline-flex; 
  align-items: center; 
  justify-content: center;
  width: 35px; 
  height: 35px;
  border-radius: 5px;
  color: var(--role-color);
  background: var(--bg-color);
  border: 2px solid var(--role-color);
  text-decoration: none;
  margin-right: 5px;
  transition: background 0.3s, color 0.3s;
}
.table-action-btn:hover {
  background: var(--role-color);
  color: var(--white);
}

/* Badges */
.badge-success {
  background: #ecf9f1; 
  color: #27ae60;
  padding: 3px 6px; 
  border-radius: 4px; 
  font-size: 13px;
}
.badge-warning {
  background: #fef6e7; 
  color: #f39c12;
  padding: 3px 6px; 
  border-radius: 4px; 
  font-size: 13px;
}
.badge-info {
  background: #e8f1fc; 
  color: #3498db;
  padding: 3px 6px; 
  border-radius: 4px; 
  font-size: 13px;
}

/* Couleurs de texte */
.text-success { color: #27ae60; }
.text-primary { color: var(--role-color); }
.text-warning { color: #f39c12; }
.text-center { text-align: center; }
</style>
@endsection
