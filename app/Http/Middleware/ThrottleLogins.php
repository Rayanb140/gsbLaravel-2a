<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ThrottleLogins
{
    /**
     * Limite le nombre de tentatives de connexion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $maxAttempts
     * @param  int  $decayMinutes
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $maxAttempts = 5, $decayMinutes = 1)
    {
        $key = $request->ip() . ':' . $request->input('login');
        $attempts = Cache::get($key, 0);

        if ($attempts >= $maxAttempts) {
            $remainingTime = Cache::ttl($key);
            return redirect()->back()->with('erreurs', [
                'Trop de tentatives de connexion. Veuillez réessayer dans ' . ceil($remainingTime / 60) . ' minute(s).'
            ]);
        }

        // Après tentative de connexion, augmenter le compteur
        $response = $next($request);

        // Si échec de connexion, incrémenter le compteur
        if ($response->isRedirect() && $request->has('login') && $request->has('mdp')) {
            if (strpos($response->getTargetUrl(), 'connexion') !== false) {
                Cache::put($key, $attempts + 1, now()->addMinutes($decayMinutes));
            }
        }

        return $response;
    }
} 