<!-- Division pour le sommaire -->
<div id="menuGauche">
    <div id="infosUtil">
          
    </div>  
    <ul id="menuList">
        <li>
            <strong><i class="fas fa-user-circle"></i> Bonjour {{ $gestionnaire['nom'] . ' ' . $gestionnaire['prenom'] }}</strong>
        </li>
        <li class="smenu">
            <a href="{{ route('sommaire_gestionnaire') }}" title="Tableau de bord" class="{{ request()->routeIs('sommaire_gestionnaire') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Tableau de bord
            </a>
        </li>
        <li class="smenu">
            <a href="#" title="Gérer les visiteurs" onclick="toggleSubMenu(event, this)" class="{{ request()->routeIs('chemin_liste_visiteurs') || request()->routeIs('chemin_ajout_visiteur') || request()->routeIs('chemin_form_visiteur') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i> Gérer les visiteurs
                <i class="fas fa-chevron-down"></i>
            </a>
            <ul class="submenu" style="{{ (request()->routeIs('chemin_liste_visiteurs') || request()->routeIs('chemin_ajout_visiteur') || request()->routeIs('chemin_form_visiteur')) ? 'display:block' : '' }}">
                <li>
                    <a href="{{ route('chemin_liste_visiteurs') }}" title="Liste des visiteurs" class="{{ request()->routeIs('chemin_liste_visiteurs') ? 'active' : '' }}">
                        <i class="fas fa-list-ul"></i> Liste des visiteurs
                    </a>
                </li>
                <li>
                    <a href="{{ route('chemin_ajout_visiteur') }}" title="Ajouter un visiteur" class="{{ request()->routeIs('chemin_ajout_visiteur') ? 'active' : '' }}">
                        <i class="fas fa-user-plus"></i> Ajouter un visiteur
                    </a>
                </li>
            </ul>
        </li>
        <li class="smenu">
            <a href="#" onclick="confirmerDeconnexion(event)" title="Se déconnecter" class="deconnexion-link">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
        </li>
    </ul>
</div> 