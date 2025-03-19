<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        // Protection contre le XSS
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Empêche le navigateur de faire du MIME-sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Prévention contre le clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        
        // Content Security Policy de base (à ajuster selon vos besoins)
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data:;");
        
        // Référer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        return $response;
    }
} 