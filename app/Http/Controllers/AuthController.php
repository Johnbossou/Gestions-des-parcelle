<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('logout');
        $this->middleware('guest')->only([
            'showLoginForm',
            'login',
            'showRegisterForm',
            'register',
            'showPasswordResetForm',
            'sendResetLinkEmail'
        ]);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            AuditLog::create([
                'user_id'    => $user->id,
                'action'     => 'login',
                'model_type' => Utilisateur::class,
                'model_id'   => $user->id,
                'changes'    => json_encode(['email' => $user->email]),
            ]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email'    => 'Les identifiants fournis ne correspondent pas.',
            'password' => 'Les identifiants fournis ne correspondent pas.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:utilisateurs,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Utilisateur::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'email_verified_at' => now(),
        ]);

        AuditLog::create([
            'user_id'    => null, // pas encore connecté
            'action'     => 'register',
            'model_type' => Utilisateur::class,
            'model_id'   => $user->id,
            'changes'    => json_encode([
                'name'  => $data['name'],
                'email' => $data['email']
            ]),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function showPasswordResetForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            AuditLog::create([
                'user_id'    => $user->id,
                'action'     => 'logout',
                'model_type' => Utilisateur::class,
                'model_id'   => $user->id,
                'changes'    => [],
            ]);

            // Supprimer le token si API
            if ($request->user() && method_exists($request->user(), 'currentAccessToken')) {
                $token = $request->user()->currentAccessToken();
                if ($token) {
                    $token->delete();
                }
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
