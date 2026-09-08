<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Parcelle;

class MigrateLegacyData extends Command
{
    protected $signature = 'migrate:legacy-data';
    protected $description = 'Migrate data from legacy parcelles table to new parcelles table';

    public function handle()
    {
        $this->info('Starting migration of legacy parcelles data...');

        try {
            $connection = DB::connection('legacy');
            if (!$connection->getDatabaseName()) {
                $this->error('La connexion "legacy" n\'est pas configurée dans config/database.php.');
                $this->error('Ajoutez une clé "legacy" dans le tableau des connexions avant d\'utiliser cette commande.');
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('Impossible de se connecter à la base "legacy" : ' . $e->getMessage());
            $this->error('Configurez la connexion "legacy" dans config/database.php puis réessayez.');
            return 1;
        }

        $connection->table('parcelles')->orderBy('N2')->chunk(100, function ($oldParcels) {
            foreach ($oldParcels as $old) {
                Parcelle::updateOrCreate(
                    ['parcelle' => $old->Parcelle],
                    [
                        'numero' => (int) $old->N2,
                        'arrondissement' => $old->Arrondissement,
                        'secteur' => $old->Secteur,
                        'lot' => $old->Lot,
                        'designation' => $old->Designation,
                        'ancienne_superficie' => $old->Ancienne,
                        'nouvelle_superficie' => $old->Nouvelle,
                        'ecart_superficie' => $old->Ecart,
                        'motif' => $old->Motif,
                        'observations' => $old->Observations,
                        'type_occupation' => null,
                        'statut_attribution' => null,
                        'date_mise_a_jour' => null,
                        'latitude' => null,
                        'longitude' => null,
                        'agent' => null,
                        'responsable_id' => null,
                        'updated_by' => null,
                        'created_by' => null,
                    ]
                );
            }
        });

        $this->info('Migration completed successfully.');
        return 0;
    }
}
