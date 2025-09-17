@extends('layouts.app')
@section('title', 'Profil')
@section('content')

<!-- Intégration des scripts pour les effets avancés -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

<div class="user-form-container">
    <!-- Particules background -->
    <div id="particles-js"></div>

    <!-- En-tête premium -->
    <div class="form-header" data-aos="fade-down">
        <div class="header-background">
            <div class="bg-shape-1"></div>
            <div class="bg-shape-2"></div>
            <div class="bg-shape-3"></div>
        </div>
        <div class="header-content">
            <div class="title-wrapper">
                <div class="title-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Profil Utilisateur</span>
                </div>
                <h1 class="form-title">
                    Votre Profil
                </h1>
                <p class="form-description">Consultez et gérez les informations de votre compte</p>
            </div>

            <!-- Indicateurs rapides -->
            <div class="profile-quick-stats">
                <div class="quick-stat">
                    <span class="quick-stat-value">{{ $user->created_at->diffForHumans() }}</span>
                    <span class="quick-stat-label">Membre depuis</span>
                </div>
                <div class="quick-stat">
                    <span class="quick-stat-value">{{ $user->getRoleNames()->first() }}</span>
                    <span class="quick-stat-label">Rôle</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Carte principale premium -->
    <div class="form-card" data-aos="fade-up" data-aos-delay="150">
        <div class="profile-content">
            <!-- Avatar et informations principales avec effet 3D -->
            <div class="profile-header">
                <div class="avatar-container">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                        <div class="avatar-status online"></div>
                    </div>
                    <div class="avatar-halo"></div>
                </div>
                <div class="profile-details">
                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <span class="role-badge">{{ $user->getRoleNames()->first() }}</span>
                    <div class="profile-meta">
                        <span class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Inscrit le {{ $user->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Informations détaillées avec cartes interactives -->
            <div class="profile-info-grid">
                <div class="info-card" data-aos="fade-right" data-aos-delay="200">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3>Informations Personnelles</h3>
                    </div>
                    <div class="card-content">
                        <div class="info-item">
                            <div class="info-label">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Adresse Email
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
                            <div class="info-value">{{ $user->created_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    </div>
                </div>

                <div class="info-card" data-aos="fade-left" data-aos-delay="250">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3>Statistiques du Compte</h3>
                    </div>
                    <div class="card-content">
                        <div class="stat-item">
                            <div class="stat-value">{{ $user->created_at->diffInDays(now()) }}</div>
                            <div class="stat-label">Jours d'activité</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $user->getRoleNames()->first() }}</div>
                            <div class="stat-label">Niveau d'accès</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions premium -->
            <div class="form-actions" data-aos="fade-up" data-aos-delay="300">
                @can('manage-users')
                <a href="{{ route('dashboard') }}" class="btn btn-primary action-btn">
                    <span class="btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </span>
                    <span class="btn-text">Tableau de Bord Admin</span>
                    <span class="btn-glow"></span>
                </a>
                @endcan
                <a href="{{ route('dashboard') }}" class="btn btn-secondary action-btn">
                    <span class="btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </span>
                    <span class="btn-text">Retour à l'Accueil</span>
                    <span class="btn-glow"></span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Variables CSS alignées avec la charte graphique existante */
    :root {
        --primary: #1A5F23; /* Vert foncé */
        --secondary: #F9A825; /* Jaune doré */
        --accent: #E30613; /* Rouge béninois */
        --neutral: #F5F5F5; /* Gris clair */
        --black: #333333; /* Noir */
        --white: #FFFFFF; /* Blanc */
        --blue: #0A66C2; /* Bleu institutionnel */
        --success: #4CAF50; /* Vert clair */
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.16);
        --shadow-xl: 0 12px 40px rgba(0, 0, 0, 0.2);
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        --radius-full: 9999px;
        --transition: all 0.3s ease;
        --transition-slow: all 0.5s ease;
        --gradient-primary: linear-gradient(135deg, var(--primary) 0%, #2c7744 100%);
    }

    /* Styles globaux améliorés */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto', Arial, sans-serif;
        background-color: var(--neutral);
        color: var(--black);
        line-height: 1.6;
        overflow-x: hidden;
    }

    svg {
        width: 1.25rem;
        height: 1.25rem;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* Conteneur principal premium */
    .user-form-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
    }

    /* Particules background */
    #particles-js {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none;
    }

    /* En-tête premium */
    .form-header {
        position: relative;
        margin-bottom: 2.5rem;
        padding: 3rem 2.5rem;
        border-radius: var(--radius-xl);
        background: var(--gradient-primary);
        box-shadow: var(--shadow-xl);
        overflow: hidden;
        z-index: 1;
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
        background: radial-gradient(circle, rgba(249, 168, 37, 0.3) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }

    .bg-shape-2 {
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(249, 168, 37, 0.2) 0%, transparent 70%);
        animation: float 8s ease-in-out infinite reverse;
    }

    .bg-shape-3 {
        position: absolute;
        top: 50%;
        right: 20%;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite alternate;
    }

    .header-content {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 2rem;
        align-items: center;
    }

    .title-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-full);
        background: rgba(255, 255, 255, 0.2);
        color: var(--white);
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        backdrop-filter: blur(10px);
    }

    .title-badge svg {
        width: 1rem;
        height: 1rem;
        color: var(--secondary);
    }

    .form-title {
        font-weight: 700;
        font-size: 2.5rem;
        color: var(--white);
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .form-description {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.25rem;
        margin: 0;
    }

    /* Quick stats */
    .profile-quick-stats {
        display: flex;
        gap: 1.5rem;
    }

    .quick-stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        backdrop-filter: blur(10px);
        min-width: 120px;
    }

    .quick-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--white);
    }

    .quick-stat-label {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Carte principale premium */
    .form-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        padding: 3rem;
        margin: 0 auto 2.5rem;
        position: relative;
        z-index: 1;
        animation: slideUp 0.6s ease-out;
    }

    /* Contenu du profil amélioré */
    .profile-content {
        display: grid;
        gap: 2.5rem;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--neutral);
    }

    .avatar-container {
        position: relative;
    }

    .user-avatar {
        width: 5rem;
        height: 5rem;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 2rem;
        position: relative;
        z-index: 2;
        transition: var(--transition);
        box-shadow: var(--shadow-md);
    }

    .avatar-halo {
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(26, 95, 35, 0.2) 0%, transparent 70%);
        animation: pulse 2s ease-in-out infinite;
        z-index: 1;
    }

    .avatar-status {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: var(--success);
        border: 2px solid var(--white);
        z-index: 3;
    }

    .profile-details {
        flex: 1;
    }

    .profile-name {
        font-weight: 700;
        font-size: 2rem;
        color: var(--black);
        margin: 0 0 0.5rem 0;
    }

    .role-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-full);
        background: var(--secondary);
        color: var(--black);
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .profile-meta {
        display: flex;
        gap: 1rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--black);
    }

    .meta-item svg {
        width: 1rem;
        height: 1rem;
        color: var(--secondary);
    }

    /* Grille d'informations */
    .profile-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .info-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 1.5rem;
        transition: var(--transition);
        border: 1px solid var(--neutral);
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--neutral);
    }

    .card-icon {
        width: 3rem;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-md);
        background: var(--neutral);
        color: var(--primary);
    }

    .card-icon svg {
        width: 1.5rem;
        height: 1.5rem;
    }

    .card-header h3 {
        font-weight: 600;
        font-size: 1.25rem;
        color: var(--black);
        margin: 0;
    }

    .card-content {
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
        transition: var(--transition);
    }

    .info-item:hover {
        transform: translateX(5px);
        background: rgba(26, 95, 35, 0.05);
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
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
        font-size: 1.1rem;
        font-weight: 500;
    }

    /* Statistiques */
    .stat-item {
        text-align: center;
        padding: 1rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--black);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Actions premium */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--neutral);
    }

    /* Boutons premium */
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .action-btn:hover {
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

    .btn-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon svg {
        width: 1.25rem;
        height: 1.25rem;
        color: var(--white);
    }

    .btn-secondary .btn-icon svg {
        color: var(--black);
    }

    .btn-glow {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: var(--transition-slow);
    }

    .action-btn:hover .btn-glow {
        left: 100%;
    }

    /* Section des préférences */
    .preferences-section {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .preferences-section h3 {
        font-weight: 600;
        font-size: 1.5rem;
        color: var(--black);
        margin-bottom: 1.5rem;
    }

    .preferences-grid {
        display: grid;
        gap: 1rem;
    }

    .preference-item {
        display: flex;
        align-items: center;
        justify-content: between;
        padding: 1rem;
        background: var(--neutral);
        border-radius: var(--radius-md);
        transition: var(--transition);
    }

    .preference-item:hover {
        background: rgba(26, 95, 35, 0.05);
    }

    .preference-toggle {
        display: flex;
        align-items: center;
        gap: 1rem;
        width: 100%;
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: var(--primary);
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .preference-info {
        flex: 1;
    }

    .preference-label {
        display: block;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 0.25rem;
    }

    .preference-description {
        font-size: 0.875rem;
        color: var(--black);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(50px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.5; }
        100% { transform: scale(1.1); opacity: 0.8; }
    }

    /* Responsive */
    @media (max-width: 968px) {
        .user-form-container {
            padding: 1.5rem;
        }

        .header-content {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .profile-quick-stats {
            justify-content: center;
        }

        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .profile-meta {
            justify-content: center;
        }

        .profile-info-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }
    }

    @media (max-width: 640px) {
        .form-header {
            padding: 2rem 1.5rem;
        }

        .form-title {
            font-size: 2rem;
        }

        .form-description {
            font-size: 1.125rem;
        }

        .quick-stat {
            padding: 0.75rem 1rem;
            min-width: 100px;
        }

        .quick-stat-value {
            font-size: 1.25rem;
        }

        .form-card {
            padding: 2rem 1.5rem;
        }

        .user-avatar {
            width: 4rem;
            height: 4rem;
            font-size: 1.75rem;
        }

        .profile-name {
            font-size: 1.75rem;
        }
    }

    @media (max-width: 480px) {
        .form-title {
            font-size: 1.75rem;
        }

        .user-avatar {
            width: 3.5rem;
            height: 3.5rem;
            font-size: 1.5rem;
        }

        .profile-name {
            font-size: 1.5rem;
        }

        .info-card {
            padding: 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-quart',
            once: true,
            offset: 50
        });

        // Initialiser les particules
        particlesJS('particles-js', {
            particles: {
                number: { value: 30, density: { enable: true, value_area: 800 } },
                color: { value: "#1A5F23" },
                shape: { type: "circle" },
                opacity: { value: 0.1, random: true },
                size: { value: 3, random: true },
                line_linked: { enable: false },
                move: { enable: true, speed: 1, direction: "none", random: true, out_mode: "out" }
            },
            interactivity: {
                detect_on: "canvas",
                events: { onhover: { enable: true, mode: "grab" }, onclick: { enable: true, mode: "push" } },
                modes: { grab: { distance: 140, line_linked: { opacity: 0.2 } }, push: { particles_nb: 4 } }
            }
        });

        // Animation des cartes au survol
        const infoCards = document.querySelectorAll('.info-card');
        infoCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = 'var(--shadow-lg)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = 'var(--shadow-md)';
            });
        });

        // Animation des éléments d'information
        const infoItems = document.querySelectorAll('.info-item');
        infoItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
            item.classList.add('fade-in');
        });

        // Gestion des toggle switches
        const toggleSwitches = document.querySelectorAll('.toggle-switch input');
        toggleSwitches.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const label = this.nextElementSibling;
                if (this.checked) {
                    label.style.boxShadow = '0 0 10px rgba(26, 95, 35, 0.5)';
                } else {
                    label.style.boxShadow = '';
                }
            });
        });

        // Effet de halo autour de l'avatar
        const avatar = document.querySelector('.user-avatar');
        setInterval(() => {
            const halo = document.querySelector('.avatar-halo');
            halo.style.animation = 'none';
            setTimeout(() => {
                halo.style.animation = 'pulse 2s ease-in-out infinite';
            }, 10);
        }, 4000);
    });
</script>
@endsection
