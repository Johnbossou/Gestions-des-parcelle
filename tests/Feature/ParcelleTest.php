<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use App\Models\Parcelle;
use App\Models\AuditLog;
use App\Models\ValidationLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ParcelleTest extends TestCase
{
    use RefreshDatabase;

    protected Utilisateur $chefService;
    protected Utilisateur $secretaire;
    protected Utilisateur $directeur;

    protected function setUp(): void
    {
        parent::setUp();

        $roles = [
            'chef_service' => 'Chef de Service',
            'secretaire_executif' => 'Secrétaire Exécutif',
            'Directeur' => 'Directeur'
        ];

        foreach ($roles as $key => $name) {
            Role::firstOrCreate(['name' => $key]);
        }

        $permissions = [
            'view-parcels', 'create-parcelles', 'edit-parcelles',
            'delete-parcelles', 'export-parcels', 'manage-users'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $this->chefService = Utilisateur::create([
            'name' => 'Chef Service',
            'email' => 'chef@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $this->chefService->assignRole('chef_service');
        $this->chefService->givePermissionTo(['view-parcels', 'create-parcelles', 'edit-parcelles']);

        $this->secretaire = Utilisateur::create([
            'name' => 'Secrétaire',
            'email' => 'secretary@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $this->secretaire->assignRole('secretaire_executif');
        $this->secretaire->givePermissionTo(['view-parcels', 'export-parcels']);

        $this->directeur = Utilisateur::create([
            'name' => 'Directeur',
            'email' => 'director@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $this->directeur->assignRole('Directeur');
        $this->directeur->givePermissionTo(['view-parcels', 'edit-parcelles', 'delete-parcelles', 'export-parcels']);
    }

    private function parcelleData(array $overrides = []): array
    {
        return array_merge([
            'arrondissement' => 'Abomey-Calavi',
            'secteur' => 'Secteur A',
            'lot' => 1,
            'parcelle' => 'PAR-001',
            'ancienne_superficie' => 500.50,
            'type_occupation' => 'Autorisé',
            'statut_attribution' => 'attribué',
            'litige' => false,
        ], $overrides);
    }

    /**
     * TU-04 : Création d'une parcelle avec données valides
     */
    public function test_create_parcelle_with_valid_data()
    {
        $this->actingAs($this->chefService);

        $response = $this->post('/parcelles', $this->parcelleData([
            'parcelle' => 'PAR-001',
        ]));

        $response->assertRedirect();
        $this->assertDatabaseHas('parcelles', [
            'parcelle' => 'PAR-001',
            'ancienne_superficie' => 500.50,
        ]);
    }

    /**
     * TU-05 : Création avec champs obligatoires manquants
     */
    public function test_create_parcelle_with_missing_required_fields()
    {
        $this->actingAs($this->chefService);

        $response = $this->post('/parcelles', [
            'parcelle' => 'PAR-002',
        ]);

        $response->assertSessionHasErrors();
        $this->assertDatabaseMissing('parcelles', [
            'parcelle' => 'PAR-002',
        ]);
    }

    /**
     * TU-06 : Modification parcelle (champ non sensible) par Chef service
     */
    public function test_update_parcelle_non_sensitive_field_by_chef_service()
    {
        $parcelle = Parcelle::create($this->parcelleData([
            'parcelle' => 'PAR-003',
            'ancienne_superficie' => 500,
        ]));

        $this->actingAs($this->chefService);

        $response = $this->put("/parcelles/{$parcelle->id}", $this->parcelleData([
            'parcelle' => 'PAR-003',
            'ancienne_superficie' => 600,
        ]));

        $response->assertRedirect();
        $this->assertDatabaseHas('parcelles', [
            'id' => $parcelle->id,
            'ancienne_superficie' => 600,
        ]);
    }

    /**
     * TU-07 : Modification parcelle (champ sensible : statut) par Chef service
     */
    public function test_update_parcelle_sensitive_field_by_chef_service()
    {
        $parcelle = Parcelle::create($this->parcelleData([
            'parcelle' => 'PAR-004',
            'ancienne_superficie' => 500,
        ]));

        $this->actingAs($this->chefService);

        $response = $this->put("/parcelles/{$parcelle->id}", $this->parcelleData([
            'parcelle' => 'PAR-004',
            'ancienne_superficie' => 500,
            'statut_attribution' => 'non attribué',
            'director_password' => 'password123',
        ]));

        $response->assertRedirect();
    }

    /**
     * TU-08 : Modification parcelle par Secrétaire (sans permission edit)
     */
    public function test_update_parcelle_by_secretary()
    {
        $parcelle = Parcelle::create($this->parcelleData([
            'parcelle' => 'PAR-005',
            'ancienne_superficie' => 500,
        ]));

        $this->actingAs($this->secretaire);

        $response = $this->put("/parcelles/{$parcelle->id}", $this->parcelleData([
            'parcelle' => 'PAR-005',
            'ancienne_superficie' => 500,
            'statut_attribution' => 'non attribué',
        ]));

        $response->assertStatus(403);
    }

    /**
     * TU-09 : Audit log créé lors de la création
     */
    public function test_audit_log_created_on_create()
    {
        $this->actingAs($this->chefService);

        $response = $this->post('/parcelles', $this->parcelleData([
            'parcelle' => 'PAR-006',
        ]));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'create',
            'model_type' => 'App\\Models\\Parcelle',
        ]);
    }

    /**
     * TU-10 : Audit log créé lors de la modification
     */
    public function test_audit_log_created_on_update()
    {
        $parcelle = Parcelle::create($this->parcelleData([
            'parcelle' => 'PAR-007',
            'ancienne_superficie' => 500,
        ]));

        $this->actingAs($this->chefService);

        $this->put("/parcelles/{$parcelle->id}", $this->parcelleData([
            'parcelle' => 'PAR-007',
            'ancienne_superficie' => 700,
        ]));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'update',
            'model_type' => 'App\\Models\\Parcelle',
            'model_id' => $parcelle->id,
        ]);
    }

    /**
     * TU-11 : Suppression d'une parcelle (Directeur)
     */
    public function test_delete_parcelle_by_director()
    {
        $parcelle = Parcelle::create($this->parcelleData([
            'parcelle' => 'PAR-008',
            'ancienne_superficie' => 500,
        ]));

        $this->actingAs($this->directeur);

        $response = $this->delete("/parcelles/{$parcelle->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('parcelles', [
            'id' => $parcelle->id,
        ]);
    }

    /**
     * TU-12 : Suppression d'une parcelle refusée (Chef service sans permission)
     */
    public function test_delete_parcelle_by_chef_service_forbidden()
    {
        $parcelle = Parcelle::create($this->parcelleData([
            'parcelle' => 'PAR-009',
            'ancienne_superficie' => 500,
        ]));

        $this->actingAs($this->chefService);

        $response = $this->delete("/parcelles/{$parcelle->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('parcelles', [
            'id' => $parcelle->id,
        ]);
    }
}
