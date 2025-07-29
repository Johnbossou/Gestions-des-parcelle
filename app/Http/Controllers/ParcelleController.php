<?php
namespace App\Http\Controllers;

use App\Models\Parcelle;
use App\Models\AuditLog;
use App\Http\Exports\ParcellesExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ParcelleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'create', 'show', 'edit', 'editCoordinates']);
        $this->middleware('permission:view-parcels')->only(['index', 'show', 'filter']);
        $this->middleware('permission:create-parcelles')->only(['create', 'store']);
        $this->middleware('permission:edit-parcelles')->only(['edit', 'update']);
        $this->middleware('permission:delete-parcels')->only('destroy');
        $this->middleware('permission:edit-coordinates')->only(['editCoordinates', 'updateCoordinates']);
        $this->middleware('permission:manage-litiges')->only(['store', 'update']);
    }

    public function index(Request $request)
    {
        $query = Parcelle::query();
        // Appliquer les filtres
        if ($request->filled('arrondissement')) {
            $query->where('arrondissement', $request->arrondissement);
        }
        if ($request->filled('type_terrain')) {
            $query->where('type_terrain', $request->type_terrain);
        }
        if ($request->filled('statut_attribution')) {
            $query->where('statut_attribution', $request->statut_attribution);
        }
        if ($request->filled('litige') && $request->litige !== '') {
            $query->where('litige', $request->litige === '1');
        }
        if ($request->filled('structure')) {
            $query->where('structure', 'like', '%' . $request->structure . '%');
        }
        // ... avant pagination, dans index()

        if ($request->filled('ancienne_superficie_min')) {
            $query->where('ancienne_superficie', '>=', $request->ancienne_superficie_min);
        }
        if ($request->filled('ancienne_superficie_max')) {
            $query->where('ancienne_superficie', '<=', $request->ancienne_superficie_max);
        }

        $parcelles = $query->paginate(10)->appends($request->query());
        $stats = [
            'total' => Parcelle::count(),
            'arrondissements' => Parcelle::distinct('arrondissement')->count(),
            'attribuees' => Parcelle::where('statut_attribution', 'attribué')->count(),
            'litiges' => Parcelle::where('litige', true)->count(),
            'residentiel' => Parcelle::where('type_terrain', 'Résidentiel')->count(),
            'commercial' => Parcelle::where('type_terrain', 'Commercial')->count(),
            'agricole' => Parcelle::where('type_terrain', 'Agricole')->count(),
            'institutionnel' => Parcelle::where('type_terrain', 'Institutionnel')->count(),
        ];
        $arrondissements = Parcelle::distinct('arrondissement')->pluck('arrondissement')->toArray();
        $types_terrain = ['Résidentiel', 'Commercial', 'Agricole', 'Institutionnel', 'Autre'];
        $statuts = ['attribué', 'non attribué'];
        return view('parcelles.index', compact('parcelles', 'stats', 'arrondissements', 'types_terrain', 'statuts'));
    }

    public function create()
    {
        return view('parcelles.create');
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
            'type_terrain' => 'required|in:Résidentiel,Commercial,Agricole,Institutionnel,Autre',
            'statut_attribution' => 'required|in:attribué,non attribué',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'litige' => 'required|boolean',
            'details_litige' => 'nullable|string',
            'structure' => 'nullable|string',
        ]);

        // Générer un numéro unique
        do {
            $numero = rand(1000, 9999);
        } while (Parcelle::where('numero', $numero)->exists());

        $data['numero'] = $numero;
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
        return view('parcelles.show', compact('parcelle'));
    }

    public function edit(Parcelle $parcelle)
    {
        return view('parcelles.edit', compact('parcelle'));
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
            'type_terrain' => 'required|in:Résidentiel,Commercial,Agricole,Institutionnel,Autre',
            'statut_attribution' => 'required|in:attribué,non attribué',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'litige' => 'required|boolean',
            'details_litige' => 'nullable|string',
            'structure' => 'nullable|string',
        ]);

        $data['updated_by'] = Auth::id();
        $changes = array_diff_assoc($data, $parcelle->toArray());
        $parcelle->update($data);
        if ($changes) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'update',
                'model_type' => Parcelle::class,
                'model_id' => $parcelle->id,
                'changes' => json_encode($changes),
            ]);
        }

        return $request->expectsJson()
            ? response()->json($parcelle)
            : redirect()->route('dashboard')->with('success', 'Parcelle modifiée avec succès.');
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
        $parcelle->update($data);
        if ($changes) {
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
        if ($request->has('type_terrain') && $request->type_terrain) {
            $query->where('type_terrain', $request->type_terrain);
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
            $direction = $request->input('sort_direction', 'asc');
            $query->orderBy($request->sort_by, $direction);
        }
        $parcelles = $query->paginate(10)->appends($request->query());
        return response()->json($parcelles);
    }

    public function export(Request $request)
    {
        $filters = $request->only([
            'arrondissement',
            'type_terrain',
            'statut_attribution',
            'litige',
            'structure',
            'ancienne_superficie_min',
            'ancienne_superficie_max'
        ]);
        $format = $request->input('format', 'excel');
        $export = new ParcellesExport($filters, $format);

        if ($format === 'pdf') {
            $parcelles = $export->collection();
            $pdf = Pdf::loadView('exports.parcelles', [ // Utilisez Pdf au lieu de \PDF
                'parcelles' => $parcelles,
                'filters' => $filters
            ]);
            return $pdf->download('parcelles.pdf');
        }

        return Excel::download($export, 'parcelles.xlsx');
    }
}
