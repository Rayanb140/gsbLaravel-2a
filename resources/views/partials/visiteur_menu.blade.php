<!-- Division pour le sommaire -->
<div id="menuGauche">
    <div id="infosUtil">
          
    </div>  
    <ul id="menuList">
        <li>
            <strong><i class="fas fa-user-circle"></i> Bonjour {{ $visiteur['nom'] . ' ' . $visiteur['prenom'] }}</strong>
        </li>
        <li class="smenu">
            <a href="{{ route('visiteurAccueil') }}" title="Tableau de bord" class="{{ request()->routeIs('sommaire') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Tableau de bord
            </a>
        </li>
        <li class="smenu">
            <a href="#" title="Gérer mes frais" onclick="toggleSubMenu(event, this)" class="{{ request()->routeIs('chemin_gestionFrais') || request()->routeIs('chemin_selectionMois') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> Gérer mes frais
                <i class="fas fa-chevron-down"></i>
            </a>
            <ul class="submenu" style="{{ (request()->routeIs('chemin_gestionFrais') || request()->routeIs('chemin_selectionMois')) ? 'display:block' : '' }}">
                <li>
                    <a href="{{ route('chemin_gestionFrais') }}" title="Saisie de frais" class="{{ request()->routeIs('chemin_gestionFrais') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle"></i> Saisir des frais
                    </a>
                </li>
                <li>
                    <a href="{{ route('chemin_selectionMois') }}" title="Mes fiches de frais" class="{{ request()->routeIs('chemin_selectionMois') ? 'active' : '' }}">
                        <i class="fas fa-list-alt"></i> Mes fiches de frais
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