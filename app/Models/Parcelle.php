<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ValidationLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\TypeOccupation;

class Parcelle extends Model
{
    protected $fillable = [
        'numero',
        'arrondissement',
        'secteur',
        'lot',
        'designation',
        'parcelle',
        'ancienne_superficie',
        'nouvelle_superficie',
        'ecart_superficie',
        'motif',
        'observations',
        'type_occupation',
        'details_occupation',
        'reference_autorisation',
        'date_autorisation',
        'date_expiration_autorisation',
        'statut_attribution',
        'litige',
        'details_litige',
        'structure',
        'date_mise_a_jour',
        'latitude',
        'longitude',
        'agent',
        'responsable_id',
        'created_by',
        'updated_by'
    ];

    protected $dates = [
        'date_mise_a_jour',
        'date_autorisation',
        'date_expiration_autorisation',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'litige' => 'boolean',
        'date_mise_a_jour' => 'date',
        'date_autorisation' => 'date',
        'date_expiration_autorisation' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'type_occupation' => TypeOccupation::class,
    ];

    protected $appends = [
        'est_valide',
    ];

    protected static function booted()
    {
        static::creating(function ($parcelle) {
            if (Auth::check()) {
                $parcelle->created_by = Auth::id();
            }
        });

        static::saving(function ($parcelle) {
            // Calcul de l'écart de superficie
            if ($parcelle->ancienne_superficie && $parcelle->nouvelle_superficie) {
                $parcelle->ecart_superficie = $parcelle->nouvelle_superficie - $parcelle->ancienne_superficie;
            }

            // Validation des données d'occupation
            if ($parcelle->type_occupation === TypeOccupation::ANARCHIQUE) {
                // Pour les occupations anarchiques, on nettoie les champs d'autorisation
                $parcelle->reference_autorisation = null;
                $parcelle->date_autorisation = null;
                $parcelle->date_expiration_autorisation = null;
            }

            if (Auth::check()) {
                $parcelle->updated_by = Auth::id();
            }
        });
    }

    // CORRECTION : Relations avec le modèle Utilisateur au lieu de User
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'agent');
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'responsable_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'updated_by');
    }

    // Relation avec les logs de validation
    public function validationLogs(): HasMany
    {
        return $this->hasMany(ValidationLog::class)->latest();
    }

    // Accesseur pour la dernière validation
    public function getLastValidationAttribute()
    {
        return $this->validationLogs()->with('director')->first();
    }

    // Accesseur pour vérifier si l'occupation est valide
    public function getEstValideAttribute(): bool
    {
        if ($this->type_occupation !== TypeOccupation::AUTORISE) {
            return false;
        }

        // Vérification de la date d'expiration si elle existe
        if ($this->date_expiration_autorisation) {
            return $this->date_expiration_autorisation->isFuture();
        }

        return true;
    }

    // Scopes pour filtrer par type d'occupation
    public function scopeAutorise($query)
    {
        return $query->where('type_occupation', TypeOccupation::AUTORISE);
    }

    public function scopeAnarchique($query)
    {
        return $query->where('type_occupation', TypeOccupation::ANARCHIQUE);
    }

    public function scopeLibre($query)
    {
        return $query->where('type_occupation', TypeOccupation::LIBRE);
    }

    // Scope pour les autorisations expirées ou expirant bientôt
    public function scopeAutorisationsExpirantes($query, $jours = 30)
    {
        return $query->where('type_occupation', TypeOccupation::AUTORISE)
                    ->whereNotNull('date_expiration_autorisation')
                    ->where('date_expiration_autorisation', '<=', now()->addDays($jours));
    }

    // Méthode pour obtenir la couleur selon le type d'occupation
    public function getCouleurOccupationAttribute(): string
    {
        return $this->type_occupation?->couleur() ?? '#6B7280';
    }

    // Méthode pour obtenir l'icône selon le type d'occupation
    public function getIconeOccupationAttribute(): string
    {
        return $this->type_occupation?->icone() ?? '❓';
    }

    // Méthode pour vérifier si la parcelle est en litige
    public function estEnLitige(): bool
    {
        return $this->litige === true;
    }

    // Méthode pour vérifier si la parcelle est attribuée
    public function estAttribuee(): bool
    {
        return $this->statut_attribution === 'attribué';
    }

    // Méthode pour obtenir le statut sous forme de libellé lisible
    public function getStatutCompletAttribute(): string
    {
        $statut = $this->estAttribuee() ? 'Attribuée' : 'Non attribuée';

        if ($this->estEnLitige()) {
            $statut .= ' (En litige)';
        }

        if ($this->est_valide) {
            $statut .= ' - Autorisation valide';
        } elseif ($this->type_occupation === TypeOccupation::AUTORISE) {
            $statut .= ' - Autorisation expirée';
        }

        return $statut;
    }
    // Accessor pour agent_id (compatibilité avec les vues utilisant agent_id)
    public function getAgentIdAttribute()
    {
        return $this->agent;
    }

    // Mutator pour agent_id
    public function setAgentIdAttribute($value)
    {
        $this->attributes['agent'] = $value;
    }

}
