<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion Visiteur - Laboratoire Galaxy-Swiss Bourdin</title>
    <link rel="shortcut icon" type="image/x-icon" href="./images/logoIco.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            line-height: 1.6;
            height: 100vh;
            background-color: #f5f7fa;
            background-image: 
                radial-gradient(#27ae60 0.5px, transparent 0.5px), 
                radial-gradient(#27ae60 0.5px, #f5f7fa 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            background-attachment: fixed;
            overflow: hidden;
        }
        
        .page-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
            z-index: 1;
        }
        
        .page-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(39, 174, 96, 0.1) 0%, rgba(245, 247, 250, 0.9) 100%);
            z-index: -1;
        }
        
        .login-container {
            width: 420px;
            padding: 40px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
            animation: fadeIn 0.8s ease-out, slideUp 0.8s ease-out;
            position: relative;
            overflow: hidden;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to right, #27ae60, #2ecc71);
        }
        
        .logo-container {
            margin-bottom: 30px;
            position: relative;
        }
        
        .logo {
            max-width: 120px;
            height: auto;
            display: block;
            margin: 0 auto 15px;
            transition: transform 0.3s ease;
        }
        
        .logo:hover {
            transform: scale(1.05);
        }
        
        .user-type-badge {
            display: inline-block;
            background-color: #27ae60;
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(39, 174, 96, 0.2);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(39, 174, 96, 0.3);
            }
            70% {
                box-shadow: 0 0 0 8px rgba(39, 174, 96, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(39, 174, 96, 0);
            }
        }
        
        h1 {
            font-size: 24px;
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eaeaea;
            position: relative;
        }
        
        h1::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: #27ae60;
            border-radius: 2px;
        }
        
        .form-group {
            margin-bottom: 25px;
            text-align: left;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
            transition: all 0.3s ease;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #27ae60;
            outline: none;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.2);
            background-color: white;
        }
        
        input[type="text"]:focus + .input-icon,
        input[type="password"]:focus + .input-icon {
            color: #27ae60;
        }
        
        .btn-submit {
            display: block;
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #27ae60, #2ecc71);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 35px;
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.5s ease;
        }
        
        .btn-submit:hover {
            background: linear-gradient(to right, #219653, #27ae60);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(39, 174, 96, 0.3);
        }
        
        .btn-submit:hover::before {
            left: 100%;
        }
        
        .btn-submit:active {
            transform: translateY(1px);
            box-shadow: 0 3px 8px rgba(39, 174, 96, 0.3);
        }
        
        .error-message {
            background-color: #fff8f8;
            color: #e74c3c;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            font-size: 14px;
            border-left: 4px solid #e74c3c;
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.1);
            animation: shake 0.5s ease-in-out;
            display: flex;
            align-items: center;
        }
        
        .error-message i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .footer-text {
            margin-top: 30px;
            font-size: 12px;
            color: #95a5a6;
        }
        
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
            cursor: pointer;
            transition: color 0.3s ease;
            padding: 5px;
        }
        
        .toggle-password:hover {
            color: #27ae60;
        }
        
        .user-type-selector {
            margin-top: 35px;
            border-top: 1px solid #eaeaea;
            padding-top: 20px;
            text-align: center;
            position: relative;
        }
        
        .user-type-selector::before {
            content: 'ou';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            padding: 0 15px;
            color: #95a5a6;
            font-size: 12px;
        }
        
        .user-type-link {
            display: inline-flex;
            align-items: center;
            color: #27ae60;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 4px;
            background-color: rgba(39, 174, 96, 0.05);
        }
        
        .user-type-link i {
            margin-right: 8px;
        }
        
        .user-type-link:hover {
            color: #219653;
            background-color: rgba(39, 174, 96, 0.1);
            text-decoration: none;
            transform: translateY(-2px);
        }
        
        @keyframes fadeIn {
            from { opacity: 0.2; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateY(15px); }
            to { transform: translateY(0); }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        
        @keyframes slideDown {
            from { transform: translateY(0); }
            to { transform: translateY(15px); }
        }
        
        .leaving {
            animation: fadeOut 0.3s ease-out, slideDown 0.3s ease-out;
            animation-fill-mode: forwards;
        }
        
        /* Responsive */
        @media (max-width: 500px) {
            .login-container {
                width: 90%;
                padding: 30px 20px;
            }
            
            input[type="text"],
            input[type="password"] {
                padding: 12px 12px 12px 40px;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="login-container">
            <div class="logo-container">
                <img src="{{ asset('images/logo.jpg') }}" alt="GSB Logo" class="logo">
                <span class="user-type-badge">Espace Visiteur</span>
                <h1>Connexion à l'intranet</h1>
            </div>
            
            @if(isset($erreurs) && count($erreurs) > 0)
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> 
                    @foreach($erreurs as $erreur)
                        {{ $erreur }}
                    @endforeach
                </div>
            @endif
            
            <form method="post" action="{{ url('/') }}" id="loginForm">
                {{ csrf_field() }}
                
                <div class="form-group">
                    <label for="login">Identifiant</label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="login" name="login" value="{{ old('login') }}" required autofocus>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="mdp" name="mdp" required>
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
    </form>
            
            <div class="user-type-selector">
                <a href="{{ url('/gestionnaire') }}" class="user-type-link">
                    <i class="fas fa-exchange-alt"></i> Accéder à l'espace gestionnaire
                </a>
            </div>
            
            <p class="footer-text">Laboratoire Galaxy-Swiss Bourdin &copy; {{ date('Y') }}</p>
        </div>
</div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('mdp');
            
            togglePassword.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    togglePassword.classList.remove('fa-eye');
                    togglePassword.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    togglePassword.classList.remove('fa-eye-slash');
                    togglePassword.classList.add('fa-eye');
                }
            });
            
            // Input focus effects
            const inputs = document.querySelectorAll('input');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.parentElement.querySelector('label').style.color = '#27ae60';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.parentElement.querySelector('label').style.color = '#2c3e50';
                });
            });
            
            // Form submission animation
            const form = document.getElementById('loginForm');
            
            form.addEventListener('submit', function(e) {
                const button = document.querySelector('.btn-submit');
                button.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Connexion...';
                button.style.pointerEvents = 'none';
                // Form still submits normally
            });
            
            // Ajouter la transition entre pages
            const userTypeLink = document.querySelector('.user-type-link');
            const loginContainer = document.querySelector('.login-container');
            
            userTypeLink.addEventListener('click', function(e) {
                e.preventDefault();
                const targetUrl = this.getAttribute('href');
                
                // Ajouter la classe d'animation de sortie
                loginContainer.classList.add('leaving');
                
                // Rediriger après que l'animation soit terminée
                setTimeout(function() {
                    window.location.href = targetUrl;
                }, 300); // Durée de l'animation
            });
        });
    </script>
</body>
</html>