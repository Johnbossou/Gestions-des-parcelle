<?php
namespace App\Http\Exports;

use App\Models\Parcelle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParcellesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;
    protected $format;

    public function __construct(array $filters = [], string $format = 'excel')
    {
        $this->filters = $filters;
        $this->format = $format;
    }

    public function collection()
    {
        $query = Parcelle::query();

        // Appliquer les filtres si présents
        if (!empty($this->filters['arrondissement'])) {
            $query->where('arrondissement', $this->filters['arrondissement']);
        }

        if (!empty($this->filters['type_occupation'])) {
            $query->where('type_occupation', $this->filters['type_occupation']);
        }

        if (!empty($this->filters['statut_attribution'])) {
            $query->where('statut_attribution', $this->filters['statut_attribution']);
        }

        if (isset($this->filters['litige']) && $this->filters['litige'] !== '') {
            $query->where('litige', $this->filters['litige']);
        }

        if (!empty($this->filters['structure'])) {
            $query->where('structure', 'like', '%' . $this->filters['structure'] . '%');
        }

        if (!empty($this->filters['ancienne_superficie_min'])) {
            $query->where('ancienne_superficie', '>=', $this->filters['ancienne_superficie_min']);
        }

        if (!empty($this->filters['ancienne_superficie_max'])) {
            $query->where('ancienne_superficie', '<=', $this->filters['ancienne_superficie_max']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Numero',
            'Arrondissement',
            'Secteur',
            'Lot',
            'Designation',
            'Parcelle',
            'Ancienne Superficie',
            'Nouvelle Superficie',
            'Ecart Superficie',
            'Motif',
            'Observations',
            'Type Occupation',
            'Details Occupation',
            'Reference Autorisation',
            'Date Autorisation',
            'Date Expiration Autorisation',
            'Statut Attribution',
            'Litige',
            'Details Litige',
            'Structure',
            'Latitude',
            'Longitude',
            'Agent ID',
            'Responsable ID',
            'Updated By',
            'Created By'
        ];
    }

    public function map($parcelle): array
    {
        return [
            $parcelle->id,
            $parcelle->numero,
            $parcelle->arrondissement,
            $parcelle->secteur,
            $parcelle->lot,
            $parcelle->designation,
            $parcelle->parcelle,
            $parcelle->ancienne_superficie,
            $parcelle->nouvelle_superficie,
            $parcelle->ecart_superficie,
            $parcelle->motif,
            $parcelle->observations,
            // CORRIGÉ: Conversion explicite de l'énumération en string
            $parcelle->type_occupation instanceof \App\Enums\TypeOccupation
                ? $parcelle->type_occupation->value
                : $parcelle->type_occupation,
            $parcelle->details_occupation,
            $parcelle->reference_autorisation,
            $parcelle->date_autorisation,
            $parcelle->date_expiration_autorisation,
            $parcelle->statut_attribution,
            $parcelle->litige === null ? 'Non défini' : ($parcelle->litige ? 'Oui' : 'Non'),
            $parcelle->details_litige,
            $parcelle->structure,
            $parcelle->latitude,
            $parcelle->longitude,
            $parcelle->agent_id,
            $parcelle->responsable_id,
            $parcelle->updated_by,
            $parcelle->created_by,
        ];
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
