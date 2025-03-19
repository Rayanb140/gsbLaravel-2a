<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SecurityLogger
{
    public static function logFailedLogin($login, $ip)
    {
        Log::channel('security')->warning('Échec de connexion', [
            'login' => $login,
            'ip' => $ip,
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
    
    public static function logSuccessfulLogin($login, $ip, $role)
    {
        Log::channel('security')->info('Connexion réussie', [
            'login' => $login,
            'ip' => $ip,
            'role' => $role,
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    public static function logUnauthorizedAccess($path, $ip)
    {
        Log::channel('security')->warning('Tentative d\'accès non autorisé', [
            'path' => $path,
            'ip' => $ip,
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
} 