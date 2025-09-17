<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateur; // Changé de User à Utilisateur
use Symfony\Component\HttpFoundation\Response;

class RequireDirectorApproval
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur a le rôle chef_service (conforme au seeder)
        if (Auth::check() && Auth::user()->hasRole('chef_service')) {
            // Vérifie la présence du mot de passe
            if (!$request->has('director_password')) {
                return back()
                    ->withErrors(['director_password' => 'Le mot de passe du Directeur est requis'])
                    ->withInput();
            }

            // Valide le mot de passe
            $director = Utilisateur::role('Directeur')->first();
            if (!$director || !Hash::check($request->director_password, $director->password)) {
                return back()
                    ->withErrors(['director_password' => 'Mot de passe du Directeur incorrect'])
                    ->withInput();
            }
        }

        return $next($request);
    }
}
