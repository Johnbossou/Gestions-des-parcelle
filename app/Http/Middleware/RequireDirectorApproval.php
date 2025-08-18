<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RequireDirectorApproval
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est un Superviseur Administratif
        if (Auth::check() && Auth::user()->hasRole('Superviseur_administratif')) {
            
            // Vérifie la présence du mot de passe
            if (!$request->has('director_password')) {
                return back()
                    ->withErrors(['director_password' => 'Le mot de passe du Directeur est requis'])
                    ->withInput();
            }

            // Valide le mot de passe
            $director = User::role('Directeur')->first();
            if (!$director || !Hash::check($request->director_password, $director->password)) {
                return back()
                    ->withErrors(['director_password' => 'Mot de passe du Directeur incorrect'])
                    ->withInput();
            }
        }

        return $next($request);
    }
}