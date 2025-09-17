@extends('layouts.app')
@section('title', 'Modifier l\'utilisateur')
@section('content')
<div class="content-container">
    <div class="form-header">
        <h2 class="form-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 极 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Modifier l'utilisateur #{{ $user->id }}
        </h2>
        <p class="form-description">Mettez à jour les informations de cet utilisateur</p>
    </div>

    <div class="form-card">
        <form action="{{ route('users.update', $user) }}" method="POST" class="form-grid">
            @csrf
            @method('PUT')

            <!-- Section Informations personnelles -->
            <div class="form-section-header">
                <svg xmlns="http://www.w3.org/2000/svg" fill极none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7极14a7 7 0 00-7-7z" />
                </svg>
                <h3>Informations personnelles</h3>
            </div>

            <div class="form-group">
                <label for="name">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7极" />
                    </svg>
                    Nom complet
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">
                    <svg xmlns="http://www.w3.org/2000/s极" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Adresse email
                </label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Section Sécurité -->
            <div class="form-section-header">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0极4h8z" />
                </svg>
                <h3>Sécurité</h3>
            </div>

            <div class="form-group">
                <label for="password">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 极 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Nouveau mot de passe
                </label>
                <div class="password-input">
                    <input type="password" id="password" name="password" class="form-control">
                    <button type="button" class="password-toggle" aria-label="Afficher le mot de passe">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.极-7z" />
                        </svg>
                    </button>
                </div>
                <p class="hint-text">Laissez vide pour ne pas modifier</p>
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Confirmer le mot de passe
                </label>
                <div class="password-input">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                    <button type="button" class极password-toggle" aria-label="Afficher le mot de passe">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12极3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Section Rôles -->
            <div class="form-section-header">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572极1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.极 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <h3>Permissions</h3>
            </div>

            <!-- Section Rôles -->
            <div class="form-group full-width">
                <label class="roles-label">Rôle attribué</label>
                <div class="roles-grid">
                    @php
                        $roles = [
                            'chef_service' => 'Chef de Service',
                            'secretaire_executif' => 'Secrétaire Exécutif',
                            'Consultant' => 'Consultant',
                            'chef_division' => 'Chef de Division',
                            'dsi' => 'DSI',
                            'Directeur' => 'Directeur'
                        ];

                        $descriptions = [
                            'chef_service' => 'Gestion complète des parcelles',
                            'secretaire_executif' => 'Consultation et exportation',
                            'Consultant' => 'Consultation et exportation',
                            'chef_division' => 'Gestion restreinte des parcelles',
                            'dsi' => 'Gestion des utilisateurs',
                            'Directeur' => 'Validation des modifications'
                        ];

                        $icons = [
                            'chef_service' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0极5M9 7h1m-1 4h1m4-4h1极-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />',
                            'secretaire_executif' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
                            'Consultant' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 极 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
                            'chef_division' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />',
                            'dsi' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2极24 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />',
                            'Directeur' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />'
                        ];
                    @endphp

                    @foreach($roles as $roleValue => $roleLabel)
                    <label class="role-option">
                        <input type="radio" name="role" value="{{ $roleValue }}" {{ old('role', $user->getRoleNames()->first()) == $roleValue ? 'checked' : '' }} class="role-radio" required>
                        <div class="role-card">
                            <div class="role-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    {!! $icons[$roleValue] !!}
                                </svg>
                            </div>
                            <div class="role-info">
                                <span class="role-name">{{ $roleLabel }}</span>
                                <span class="role-description">
                                    {{ $descriptions[$roleValue] }}
                                </span>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('role')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions du formulaire -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Mettre à jour
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Variables CSS */
    :root {
        --primary: #1A5F23;
        --secondary: #F9A825;
        --accent: #E30613;
        --neutral: #F5F5F5;
        --black: #333333;
        --white: #FFFFFF;
        --blue: #0A66C2;
        --success: #4CAF50;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --radius-sm: 0.25rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --transition: all 0.2s ease;
    }

    /* Structure principale */
    .content-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .form-header {
        margin-bottom: 2rem;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .form-title svg {
        width: 2rem;
        height: 2rem;
        color: var(--secondary);
    }

    .form-description {
        color: var(--black);
        font-size: 1.125rem;
    }

    .form-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 2.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    /* Groupes de formulaire */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        font-weight: 500;
        color: var(--black);
    }

    .form-group label svg {
        width: 1.25rem;
        height: 1.25rem;
        color: var(--secondary);
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--neutral);
        border-radius: var(--radius-md);
        font-size: 0.9375rem;
        transition: var(--transition);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26, 95, 35, 0.15);
    }

    /* Sections */
    .form-section-header {
        grid-column: 1 / -1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 1.5rem 0 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--neutral);
    }

    .form-section-header h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary);
    }

    .form-section-header svg {
        width: 1.5rem;
        height: 1.5rem;
        color: var(--secondary);
    }

    /* Mot de passe */
    .password-input {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--blue);
        cursor: pointer;
        padding: 0.25rem;
    }

    .password-toggle:hover {
        color: var(--success);
    }

    .hint-text {
        font-size: 0.75rem;
        color: var(--black);
        margin-top: 0.25rem;
    }

    /* Rôles */
    .roles-label {
        display: block;
        margin-bottom: 1rem;
        font-weight: 500;
        color: var(--black);
    }

    .roles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .role-option {
        display: block;
    }

    .role-radio {
        position: absolute;
        opacity: 0;
    }

    .role-radio:checked + .role-card {
        border-color: var(--primary);
        background-color: var(--neutral);
    }

    .role-card {
        padding: 1rem;
        border: 1px solid var(--neutral);
        border-radius: var(--radius-md);
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
    }

    .role-card:hover {
        border-color: var(--success);
    }

    .role-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background: var(--neutral);
        color: var(--secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .role-icon svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .role-info {
        flex: 1;
    }

    .role-name {
        display: block;
        font-weight: 500;
        color: var(--black);
        margin-bottom: 0.25rem;
    }

    .role-description {
        display: block;
        font-size: 0.8125rem;
        color: var(--black);
    }

    /* Actions */
    .form-actions {
        grid-column: 1 / -1;
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--neutral);
    }

    .btn {
        padding: 0.875rem 1.75rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        border: none;
    }

    .btn-primary {
        background-color: var(--primary);
        color: var(--white);
    }

    .btn-primary:hover {
        background-color: var(--success);
    }

    .btn-secondary {
        background-color: var(--secondary);
        color: var(--black);
    }

    .btn-secondary:hover {
        background-color: #FCD116;
    }

    .btn svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    /* Erreurs */
    .error-message {
        color: var(--accent);
        font-size: 0.8125rem;
        margin-top: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-container {
            padding: 1.5rem;
        }

        .form-card {
            padding: 1.5rem;
        }

        .form-title {
            font-size: 1.75rem;
        }

        .form-actions {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .form-title {
            font-size: 1.5rem;
        }

        .roles-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Toggle visibilité mot de passe
        const passwordToggles = document.querySelectorAll('.password-toggle');
        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                const input = e.currentTarget.closest('.password-input').querySelector('input');
                const icon = e.currentTarget.querySelector('svg');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3极3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
                } else {
                    input.type = 'password';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                }
            });
        });

        // Focus sur le premier champ en erreur
        const firstError = document.querySelector('.error-message');
        if (firstError) {
            const input = firstError.closest('.form-group').querySelector('input, select, textarea');
            input?.focus();
        }
    });
</script>
@endsection
