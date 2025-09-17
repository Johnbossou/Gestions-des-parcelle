<?php

namespace App\Http\Controllers;

use App\Models\Parcelle;
use App\Imports\ParcellesImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\AuditLog;
use App\Models\ValidationLog;
use Illuminate\Support\Facades\DB;
use App\Models\Utilisateur;
use App\Http\Exports\ParcellesExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Enums\TypeOccupation;

class ParcelleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('require.director.approval')->only(['update']);
        $this->middleware('permission:view-parcels')->only(['index', 'show', 'filter']);
        $this->middleware('permission:create-parcelles')->only(['create', 'store']);
        $this->middleware('permission:edit-parcelles')->only(['edit', 'update']);
        $this->middleware('permission:delete-parcels')->only('destroy');
        $this->middleware('permission:edit-coordinates')->only(['editCoordinates', 'updateCoordinates']);
        $this->middleware('permission:manage-litiges')->only(['store', 'update']);
        $this->middleware('permission:import-parcelles')->only(['importForm', 'import']);
    }

    public function index(Request $request)
    {
        $query = Parcelle::query()->with(['agent', 'responsable']);

        // Appliquer les filtres
        if ($request->filled('arrondissement')) {
            $query->whereRaw('LOWER(arrondissement) = ?', [strtolower($request->arrondissement)]);
        }
        if ($request->filled('type_occupation')) {
            $query->where('type_occupation', $request->type_occupation);
        }
        if ($request->filled('statut_attribution')) {
            $query->where('statut_attribution', $request->statut_attribution);
        }
        if ($request->filled('litige') && $request->litige !== '') {
            $query->where('litige', $request->litige === '1');
        }
        if ($request->filled('structure')) {
            $query->whereRaw('LOWER(structure) LIKE ?', ['%' . strtolower($request->structure) . '%']);
        }
        if ($request->filled('ancienne_superficie_min')) {
            $query->where('ancienne_superficie', '>=', $request->ancienne_superficie_min);
        }
        if ($request->filled('ancienne_superficie_max')) {
            $query->where('ancienne_superficie', '<=', $request->ancienne_superficie_max);
        }

        $query->orderBy('updated_at', 'desc');
        $parcelles = $query->paginate(10)->appends($request->query());

        // Calcul des statistiques
        $stats = [
            'total' => Parcelle::count(),
            'arrondissements' => Parcelle::distinct('arrondissement')->count(),
            'attribuees' => Parcelle::where('statut_attribution', 'attribué')->count(),
            'litiges' => Parcelle::where('litige', true)->count(),
            'autorise' => Parcelle::where('type_occupation', TypeOccupation::AUTORISE)->count(),
            'anarchique' => Parcelle::where('type_occupation', TypeOccupation::ANARCHIQUE)->count(),
            'libre' => Parcelle::where('type_occupation', TypeOccupation::LIBRE)->count(),
        ];

        // AJOUT: Données de répartition par arrondissement
        $stats['arrondissements_data'] = Parcelle::select('arrondissement', DB::raw('count(*) as count'))
            ->groupBy('arrondissement')
            ->pluck('count', 'arrondissement')
            ->toArray();

        // Évolutions mensuelles
        $stats['evolution_mois'] = [
            'total' => $this->calculateEvolution('total'),
            'litiges' => $this->calculateEvolution('litige', true),
            'attribuees' => $this->calculateEvolution('statut_attribution', 'attribué'),
            'autorise' => $this->calculateEvolution('type_occupation', TypeOccupation::AUTORISE->value),
            'anarchique' => $this->calculateEvolution('type_occupation', TypeOccupation::ANARCHIQUE->value),
            'libre' => $this->calculateEvolution('type_occupation', TypeOccupation::LIBRE->value),
        ];

        // Données pour la carte interactive - VERSION COMPLÈTE pour correspondre à la vue
        $coordonnees = Parcelle::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('id', 'numero', 'parcelle', 'latitude', 'longitude',
                    'arrondissement', 'statut_attribution', 'type_occupation',
                    'nouvelle_superficie', 'ancienne_superficie', 'litige', 'structure')
            ->get();

        $arrondissements = Parcelle::select('arrondissement')->distinct()->orderBy('arrondissement')->pluck('arrondissement')->toArray();
        $types_occupation = TypeOccupation::values();
        $statuts = ['attribué', 'non attribué'];

        return view('parcelles.index', compact('parcelles', 'stats', 'arrondissements', 'types_occupation', 'statuts', 'coordonnees'));
    }

    private function calculateEvolution($field, $value = null)
    {
        $maintenant = now();
        $moisDernier = now()->subMonth();

        if ($value === true) {
            $countMaintenant = Parcelle::where('litige', true)
                ->whereMonth('created_at', $maintenant->month)
                ->whereYear('created_at', $maintenant->year)
                ->count();
            $countMoisDernier = Parcelle::where('litige', true)
                ->whereMonth('created_at', $moisDernier->month)
                ->whereYear('created_at', $moisDernier->year)
                ->count();
        } elseif ($value) {
            $countMaintenant = Parcelle::where($field, $value)
                ->whereMonth('created_at', $maintenant->month)
                ->whereYear('created_at', $maintenant->year)
                ->count();
            $countMoisDernier = Parcelle::where($field, $value)
                ->whereMonth('created_at', $moisDernier->month)
                ->whereYear('created_at', $moisDernier->year)
                ->count();
        } else {
            $countMaintenant = Parcelle::whereMonth('created_at', $maintenant->month)
                ->whereYear('created_at', $maintenant->year)
                ->count();
            $countMoisDernier = Parcelle::whereMonth('created_at', $moisDernier->month)
                ->whereYear('created_at', $moisDernier->year)
                ->count();
        }

        return $countMoisDernier == 0 ? 0 : round((($countMaintenant - $countMoisDernier) / $countMoisDernier) * 100, 1);
    }

    public function create()
    {
        $users = Utilisateur::all();
        $types_occupation = TypeOccupation::values();
        return view('parcelles.create', compact('users', 'types_occupation'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'arrondissement' => 'required|string',
            'secteur' => 'required|string',
            'lot' => 'required|numeric',
            'designation' => 'nullable|string',
            'parcelle' => 'nullable|string',
            'ancienne_superficie' => 'nullable|numeric',
            'nouvelle_superficie' => 'nullable|numeric',
            'motif' => 'nullable|string',
            'observations' => 'nullable|string',
            'type_occupation' => 'required|in:' . implode(',', TypeOccupation::values()),
            'details_occupation' => 'nullable|string',
            'reference_autorisation' => 'nullable|string|max:100',
            'date_autorisation' => 'nullable|date',
            'date_expiration_autorisation' => 'nullable|date|after_or_equal:date_autorisation',
            'statut_attribution' => 'required|in:attribué,non attribué',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'litige' => 'required|boolean',
            'details_litige' => 'nullable|string',
            'structure' => 'nullable|string',
            'agent_id' => 'nullable',
            'agent_name' => 'nullable|string|max:255',
            'responsable_id' => 'nullable',
            'responsable_name' => 'nullable|string|max:255',
        ]);

        // Gestion Agent “Autre…”
        if ($request->agent_id === 'custom' && $request->filled('agent_name')) {
            $agent = Utilisateur::create(['name' => $request->agent_name]);
            $data['agent_id'] = $agent->id;
        } else {
            $data['agent_id'] = $request->agent_id ?: null;
        }

        // Gestion Responsable “Autre…”
        if ($request->responsable_id === 'custom' && $request->filled('responsable_name')) {
            $responsable = Utilisateur::create(['name' => $request->responsable_name]);
            $data['responsable_id'] = $responsable->id;
        } else {
            $data['responsable_id'] = $request->responsable_id ?: null;
        }

        // Générer numéro unique
        do {
            $data['numero'] = rand(1000, 9999);
        } while (Parcelle::where('numero', $data['numero'])->exists());

        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $parcelle = Parcelle::create($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'model_type' => Parcelle::class,
            'model_id' => $parcelle->id,
            'changes' => json_encode($data),
        ]);

        return $request->expectsJson()
            ? response()->json($parcelle, 201)
            : redirect()->route('dashboard')->with('success', 'Parcelle créée avec succès.');
    }


    public function show(Parcelle $parcelle)
    {
        $parcelle->load(['agent', 'responsable', 'createdBy', 'updatedBy', 'validationLogs' => fn($q) => $q->latest()->with('director')]);
        return view('parcelles.show', compact('parcelle'));
    }

    public function edit(Parcelle $parcelle)
    {
        $users = Utilisateur::all();
        $types_occupation = TypeOccupation::values();
        return view('parcelles.edit', compact('parcelle', 'users', 'types_occupation'));
    }

    public function update(Request $request, Parcelle $parcelle)
    {
        $data = $request->validate([
            'numero' => 'required|numeric|unique:parcelles,numero,' . $parcelle->id,
            'arrondissement' => 'required|string',
            'secteur' => 'required|string',
            'lot' => 'required|numeric',
            'designation' => 'nullable|string',
            'parcelle' => 'nullable|string',
            'ancienne_superficie' => 'nullable|numeric',
            'nouvelle_superficie' => 'nullable|numeric',
            'motif' => 'nullable|string',
            'observations' => 'nullable|string',
            'type_occupation' => 'required|in:' . implode(',', TypeOccupation::values()),
            'details_occupation' => 'nullable|string',
            'reference_autorisation' => 'nullable|string|max:100',
            'date_autorisation' => 'nullable|date',
            'date_expiration_autorisation' => 'nullable|date|after_or_equal:date_autorisation',
            'statut_attribution' => 'required|in:attribué,non attribué',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'litige' => 'required|boolean',
            'details_litige' => 'nullable|string',
            'structure' => 'nullable|string',
            'agent_id' => 'nullable',
            'agent_name' => 'nullable|string|max:255',
            'responsable_id' => 'nullable',
            'responsable_name' => 'nullable|string|max:255',
        ]);

        // Gestion Agent “Autre…”
        if ($request->agent_id === 'custom' && $request->filled('agent_name')) {
            $agent = Utilisateur::create(['name' => $request->agent_name]);
            $data['agent_id'] = $agent->id;
        } else {
            $data['agent_id'] = $request->agent_id ?: null;
        }

        // Gestion Responsable “Autre…”
        if ($request->responsable_id === 'custom' && $request->filled('responsable_name')) {
            $responsable = Utilisateur::create(['name' => $request->responsable_name]);
            $data['responsable_id'] = $responsable->id;
        } else {
            $data['responsable_id'] = $request->responsable_id ?: null;
        }

        if (Auth::user()->hasRole('chef_service')) {
            $request->validate(['director_password' => 'required|string']);

            $director = Utilisateur::role('Directeur')->first();
            if (!$director || !Hash::check($request->director_password, $director->password)) {
                return back()->withErrors(['director_password' => 'Mot de passe du Directeur incorrect'])->withInput();
            }
        }

        $data['updated_by'] = Auth::id();
        $changes = array_diff_assoc($data, $parcelle->toArray());

        if (!empty($changes)) {
            $parcelle->update($data);

            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'update',
                'model_type' => Parcelle::class,
                'model_id' => $parcelle->id,
                'changes' => json_encode($changes),
            ]);

            if (Auth::user()->hasRole('chef_service')) {
                ValidationLog::create([
                    'parcelle_id' => $parcelle->id,
                    'action' => 'parcelle_update',
                    'user_id' => Auth::id(),
                    'director_id' => $director->id,
                    'ip_address' => $request->ip(),
                ]);
            }
        }

        return $request->expectsJson()
            ? response()->json($parcelle)
            : redirect()->route('parcelles.index')->with('success', 'Parcelle modifiée avec succès.');
    }


    public function destroy(Parcelle $parcelle)
    {
        $parcelle->delete();
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'model_type' => Parcelle::class,
            'model_id' => $parcelle->id,
            'changes' => [],
        ]);

        return request()->expectsJson()
            ? response()->json(['message' => 'Parcelle supprimée'])
            : redirect()->route('dashboard')->with('success', 'Parcelle supprimée avec succès.');
    }

    public function editCoordinates(Parcelle $parcelle)
    {
        return view('parcelles.coordinates', compact('parcelle'));
    }

    public function updateCoordinates(Request $request, Parcelle $parcelle)
    {
        $data = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $data['updated_by'] = Auth::id();
        $changes = array_diff_assoc($data, $parcelle->only(['latitude', 'longitude']));

        if (!empty($changes)) {
            $parcelle->update($data);
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'update_coordinates',
                'model_type' => Parcelle::class,
                'model_id' => $parcelle->id,
                'changes' => json_encode($changes),
            ]);
        }

        return $request->expectsJson()
            ? response()->json($parcelle)
            : redirect()->route('parcelles.show', $parcelle)->with('success', 'Coordonnées mises à jour.');
    }

    public function filter(Request $request)
    {
        $query = Parcelle::query();

        if ($request->has('arrondissement') && $request->arrondissement) {
            $query->where('arrondissement', $request->arrondissement);
        }
        if ($request->has('type_occupation') && $request->type_occupation) {
            $query->where('type_occupation', $request->type_occupation);
        }
        if ($request->has('statut_attribution') && $request->statut_attribution) {
            $query->where('statut_attribution', $request->statut_attribution);
        }
        if ($request->has('litige') && $request->litige !== '') {
            $query->where('litige', $request->litige === '1');
        }
        if ($request->has('structure') && $request->structure) {
            $query->where('structure', 'like', '%' . $request->structure . '%');
        }
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->input('sort_direction', 'asc'));
        }

        return response()->json($query->paginate(10)->appends($request->query()));
    }

    public function export(Request $request)
    {
        $filters = $request->only([
            'arrondissement', 'type_occupation', 'statut_attribution',
            'litige', 'structure', 'ancienne_superficie_min', 'ancienne_superficie_max'
        ]);

        // Convertir les valeurs d'énumération en string pour l'export
        $filtersForExport = $filters;
        if (isset($filtersForExport['type_occupation']) && $filtersForExport['type_occupation'] instanceof \App\Enums\TypeOccupation) {
            $filtersForExport['type_occupation'] = $filtersForExport['type_occupation']->value;
        }

        $format = $request->input('format', 'excel');
        $export = new ParcellesExport($filtersForExport, $format);

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.parcelles', [
                'parcelles' => $export->collection(),
                'filters' => $filters
            ]);
            return $pdf->download('parcelles.pdf');
        }

        return Excel::download($export, 'parcelles.xlsx');
    }

    public function importForm()
    {
        return view('parcelles.import');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv|max:10240']);

        try {
            DB::beginTransaction();
            Excel::import(new ParcellesImport, $request->file('file'));
            DB::commit();
            return redirect()->route('parcelles.index')->with('success', 'Importation réussie !');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            DB::rollBack();
            $errors = collect($e->failures())->map(fn($failure) =>
                'Ligne ' . $failure->row() . ': ' . implode(', ', $failure->errors())
            );
            return redirect()->back()->withErrors($errors)->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur import parcelles: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'importation: ' . $e->getMessage());
        }
    }
}
