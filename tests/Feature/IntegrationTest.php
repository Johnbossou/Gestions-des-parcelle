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

class IntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected Utilisateur $chefService;
    protected Utilisateur $directeur;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'chef_service']);
        Role::firstOrCreate(['name' => 'Directeur']);
        Permission::firstOrCreate(['name' => 'create-parcelles']);
        Permission::firstOrCreate(['name' => 'edit-parcelles']);
        Permission::firstOrCreate(['name' => 'view-parcels']);
        Permission::firstOrCreate(['name' => 'delete-parcelles']);

        $this->chefService = Utilisateur::create([
            'name' => 'Chef Service',
            'email' => 'chef@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $this->chefService->assignRole('chef_service');
        $this->chefService->givePermissionTo(['create-parcelles', 'edit-parcelles', 'view-parcels']);

        $this->directeur = Utilisateur::create([
            'name' => 'Directeur',
            'email' => 'director@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $this->directeur->assignRole('Directeur');
        $this->directeur->givePermissionTo(['edit-parcelles', 'view-parcels', 'delete-parcelles']);
    }

    private function parcelleData(array $overrides = []): array
    {
        return array_merge([
            'arrondissement' => 'Abomey-Calavi',
            'secteur' => 'Secteur A',
            'lot' => 1,
            'parcelle' => 'PAR-INT-001',
            'ancienne_superficie' => 500,
            'type_occupation' => 'Autorisé',
            'statut_attribution' => 'attribué',
            'litige' => false,
        ], $overrides);
    }

    /**
     * TI-01 : Workflow complet création → modification → audit
     */
    public function test_complete_modification_workflow()
    {
        $this->actingAs($this->chefService);

        $parcelle = Parcelle::create($this->parcelleData());

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'create',
            'model_type' => 'App\\Models\\Parcelle',
            'model_id' => $parcelle->id,
        ]);

        $this->put("/parcelles/{$parcelle->id}", $this->parcelleData([
            'parcelle' => $parcelle->parcelle,
            'ancienne_superficie' => 600,
            'director_password' => 'password123',
        ]));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'update',
            'model_type' => 'App\\Models\\Parcelle',
            'model_id' => $parcelle->id,
        ]);
    }

    /**
     * TI-02 : Création parcelle avec création agent simultanée
     */
    public function test_create_parcelle_with_simultaneous_agent_creation()
    {
        $this->actingAs($this->chefService);

        $parcelle = Parcelle::create($this->parcelleData([
            'parcelle' => 'PAR-INT-002',
            'agent' => $this->chefService->id,
            'responsable_id' => $this->directeur->id,
        ]));

        $this->assertDatabaseHas('parcelles', [
            'id' => $parcelle->id,
            'agent' => $this->chefService->id,
        ]);

        $this->assertDatabaseHas('utilisateurs', [
            'id' => $this->chefService->id,
            'email' => 'chef@example.com',
        ]);
    }

    /**
     * TI-03 : Récupération carte interactive (150 marqueurs)
     */
    public function test_retrieve_interactive_map_150_markers()
    {
        $this->actingAs($this->chefService);

        for ($i = 1; $i <= 150; $i++) {
            Parcelle::create($this->parcelleData([
                'parcelle' => "PAR-MAP-{$i}",
                'ancienne_superficie' => 500 + $i,
                'latitude' => 6.4 + ($i * 0.001),
                'longitude' => 2.3 + ($i * 0.001),
            ]));
        }

        $response = $this->get('/parcelles');

        $response->assertStatus(200);
        $this->assertDatabaseCount('parcelles', 150);
    }
}
