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
    /**
     * Champs sensibles : leur modification exige l'approbation du Directeur.
     */
    protected array $sensitiveFields = [
        'statut_attribution',
        'type_occupation',
        'litige',
        'details_litige',
        'nouvelle_superficie',
        'reference_autorisation',
        'date_autorisation',
        'date_expiration_autorisation',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->hasRole('chef_service')) {
            return $next($request);
        }

        $parcelle = $request->route('parcelle');

        if (!$this->modifiesSensitiveField($request, $parcelle)) {
            return $next($request);
        }

        if (!$request->has('director_password')) {
            return back()
                ->withErrors(['director_password' => 'Le mot de passe du Directeur est requis'])
                ->withInput();
        }

        $director = Utilisateur::role('Directeur')->first();
        if (!$director || !Hash::check($request->director_password, $director->password)) {
            return back()
                ->withErrors(['director_password' => 'Mot de passe du Directeur incorrect'])
                ->withInput();
        }

        return $next($request);
    }

    protected function modifiesSensitiveField(Request $request, $parcelle): bool
    {
        $currentAttrs = $parcelle?->getAttributes() ?? [];

        foreach ($this->sensitiveFields as $field) {
            if (!$request->has($field)) {
                continue;
            }

            $current = array_key_exists($field, $currentAttrs) ? $currentAttrs[$field] : null;
            $incoming = $request->input($field);

            if ($this->normalize($current) !== $this->normalize($incoming)) {
                return true;
            }
        }

        return false;
    }

    protected function normalize($value): string
    {
        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        if ($value === null) {
            return '0';
        }

        return (string) $value;
    }
}
