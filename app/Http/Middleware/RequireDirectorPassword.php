<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RequireDirectorPassword
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est authentifié et a le rôle requis
        if (Auth::check() && Auth::user()->hasRole('Superviseur_administratif')) {

            // Liste des actions restreintes
            $restrictedActions = [
                'parcelles.store',
                'parcelles.update',
                'parcelles.destroy'
            ];

            // Si la route actuelle est restreinte
            if (in_array($request->route()->getName(), $restrictedActions)) {

                // Vérification de la présence du mot de passe directeur
                if (!$request->filled('director_password')) {
                    abort(403, 'Validation du Directeur requise');
                }

                // Récupération du Directeur
                $director = User::role('Directeur')->first();

                if (!$director || !Hash::check($request->input('director_password'), $director->password)) {
                    abort(403, 'Mot de passe du Directeur incorrect');
                }
            }
        }

        return $next($request);
    }
}
