<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur; // Modifié: User -> Utilisateur
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage-users', ['except' => ['showProfile', 'showChangePasswordForm', 'changePassword']]);
    }

    public function index()
    {
        // Modifié: User -> Utilisateur
        $users = Utilisateur::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all()->pluck('name');
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Modifié: unique:users,email -> unique:utilisateurs,email
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        // Modifié: User -> Utilisateur
        $user = Utilisateur::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Modifié: bcrypt -> Hash::make
            'email_verified_at' => now(), // Ajout de la vérification d'email
        ]);

        $user->assignRole($validated['role']);

        // Modifié: 'model_type' => 'User' -> 'model_type' => Utilisateur::class
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'model_type' => Utilisateur::class,
            'model_id' => $user->id,
            'changes' => json_encode($validated),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur créé avec succès');
    }

    public function show(Utilisateur $user) // Modifié: User -> Utilisateur
    {
        return view('users.show', compact('user'));
    }

    public function edit(Utilisateur $user) // Modifié: User -> Utilisateur
    {
        $roles = Role::all()->pluck('name');
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, Utilisateur $user) // Modifié: User -> Utilisateur
    {
        // Modifié: unique:users,email -> unique:utilisateurs,email
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $oldData = $user->toArray();

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']); // Modifié: bcrypt -> Hash::make
        }

        $user->update($updateData);
        $user->syncRoles($validated['role']);

        // Modifié: 'model_type' => 'User' -> 'model_type' => Utilisateur::class
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'model_type' => Utilisateur::class,
            'model_id' => $user->id,
            'changes' => json_encode([
                'old' => $oldData,
                'new' => $validated,
            ]),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function destroy(Utilisateur $user) // Modifié: User -> Utilisateur
    {
        $oldData = $user->toArray();

        // Ajout: Détacher les rôles avant suppression (bonne pratique avec Spatie)
        $user->roles()->detach();

        $user->delete();

        // Modifié: 'model_type' => 'User' -> 'model_type' => Utilisateur::class
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'model_type' => Utilisateur::class,
            'model_id' => $user->id,
            'changes' => json_encode(['old' => $oldData]),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimé avec succès');
    }

    public function showProfile()
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    public function showChangePasswordForm()
    {
        return view('auth.passwords.change');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        // Modifié: 'model_type' => 'User' -> 'model_type' => Utilisateur::class
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'model_type' => Utilisateur::class,
            'model_id' => Auth::id(),
            'changes' => json_encode(['password' => 'changed']),
        ]);

        return redirect()->route('dashboard')->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
