<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use App\Models\Parcelle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ExportImportTest extends TestCase
{
    use RefreshDatabase;

    protected Utilisateur $user;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'chef_service']);
        Permission::firstOrCreate(['name' => 'export-parcels']);
        Permission::firstOrCreate(['name' => 'import-parcelles']);

        $this->user = Utilisateur::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $this->user->assignRole('chef_service');
        $this->user->givePermissionTo(['export-parcels', 'import-parcelles']);

        for ($i = 1; $i <= 10; $i++) {
            Parcelle::create([
                'arrondissement' => 'Abomey-Calavi',
                'secteur' => 'Secteur A',
                'lot' => $i,
                'parcelle' => "PAR-0{$i}",
                'ancienne_superficie' => 500 + $i * 10,
                'type_occupation' => 'Autorisé',
                'statut_attribution' => 'attribué',
                'litige' => false,
                'agent' => $this->user->id,
                'responsable_id' => $this->user->id,
            ]);
        }
    }

    /**
     * TU-13 : Export Excel sans filtre
     */
    public function test_export_excel_without_filters()
    {
        $this->actingAs($this->user);

        $response = $this->get('/parcelles/export');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /**
     * TU-14 : Export Excel avec filtres
     */
    public function test_export_excel_with_filters()
    {
        $this->actingAs($this->user);

        $response = $this->get('/parcelles/export?type_occupation=Autorisé');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /**
     * TU-15 : Import Excel valide (50 lignes)
     */
    public function test_import_excel_valid_50_lines()
    {
        $this->actingAs($this->user);

        $rows = [['parcelle', 'arrondissement', 'secteur', 'lot', 'type_occupation', 'statut_attribution']];
        for ($i = 1; $i <= 50; $i++) {
            $rows[] = [
                "PAR-IMP-{$i}",
                'Abomey-Calavi',
                'Secteur A',
                $i,
                'Libre',
                'non attribué',
            ];
        }

        $file = $this->createExcelFile($rows);

        $response = $this->post('/parcelles/import', [
            'file' => $file,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('parcelles', 60);
    }

    /**
     * TU-16 : Import Excel avec erreurs (lignes invalides)
     */
    public function test_import_excel_with_errors()
    {
        $this->actingAs($this->user);

        $rows = [
            ['parcelle', 'arrondissement', 'secteur', 'lot'],
            ['PAR-ERR-1', null, null, null],
        ];

        $file = $this->createExcelFile($rows);

        $response = $this->post('/parcelles/import', [
            'file' => $file,
        ]);

        $response->assertStatus(302);
    }

    private function createExcelFile(array $rows): \Illuminate\Http\UploadedFile
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($rows as $rowIndex => $row) {
            foreach ($row as $colIndex => $value) {
                $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 1, $value);
            }
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'import_') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempFile);

        return new \Illuminate\Http\UploadedFile($tempFile, 'test_import.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);
    }
}
