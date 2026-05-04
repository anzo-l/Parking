<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Non connecté');
        }

        // Vérifier is_admin
        if (!isset($user->is_admin)) {
            abort(403, 'Colonne is_admin manquante. Exécutez: php artisan migrate');
        }

        if (!$user->is_admin) {
            abort(403, 'Accès refusé - Vous n\'êtes pas admin');
        }

        return $next($request);
    }
}
