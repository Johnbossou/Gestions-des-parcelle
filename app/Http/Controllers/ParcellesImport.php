<?php

namespace App\Imports;

use App\Models\Parcelle;
use App\Models\Utilisateur; // Correction: Utilisateur au lieu de User
use App\Models\AuditLog;
use App\Models\ValidationLog;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Auth;
use App\Enums\TypeOccupation;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ParcellesImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $userId = Auth::id();

        // Nettoyer les clés du tableau (enlever espaces, etc.)
        $row = array_change_key_case($row, CASE_LOWER);
        $row = array_map('trim', $row);

        // Résoudre les IDs des utilisateurs
        $agentId = $this->resolveUserId($row['agent'] ?? $row['agent_id'] ?? null);
        $responsableId = $this->resolveUserId($row['responsable'] ?? $row['responsable_id'] ?? null);
        $updatedById = $this->resolveUserId($row['updated_by'] ?? null);
        $createdById = $this->resolveUserId($row['created_by'] ?? null) ?? $userId;

        // Calculer ecart_superficie
        $ancienneSuperficie = $this->parseFloat($row['ancienne_superficie'] ?? null);
        $nouvelleSuperficie = $this->parseFloat($row['nouvelle_superficie'] ?? null);
        $ecartSuperficie = ($ancienneSuperficie !== null && $nouvelleSuperficie !== null)
            ? $nouvelleSuperficie - $ancienneSuperficie
            : null;

        // Gestion des nouveaux champs d'occupation
        $typeOccupation = $this->validateEnum($row['type_occupation'] ?? null, TypeOccupation::values());

        // Pour la rétrocompatibilité: si type_occupation n'est pas fourni, utiliser type_terrain
        if (!$typeOccupation && isset($row['type_terrain'])) {
            $typeOccupation = $this->convertFromOldTypeTerrain($row['type_terrain']);
        }

        $detailsOccupation = $row['details_occupation'] ?? $row['details_occupation'] ?? null;
        $referenceAutorisation = $row['reference_autorisation'] ?? $row['ref_autorisation'] ?? null;
        $dateAutorisation = $this->parseDate($row['date_autorisation'] ?? null);
        $dateExpiration = $this->parseDate($row['date_expiration_autorisation'] ?? $row['date_expiration'] ?? null);

        // Validation cohérence: si occupation anarchique, on nettoie les champs d'autorisation
        if ($typeOccupation === TypeOccupation::ANARCHIQUE->value) {
            $referenceAutorisation = null;
            $dateAutorisation = null;
            $dateExpiration = null;
        }

        // Préparer les données pour l'upsert
        $data = [
            'numero' => $row['numero'] ?? $this->generateUniqueNumber(),
            'arrondissement' => $row['arrondissement'] ?? null,
            'secteur' => $row['secteur'] ?? null,
            'lot' => $this->parseInt($row['lot'] ?? null),
            'designation' => $row['designation'] ?? null,
            'parcelle' => $row['parcelle'] ?? null,
            'ancienne_superficie' => $ancienneSuperficie,
            'nouvelle_superficie' => $nouvelleSuperficie,
            'ecart_superficie' => $ecartSuperficie,
            'motif' => $row['motif'] ?? null,
            'observations' => $row['observations'] ?? null,

            // Champs d'occupation
            'type_occupation' => $typeOccupation,
            'details_occupation' => $detailsOccupation,
            'reference_autorisation' => $referenceAutorisation,
            'date_autorisation' => $dateAutorisation,
            'date_expiration_autorisation' => $dateExpiration,

            'statut_attribution' => $this->validateEnum(
                $row['statut_attribution'] ?? $row['statut'] ?? null,
                ['attribué', 'non attribué']
            ),
            'litige' => $this->parseBoolean($row['litige'] ?? null),
            'details_litige' => $row['details_litige'] ?? $row['litige_details'] ?? null,
            'structure' => $row['structure'] ?? null,
            'latitude' => $this->parseFloat($row['latitude'] ?? null),
            'longitude' => $this->parseFloat($row['longitude'] ?? null),

            // Relations
            'agent_id' => $agentId, // Correction: agent_id au lieu de agent
            'responsable_id' => $responsableId,
            'updated_by' => $updatedById ?? $userId,
            'created_by' => $createdById,
        ];

        // Nettoyer les valeurs null
        $data = array_filter($data, function($value) {
            return $value !== null;
        });

        // Utiliser updateOrCreate pour éviter les doublons
        $parcelle = Parcelle::updateOrCreate(
            [
                'parcelle' => $data['parcelle'] ?? null,
                'numero' => $data['numero']
            ],
            $data
        );

        // Log dans audit_logs
        AuditLog::create([
            'user_id' => $userId,
            'action' => $parcelle->wasRecentlyCreated ? 'create' : 'update',
            'model_type' => Parcelle::class,
            'model_id' => $parcelle->id,
            'changes' => json_encode($data),
        ]);

        return $parcelle;
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'numero' => 'nullable|integer',
            'parcelle' => 'required|string|max:255',
            'arrondissement' => 'required|string|max:255',
            'secteur' => 'required|string|max:255',
            'lot' => 'required|integer|min:1',
            'designation' => 'nullable|string|max:500',

            // Champs d'occupation
            'type_occupation' => [
                'nullable',
                Rule::in(TypeOccupation::values())
            ],
            'details_occupation' => 'nullable|string|max:500',
            'reference_autorisation' => 'nullable|string|max:100',
            'date_autorisation' => 'nullable|date_format:Y-m-d',
            'date_expiration_autorisation' => 'nullable|date_format:Y-m-d|after_or_equal:date_autorisation',

            // Superficies
            'ancienne_superficie' => 'nullable|numeric|min:0',
            'nouvelle_superficie' => 'nullable|numeric|min:0',

            // Statut et litige
            'statut_attribution' => 'nullable|in:attribué,non attribué',
            'litige' => 'nullable|boolean',
            'details_litige' => 'nullable|string|max:500',

            // Localisation
            'structure' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',

            // Relations
            'agent' => 'nullable|exists:utilisateurs,id',
            'agent_id' => 'nullable|exists:utilisateurs,id',
            'responsable' => 'nullable|exists:utilisateurs,id',
            'responsable_id' => 'nullable|exists:utilisateurs,id',
            'updated_by' => 'nullable|exists:utilisateurs,id',
            'created_by' => 'nullable|exists:utilisateurs,id',
        ];
    }

    /**
     * Messages de validation personnalisés
     */
    public function customValidationMessages(): array
    {
        return [
            'parcelle.required' => 'Le champ parcelle est obligatoire',
            'arrondissement.required' => 'Le champ arrondissement est obligatoire',
            'secteur.required' => 'Le champ secteur est obligatoire',
            'lot.required' => 'Le champ lot est obligatoire',
            'type_occupation.in' => 'Le type d\'occupation doit être parmi: ' . implode(', ', TypeOccupation::values()),
            'date_expiration_autorisation.after_or_equal' => 'La date d\'expiration doit être postérieure ou égale à la date d\'autorisation',
        ];
    }

    /**
     * Résoudre l'ID utilisateur à partir d'un email ou ID
     */
    private function resolveUserId($value): ?int
    {
        if (!$value) return null;

        // Si c'est un email
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $user = Utilisateur::where('email', $value)->first();
            return $user ? $user->id : null;
        }

        // Si c'est un ID numérique
        if (is_numeric($value)) {
            return Utilisateur::where('id', (int)$value)->exists() ? (int)$value : null;
        }

        // Si c'est un nom, chercher par nom
        $user = Utilisateur::where('name', 'like', "%{$value}%")->first();
        return $user ? $user->id : null;
    }

    /**
     * Valider une valeur par rapport à une liste autorisée
     */
    private function validateEnum($value, array $allowed): ?string
    {
        if (!$value) return null;

        // Normaliser la valeur (minuscules, sans accents)
        $normalized = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $value));
        $normalized = preg_replace('/[^a-z0-9]/', '', $normalized);

        foreach ($allowed as $allowedValue) {
            $normalizedAllowed = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $allowedValue));
            $normalizedAllowed = preg_replace('/[^a-z0-9]/', '', $normalizedAllowed);

            if ($normalized === $normalizedAllowed) {
                return $allowedValue;
            }
        }

        return null;
    }

    /**
     * Parser une date depuis différents formats
     */
    private function parseDate($value): ?string
    {
        if (!$value) return null;

        try {
            // Essayer différents formats de date
            $formats = [
                'Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y',
                'Y/m/d', 'd.m.Y', 'Y.m.d', 'd M Y', 'd F Y'
            ];

            foreach ($formats as $format) {
                try {
                    $date = Carbon::createFromFormat($format, $value);
                    if ($date) return $date->format('Y-m-d');
                } catch (\Exception $e) {
                    continue;
                }
            }

            // Essayer avec la parsing automatique
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Parser un float
     */
    private function parseFloat($value): ?float
    {
        if ($value === null || $value === '') return null;

        // Remplacer les virgules par des points
        $value = str_replace(',', '.', (string)$value);
        $value = preg_replace('/[^0-9.]/', '', $value);

        return is_numeric($value) ? (float)$value : null;
    }

    /**
     * Parser un integer
     */
    private function parseInt($value): ?int
    {
        if ($value === null || $value === '') return null;

        $value = preg_replace('/[^0-9]/', '', (string)$value);
        return is_numeric($value) ? (int)$value : null;
    }

    /**
     * Parser un boolean
     */
    private function parseBoolean($value): ?bool
    {
        if ($value === null || $value === '') return null;

        if (is_bool($value)) return $value;

        $value = strtolower((string)$value);
        $trueValues = ['1', 'true', 'yes', 'oui', 'vrai', 'o'];
        $falseValues = ['0', 'false', 'no', 'non', 'faux', 'n'];

        if (in_array($value, $trueValues)) return true;
        if (in_array($value, $falseValues)) return false;

        return null;
    }

    /**
     * Conversion depuis l'ancien type_terrain vers le nouveau type_occupation
     */
    private function convertFromOldTypeTerrain($oldType): ?string
    {
        $mapping = [
            'résidentiel' => TypeOccupation::AUTORISE->value,
            'commercial' => TypeOccupation::AUTORISE->value,
            'institutionnel' => TypeOccupation::AUTORISE->value,
            'agricole' => TypeOccupation::AUTORISE->value,
            'autre' => TypeOccupation::ANARCHIQUE->value,
            'libre' => TypeOccupation::LIBRE->value,
            'autorisé' => TypeOccupation::AUTORISE->value,
            'anarchique' => TypeOccupation::ANARCHIQUE->value,
        ];

        $normalized = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $oldType));
        $normalized = preg_replace('/[^a-z]/', '', $normalized);

        return $mapping[$normalized] ?? null;
    }

    /**
     * Générer un numéro unique si non fourni
     */
    private function generateUniqueNumber(): int
    {
        do {
            $numero = rand(1000, 9999);
        } while (Parcelle::where('numero', $numero)->exists());

        return $numero;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * Gestion des échecs de validation
     */
    public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures)
    {
        foreach ($failures as $failure) {
            logger()->error('Échec import parcelle', [
                'row' => $failure->row(),
                'errors' => $failure->errors(),
                'values' => $failure->values()
            ]);
        }
    }
}
