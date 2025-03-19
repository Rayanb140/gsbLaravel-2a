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
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #e8f3ec 100%);
        }
        
        .login-container {
            width: 400px;
            padding: 40px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .logo-container {
            margin-bottom: 30px;
        }
        
        .logo {
            max-width: 120px;
            height: auto;
            display: block;
            margin: 0 auto 15px;
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
        }
        
        h1 {
            font-size: 24px;
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eaeaea;
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #2c3e50;
            font-size: 14px;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #27ae60;
            outline: none;
            box-shadow: 0 0 0 2px rgba(39, 174, 96, 0.25);
        }
        
        .btn-submit {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 30px;
        }
        
        .btn-submit:hover {
            background-color: #219653;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid #f5c6cb;
        }
        
        .footer-text {
            margin-top: 30px;
            font-size: 12px;
            color: #95a5a6;
        }
        
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
            cursor: pointer;
        }
        
        .user-type-selector {
            margin-top: 30px;
            border-top: 1px solid #eaeaea;
            padding-top: 20px;
            text-align: center;
        }
        
        .user-type-link {
            display: inline-block;
            color: #27ae60;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
        }
        
        .user-type-link:hover {
            color: #219653;
            text-decoration: underline;
        }
    </style>
</head>
<body>
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
        
        <form method="post" action="">
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
                    <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility()"></i>
                </div>
            </div>
            
            <button type="submit" class="btn-submit">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>
        
        <div class="user-type-selector">
            <a href="{{ url('/') }}" class="user-type-link">
                <i class="fas fa-exchange-alt"></i> Accéder à l'espace gestionnaire
            </a>
        </div>
        
        <p class="footer-text">Laboratoire Galaxy-Swiss Bourdin &copy; {{ date('Y') }}</p>
    </div>
    
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('mdp');
            const toggleIcon = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html> 