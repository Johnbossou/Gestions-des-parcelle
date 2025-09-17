<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ValidationLog extends Model
{
    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'validations_log';

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parcelle_id',
        'action',
        'user_id',
        'director_id',
        'ip_address',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec la parcelle concernée
     *
     * @return BelongsTo
     */
    public function parcelle(): BelongsTo
    {
        return $this->belongsTo(Parcelle::class);
    }

    /**
     * Relation avec l'utilisateur (superviseur) qui a initié l'action.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'user_id');
    }

    /**
     * Relation avec le directeur qui a validé l'action.
     *
     * @return BelongsTo
     */
    public function director(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'director_id');
    }

    /**
     * Scope pour les validations récentes
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
