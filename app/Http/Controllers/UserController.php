<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all()->pluck('name');
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'model_type' => 'User',
            'model_id' => $user->id,
            'changes' => json_encode($validated),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur créé avec succès');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all()->pluck('name');
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $oldData = $user->toArray();

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        $user->update($updateData);
        $user->syncRoles($validated['role']);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'model_type' => 'User',
            'model_id' => $user->id,
            'changes' => json_encode([
                'old' => $oldData,
                'new' => $validated,
            ]),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function destroy(User $user)
    {
        $oldData = $user->toArray();
        $user->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'model_type' => 'User',
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

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'model_type' => 'User',
            'model_id' => Auth::id(),
            'changes' => json_encode(['password' => 'changed']),
        ]);

        return redirect()->route('dashboard')->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
