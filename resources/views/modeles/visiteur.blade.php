<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GSB - Espace Visiteur</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logoIco.ico') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/gestionnaire.css') }}">
    @yield('css')
</head>
<body>
    <div id="entete">
        <div id="logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo GSB" />
            <h1>Gestion des frais - Espace Visiteur</h1>
        </div>
        <div id="user-info">
            @if(isset($visiteur))
                <span>{{ $visiteur['nom'] . ' ' . $visiteur['prenom'] }}</span>
            @endif
        </div>
    </div>
    
    <div id="main">
        @yield('menu')
        <div id="contenu">
            @yield('contenu1')
        </div>
    </div>
    
    <div id="footer">
        &copy; {{ date('Y') }} - Laboratoire Galaxy Swiss Bourdin
    </div>
    
    <!-- Boîte de dialogue de confirmation de déconnexion -->
    <div class="dialog-overlay" id="deconnexionDialog">
        <div class="dialog-box">
            <div class="dialog-title">Confirmation de déconnexion</div>
            <p>Êtes-vous sûr de vouloir vous déconnecter ?</p>
            <div class="dialog-buttons">
                <button class="dialog-btn dialog-btn-cancel" onclick="annulerDeconnexion()">Annuler</button>
                <button class="dialog-btn dialog-btn-confirm" onclick="confirmerDeconnexion()">Se déconnecter</button>
            </div>
        </div>
    </div>
    
    <script>
        // Fonction pour basculer les sous-menus
        function toggleSubMenu(e, element) {
            e.preventDefault();
            const submenu = element.nextElementSibling;
            if (submenu && submenu.classList.contains('submenu')) {
                if (submenu.style.display === 'block') {
                    submenu.style.display = 'none';
                    // Retirer la classe active du lien parent
                    element.classList.remove('active');
                } else {
                    // Fermer tous les autres sous-menus d'abord
                    const allSubmenus = document.querySelectorAll('.submenu');
                    allSubmenus.forEach(function(menu) {
                        menu.style.display = 'none';
                        // Retirer la classe active des autres liens parents
                        if (menu.previousElementSibling) {
                            menu.previousElementSibling.classList.remove('active');
                        }
                    });
                    
                    submenu.style.display = 'block';
                    // Ajouter la classe active au lien parent
                    element.classList.add('active');
                }
            }
        }
        
        // Marquer le menu actif et ouvrir le sous-menu correspondant
        document.addEventListener('DOMContentLoaded', function() {
            const currentUrl = window.location.pathname; // Utiliser pathname au lieu de href
            const menuLinks = document.querySelectorAll('#menuList a');
            
            // D'abord, supprimer toutes les classes active
            menuLinks.forEach(function(link) {
                link.classList.remove('active');
            });
            
            // Ensuite, appliquer la classe active au lien correspondant à la page courante
            menuLinks.forEach(function(link) {
                if (link.getAttribute('href') && link.getAttribute('href') !== '#' && 
                    currentUrl === new URL(link.href, window.location.origin).pathname) {
                    link.classList.add('active');
                    
                    // Si c'est un sous-menu, ouvrir le parent
                    const parentMenu = link.closest('.submenu');
                    if (parentMenu) {
                        parentMenu.style.display = 'block';
                        // Ajouter la classe active au lien parent
                        const parentLink = parentMenu.previousElementSibling;
                        if (parentLink) {
                            parentLink.classList.add('active');
                        }
                    }
                }
            });
        });
        
        // Fonctions pour la confirmation de déconnexion
        function confirmerDeconnexion(event) {
            if (event) event.preventDefault();
            document.getElementById('deconnexionDialog').style.display = 'flex';
        }
        
        function annulerDeconnexion() {
            document.getElementById('deconnexionDialog').style.display = 'none';
        }
        
        function confirmerDeconnexion() {
            window.location.href = "{{ route('chemin_deconnexion') }}";
        }
    </script>
    
    @yield('js')
</body>
</html>
