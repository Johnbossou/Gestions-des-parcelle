<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Utilisateur extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'utilisateurs';
    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relation : Parcelles créées par cet utilisateur
     */
    public function parcellesCreees()
    {
        return $this->hasMany(Parcelle::class, 'created_by');
    }

    /**
     * Relation : Parcelles modifiées par cet utilisateur
     */
    public function parcellesModifiees()
    {
        return $this->hasMany(Parcelle::class, 'updated_by');
    }

    /**
     * Relation : Parcelles où cet utilisateur est agent
     */
    public function parcellesAgent()
    {
        return $this->hasMany(Parcelle::class, 'agent');
    }

    /**
     * Relation : Parcelles où cet utilisateur est responsable
     */
    public function parcellesResponsable()
    {
        return $this->hasMany(Parcelle::class, 'responsable_id');
    }

    /**
     * Relation : Logs de validation où cet utilisateur est le directeur
     */
    public function validationsApprouvees()
    {
        return $this->hasMany(ValidationLog::class, 'director_id');
    }

    /**
     * Relation : Logs d'audit créés par cet utilisateur
     */
    public function logsAudit()
    {
        return $this->hasMany(AuditLog::class, 'user_id');
    }

    /**
     * Vérifie si l'utilisateur est directeur
     * (Utilise le système Spatie - plus besoin de la colonne 'role')
     */
    public function isDirector(): bool
    {
        return $this->hasRole('Directeur');
    }

    /**
     * Vérifie si l'utilisateur peut valider des modifications
     * (Chef de service ou directeur)
     */
    public function canApproveChanges(): bool
    {
        return $this->hasAnyRole(['chef_service', 'Directeur']);
    }

    /**
     * Scope pour les utilisateurs avec un rôle spécifique
     * (Utilise le système Spatie)
     */
    public function scopeWithRole($query, $role)
    {
        return $query->whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        });
    }

    /**
     * Scope pour les directeurs
     */
    public function scopeDirectors($query)
    {
        return $this->scopeWithRole($query, 'Directeur');
    }

    /**
     * Scope pour les chefs de service
     */
    public function scopeChefsService($query)
    {
        return $this->scopeWithRole($query, 'chef_service');
    }
}
