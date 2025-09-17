@extends('layouts.app')
@section('title', 'Nouvel utilisateur')
@section('content')
<div class="user-form-container">
    <div class="form-header">
        <h1 class="form-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Créer un nouvel utilisateur
        </h1>
        <p class="form-description">Remplissez les informations pour créer un nouveau compte utilisateur</p>
    </div>

    <div class="form-card">
        <form action="{{ route('users.store') }}" method="POST" class="user-form">
            @csrf

            <!-- Section Informations de base -->
            <div class="form-section">
                <div class="section-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h2>Informations personnelles</h2>
                </div>

                <div class="form-group">
                    <label for="name">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 极-8 0 4 4 0 018 0zM12 14a7 7极 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Nom complet
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" required>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap极round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Adresse email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Section Sécurité -->
            <div class="form-section">
                <div class="section-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2极-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h2>Sécurité</h2>
                </div>

                <div class="form-group">
                    <label for="password">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8极" />
                        </svg>
                        Mot de passe
                    </label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" class="form-input" required>
                        <button type="button" class="toggle-password" aria-label="Afficher le mot de passe">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Confirmer le mot de passe
                    </label>
                    <div class="password-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                        <button type="button" class="toggle-password" aria-label="Afficher le mot de passe">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="极 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Section Rôles -->
            <div class="form-section">
                <div class="section-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 极.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.极-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 极 3 3 0 016 0z" />
                    </svg>
                    <h2>Permissions</h2>
                </div>

                <div class="form-group roles-group">
                    <label class="roles-label">Rôle attribué</label>
                    <div class="roles-options">
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
                                'chef_service' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1极5m-4 0h4" />',
                                'secretaire_executif' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
                                'Consultant' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
                                'chef_division' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />',
                                'dsi' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.极-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />',
                                'Directeur' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />'
                            ];
                        @endphp

                        @foreach($roles as $roleValue => $roleLabel)
                        <label class="role-option">
                            <input type="radio" name="role" value="{{ $roleValue }}" {{ old('role') == $roleValue ? 'checked' : '' }} class="role-input" required>
                            <div class="role-card">
                                <div class="role-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        {!! $icons[$roleValue] !!}
                                    </svg>
                                </div>
                                <div class="role-details">
                                    <span class="role-title">{{ $roleLabel }}</span>
                                    <span class="role-description">
                                        {{ $descriptions[$roleValue] }}
                                    </span>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('role')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Actions du formulaire -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16极8-8H4" />
                    </svg>
                    Créer l'utilisateur
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Variables CSS alignées avec la charte graphique */
    :root {
        /* Couleurs principales */
        --primary: #1A5F23; /* Vert foncé */
        --secondary: #F9A825; /* Jaune doré */
        --accent: #E30613; /* Rouge béninois */
        --neutral: #F5F5F5; /* Gris clair */
        --black: #333333; /* Noir */
        --white: #FFFFFF; /* Blanc */
        --blue: #0A66C2; /* Bleu institutionnel */
        --success: #4CAF50; /* Vert clair */

        /* Ombres */
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);

        /* Rayons */
        --radius-sm: 0.25rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-full: 9999px;

        /* Transitions */
        --transition-colors: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    /* Styles de base */
    body {
        font-family: 'Roboto', Arial, sans-serif;
        color: var(--black);
        line-height: 1.5;
    }

    /* Conteneur principal */
    .user-form-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* En-tête du formulaire */
    .form-header {
        margin-bottom: 2rem;
    }

    .form-title {
        font-weight: 700;
        font-size: 2rem;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0 极 0.5rem 0;
    }

    .form-title svg {
        width: 2rem;
        height: 2rem;
        stroke-width: 1.5;
        color: var(--secondary); /* Jaune doré pour icônes */
    }

    .form-description {
        color: var(--black);
        font-size: 1.125rem;
        margin: 0;
    }

    /* Carte du formulaire */
    .form-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 2.5rem;
    }

    /* Formulaire */
    .user-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    /* Sections du formulaire */
    .form-section {
        grid-column: span 1;
    }

    .section-header {
        grid-column: 1 / -1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 1.5rem 0 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--neutral);
    }

    .section-header h2 {
        font-weight: 600;
        font-size: 1.25rem;
        color: var(--primary);
        margin: 0;
    }

    .section-header svg {
        width: 1.5rem;
        height: 1.5rem;
        color: var(--secondary);
    }

    /* Groupes de champs */
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
        font-size: 0.9375rem;
    }

    .form-group label svg {
        width: 1.25rem;
        height: 1.25rem;
        stroke-width: 1.75;
        color: var(--secondary);
    }

    /* Champs de formulaire */
    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--neutral);
        border-radius: var(--radius-md);
        font-size: 0.9375rem;
        font-family: inherit;
        transition: var(--极-colors);
        background-color: var(--white);
        color: var(--black);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26, 95, 35, 0.15); /* Ombre verte */
        background-color: var(--white);
    }

    /* Champ mot de passe */
    .password-wrapper {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--blue); /* Bleu institutionnel */
        cursor: pointer;
        padding: 0.25rem;
    }

    .toggle-password svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .toggle-password:hover {
        color: var(--success); /* Vert clair au survol */
    }

    /* Rôles */
    .roles-group {
        grid-column: 1 / -1;
    }

    .roles-label {
        display: block;
        margin-bottom: 1rem;
        font-weight: 500;
        color: var(--black);
    }

    .roles-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .role-option {
        display: block;
    }

    .role-input {
        position: absolute;
        opacity: 0;
    }

    .role-input:checked + .role-card {
        border-color: var(--primary);
        background-color: var(--neutral);
    }

    .role-input:focus + .role-card {
        box-shadow: 0 0 0 3px rgba(26, 95, 35, 0.15);
    }

    .role-card {
        padding: 1rem;
        border: 1px solid var(--neutral);
        border-radius: var(--radius-md);
        transition: var(--transition-colors);
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

    .role-details {
        flex: 1;
    }

    .role-title {
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

    /* Actions du formulaire */
    .form-actions {
        grid-column: 1 / -1;
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--neutral);
    }

    /* Boutons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 500;
        font-size: 1rem;
        line-height: 1.5;
        cursor: pointer;
        transition: var(--transition-colors);
        text-decoration: none;
        border: none;
    }

    .btn-primary {
        background-color: var(--primary);
        color: var(--white);
    }

    .btn-primary:hover {
        background-color: var(--success); /* Vert clair au survol */
    }

    .btn-secondary {
        background-color: var(--secondary);
        color: var(--black);
    }

    .btn-secondary:hover {
        background-color: #FCD116; /* Jaune clair au survol */
    }

    .btn svg {
        width: 1.25rem;
        height: 1.25rem;
        color: var(--white); /* Blanc pour contraste dans les boutons */
    }

    .btn-secondary svg {
        color: var(--black); /* Noir pour contraste dans le bouton secondaire */
    }

    /* Messages d'erreur */
    .error-message {
        color: var(--accent); /* Rouge pour erreurs */
        font-size: 0.8125rem;
        margin-top: 0.5rem;
        display: block;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .user-form-container {
            padding: 1.5rem 1rem;
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

        .roles-options {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    // Toggle visibilité mot de passe
    document.addEventListener('DOMContentLoaded', () => {
        const passwordToggles = document.querySelectorAll('.toggle-password');

        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                const input = e.currentTarget.closest('.password-wrapper').querySelector('input');
                const icon = e.currentTarget.querySelector('svg');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
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
