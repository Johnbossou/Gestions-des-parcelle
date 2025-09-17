<?php

namespace App\Imports;

use App\Models\Parcelle;
use App\Models\User;
use App\Models\AuditLog;
use App\Models\ValidationLog;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Auth;

class ParcellesImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $userId = Auth::id();

        // Résoudre les IDs des utilisateurs
        $agentId = $this->resolveUserId($row['agent'] ?? null);
        $responsableId = $this->resolveUserId($row['responsable_id'] ?? null);
        $updatedById = $this->resolveUserId($row['updated_by'] ?? null);
        $createdById = $this->resolveUserId($row['created_by'] ?? null) ?? $userId; // Par défaut, l'utilisateur actuel

        // Calculer ecart_superficie
        $ecartSuperficie = isset($row['ancienne_superficie'], $row['nouvelle_superficie'])
            ? $row['nouvelle_superficie'] - $row['ancienne_superficie']
            : null;

        // Utiliser updateOrCreate pour upsert (évite les doublons sur 'parcelle')
        $parcelle = Parcelle::updateOrCreate(
            ['parcelle' => $row['parcelle']],
            [
                'numero' => $row['numero'] ?? null,
                'arrondissement' => $row['arrondissement'],
                'secteur' => $row['secteur'],
                'lot' => $row['lot'],
                'designation' => $row['designation'] ?? null,
                'ancienne_superficie' => $row['ancienne_superficie'] ?? null,
                'nouvelle_superficie' => $row['nouvelle_superficie'] ?? null,
                'ecart_superficie' => $ecartSuperficie,
                'motif' => $row['motif'] ?? null,
                'observations' => $row['observations'] ?? null,
                'type_terrain' => $this->validateEnum($row['type_terrain'] ?? null, ['Résidentiel', 'Commercial', 'Agricole', 'Institutionnel', 'Autre']),
                'statut_attribution' => $this->validateEnum($row['statut_attribution'] ?? null, ['attribué', 'non attribué']),
                'litige' => isset($row['litige']) ? filter_var($row['litige'], FILTER_VALIDATE_BOOLEAN) : null,
                'details_litige' => $row['details_litige'] ?? null,
                'structure' => $row['structure'] ?? null,
                'date_mise_a_jour' => $this->parseDate($row['date_mise_a_jour'] ?? null),
                'latitude' => $row['latitude'] ?? null,
                'longitude' => $row['longitude'] ?? null,
                'agent' => $agentId,
                'agent_name' => $row['agent_name'] ?? null,
                'responsable_id' => $responsableId,
                'responsable_name' => $row['responsable_name'] ?? null,
                'updated_by' => $updatedById ?? $userId,
                'created_by' => $createdById ?? $userId,
            ]
        );

        // Log dans audit_logs
        AuditLog::create([
            'user_id' => $userId,
            'action' => $parcelle->wasRecentlyCreated ? 'create' : 'update',
            'model_type' => 'Parcelle',
            'model_id' => $parcelle->id,
            'changes' => json_encode($row), // Ou calcule un diff pour plus de précision
        ]);

        // Log dans validations_log si c'est un update (cohérent avec ton middleware require.director.approval)
        if (!$parcelle->wasRecentlyCreated) {
            ValidationLog::create([
                'parcelle_id' => $parcelle->id,
                'action' => 'parcelle_update',
                'user_id' => $userId,
                'director_id' => $userId, // À ajuster si besoin d'un directeur spécifique (ex. : rôle 'Directeur')
                'ip_address' => request()->ip(),
            ]);
        }

        return $parcelle;
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'parcelle' => 'required|string|max:255',
            'arrondissement' => 'required|string|max:255',
            'secteur' => 'required|string|max:255',
            'lot' => 'required|integer|min:1',
            'type_terrain' => 'nullable|in:Résidentiel,Commercial,Agricole,Institutionnel,Autre',
            'statut_attribution' => 'nullable|in:attribué,non attribué',
            'litige' => 'nullable|boolean',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'ancienne_superficie' => 'nullable|numeric|min:0',
            'nouvelle_superficie' => 'nullable|numeric|min:0',
            'date_mise_a_jour' => 'nullable|date_format:Y-m-d',
            'agent' => 'nullable|exists:utilisateurs,id',
            'responsable_id' => 'nullable|exists:utilisateurs,id',
            'updated_by' => 'nullable|exists:utilisateurs,id',
            'created_by' => 'nullable|exists:utilisateurs,id',
        ];
    }

    private function resolveUserId($value): ?int
    {
        if (!$value) return null;
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $value)->first();
            return $user ? $user->id : null;
        }
        return is_numeric($value) && User::where('id', $value)->exists() ? (int) $value : null;
    }

    private function validateEnum($value, array $allowed): ?string
    {
        return in_array($value, $allowed) ? $value : null;
    }

    private function parseDate($value): ?string
    {
        if (!$value) return null;
        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function batchSize(): int
    {
        return 500; // Ajuste selon la mémoire serveur (plus petit pour logs par ligne)
    }

    public function chunkSize(): int
    {
        return 500; // Lecture par chunks pour fichiers larges
    }
}
