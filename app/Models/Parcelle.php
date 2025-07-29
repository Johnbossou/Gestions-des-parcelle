<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'type_terrain',
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

    // Convertir automatiquement date_mise_a_jour en objet Carbon
    protected $dates = [
        'date_mise_a_jour',
        'created_at',
        'updated_at',
    ];

    // Définir les types de données pour certains champs
    protected $casts = [
        'litige' => 'boolean',
        'date_mise_a_jour' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Écouteurs d'événements pour created_by, updated_by et ecart_superficie
    protected static function booted()
    {
        static::creating(function ($parcelle) {
            if (Auth::check()) {
                $parcelle->created_by = Auth::id();
            }
        });

        static::saving(function ($parcelle) {
            if ($parcelle->ancienne_superficie && $parcelle->nouvelle_superficie) {
                $parcelle->ecart_superficie = $parcelle->nouvelle_superficie - $parcelle->ancienne_superficie;
            }
            if (Auth::check()) {
                $parcelle->updated_by = Auth::id();
            }
        });
    }

    // Relations avec le modèle User
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent');
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
