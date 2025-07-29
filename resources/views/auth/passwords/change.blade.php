@extends('layouts.app')
@section('title', 'Changer le mot de passe')
@section('content')
<div class="user-form-container">
    <div class="form-header">
        <div class="header-background">
            <div class="bg-shape-1"></div>
            <div class="bg-shape-2"></div>
        </div>
        <div class="header-content">
            <h1 class="form-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Changer le mot de passe
            </h1>
            <p class="form-description">Mettez à jour votre mot de passe pour sécuriser votre compte</p>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('password.update') }}" method="POST" class="user-form">
            @csrf

            <!-- Section Sécurité -->
            <div class="form-section">
                <div class="section-header">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h2>Sécurité</h2>
                </div>

                <div class="form-group">
                    <label for="current_password">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Mot de passe actuel
                    </label>
                    <div class="password-wrapper">
                        <input type="password" id="current_password" name="current_password" class="form-input" required>
                        <button type="button" class="toggle-password" aria-label="Afficher le mot de passe actuel">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Nouveau mot de passe
                    </label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" class="form-input" required>
                        <button type="button" class="toggle-password" aria-label="Afficher le nouveau mot de passe">
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
                        <button type="button" class="toggle-password" aria-label="Afficher la confirmation du mot de passe">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Actions du formulaire -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Mettre à jour
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
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
        --primary: #1A5F23; /* Vert foncé */
        --secondary: #F9A825; /* Jaune doré */
        --accent: #E30613; /* Rouge béninois */
        --neutral: #F5F5F5; /* Gris clair */
        --black: #333333; /* Noir */
        --white: #FFFFFF; /* Blanc */
        --blue: #0A66C2; /* Bleu institutionnel */
        --success: #4CAF50; /* Vert clair */
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --radius-sm: 0.25rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-full: 9999px;
        --transition-colors: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    /* Conteneur principal */
    .user-form-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* En-tête du formulaire */
    .form-header {
        position: relative;
        margin-bottom: 2rem;
        padding: 2rem;
        border-radius: var(--radius-lg);
        background: linear-gradient(135deg, var(--primary) 0%, var(--success) 100%);
        overflow: hidden;
    }

    .header-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    .bg-shape-1 {
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(249, 168, 37, 0.2) 0%, transparent 70%);
    }

    .bg-shape-2 {
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(249, 168, 37, 0.1) 0%, transparent 70%);
    }

    .header-content {
        position: relative;
        z-index: 1;
    }

    .form-title {
        font-weight: 700;
        font-size: 2rem;
        color: var(--white);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0 0 0.5rem 0;
    }

    .form-title svg {
        width: 2rem;
        height: 2rem;
        stroke-width: 1.5;
        color: var(--secondary);
    }

    .form-description {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.125rem;
        margin: 0;
    }

    /* Carte du formulaire */
    .form-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 2.5rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Formulaire */
    .user-form {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    /* Sections du formulaire */
    .form-section {
        grid-column: span 1;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
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
        transition: var(--transition-colors);
        background-color: var(--white);
        color: var(--black);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26, 95, 35, 0.15);
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
        color: var(--blue);
        cursor: pointer;
        padding: 0.25rem;
    }

    .toggle-password svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .toggle-password:hover {
        color: var(--success);
    }

    /* Messages d'erreur */
    .error-message {
        color: var(--accent);
        font-size: 0.8125rem;
        margin-top: 0.5rem;
        display: block;
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
        color: var(--white);
    }

    .btn-secondary svg {
        color: var(--black);
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

        .form-title svg {
            width: 1.5rem;
            height: 1.5rem;
        }

        .form-description {
            font-size: 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Toggle visibilité mot de passe
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
            const input = firstError.closest('.form-group').querySelector('input');
            input?.focus();
        }
    });
</script>
@endsection
