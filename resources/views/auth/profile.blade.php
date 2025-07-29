@extends('layouts.app')
@section('title', 'Profil')
@section('content')
<div class="user-form-container">
    <!-- En-tête -->
    <div class="form-header">
        <div class="header-background">
            <div class="bg-shape-1"></div>
            <div class="bg-shape-2"></div>
        </div>
        <div class="header-content">
            <h1 class="form-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Votre Profil
            </h1>
            <p class="form-description">Consultez et gérez les informations de votre compte</p>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="form-card">
        <div class="profile-content">
            <!-- Avatar et informations principales -->
            <div class="profile-header">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="profile-details">
                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <span class="role-badge">{{ $user->getRoleNames()->first() }}</span>
                </div>
            </div>

            <!-- Informations détaillées -->
            <div class="profile-info">
                <div class="info-item">
                    <div class="info-label">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Email
                    </div>
                    <div class="info-value">{{ $user->email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Date de création
                    </div>
                    <div class="info-value">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                @can('manage-users')
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Suivant
                </a>
                @endcan
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>
        </div>
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

    /* En-tête */
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

    /* Carte principale */
    .form-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 2.5rem;
        max-width: 600px;
        margin: 0 auto;
        animation: fadeIn 0.5s ease-in;
    }

    /* Contenu du profil */
    .profile-content {
        display: grid;
        gap: 2rem;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--neutral);
    }

    .user-avatar {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .profile-details {
        flex: 1;
    }

    .profile-name {
        font-weight: 600;
        font-size: 1.5rem;
        color: var(--black);
        margin: 0;
    }

    .role-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-full);
        background: var(--secondary);
        color: var(--black);
        font-size: 0.75rem;
        font-weight: 500;
        margin-top: 0.25rem;
    }

    /* Informations */
    .profile-info {
        display: grid;
        gap: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        padding: 1rem;
        background: var(--neutral);
        border-radius: var(--radius-md);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        color: var(--primary);
        font-size: 0.9375rem;
    }

    .info-label svg {
        width: 1.25rem;
        height: 1.25rem;
        stroke-width: 1.75;
        color: var(--secondary);
    }

    .info-value {
        color: var(--black);
        font-size: 1rem;
    }

    /* Actions */
    .form-actions {
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
        transition: var(--transition-colors), transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
        border: none;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
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

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
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

        .form-title svg {
            width: 1.75rem;
            height: 1.75rem;
        }

        .form-description {
            font-size: 1rem;
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

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 1.25rem;
        }

        .profile-name {
            font-size: 1.25rem;
        }

        .info-item {
            padding: 0.75rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Animation au survol des boutons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-2px)';
                button.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            });
            button.addEventListener('mouseleave', () => {
                button.style.transform = '';
                button.style.boxShadow = '';
            });
        });

        // Animation progressive des infos
        const infoItems = document.querySelectorAll('.info-item');
        infoItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
            item.classList.add('fade-in');
        });
    });
</script>
@endsection
