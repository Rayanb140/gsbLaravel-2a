<?php

namespace App\Http\Middleware;

use Closure;

class CleanInputs
{
    /**
     * Nettoie les entrées utilisateur pour éviter les attaques XSS.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Nettoyer les entrées
        $input = $request->all();
        
        array_walk_recursive($input, function (&$item) {
            if (is_string($item)) {
                // Nettoie les balises HTML et les caractères spéciaux
                $item = filter_var($item, FILTER_SANITIZE_STRING);
            }
        });
        
        $request->merge($input);
        
        return $next($request);
    }
} 