@extends('layouts.app')
@section('title', 'Changer le mot de passe')
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Sécurité du Compte</span>
                </div>
                <h1 class="form-title">
                    Changer le mot de passe
                </h1>
                <p class="form-description">Mettez à jour votre mot de passe pour renforcer la sécurité de votre compte</p>
            </div>

            <!-- Indicateurs de sécurité -->
            <div class="security-indicators">
                <div class="indicator-item">
                    <div class="indicator-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span>Protection avancée</span>
                </div>
                <div class="indicator-item">
                    <div class="indicator-icon">
                        <!-- Icône de cadenas (correcte pour SSL) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <span>Chiffrement SSL</span> <!-- Le texte reste -->
                </div>
            </div>
        </div>
    </div>

    <!-- Carte principale premium -->
    <div class="form-card" data-aos="fade-up" data-aos-delay="150">
        <form action="{{ route('password.update') }}" method="POST" class="user-form" id="passwordForm">
            @csrf

            <!-- Indicateur de progression -->
            <div class="form-progress" data-aos="fade-right" data-aos-delay="200">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 0%"></div>
                </div>
                <div class="progress-steps">
                    <span class="step active">1</span>
                    <span class="step">2</span>
                    <span class="step">3</span>
                </div>
            </div>

            <!-- Section Sécurité premium -->
            <div class="form-section" data-aos="fade-up" data-aos-delay="250">
                <div class="section-header">
                    <div class="section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div class="section-content">
                        <h2>Sécurité du Mot de Passe</h2>
                        <p>Créez un mot de passe robuste pour protéger votre compte</p>
                    </div>
                </div>

                <div class="form-grid">
                    <!-- Mot de passe actuel -->
                    <div class="form-group" data-aos="fade-right" data-aos-delay="300">
                        <label for="current_password">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Mot de passe actuel
                        </label>
                        <div class="password-wrapper">
                            <input type="password" id="current_password" name="current_password" class="form-input" required>
                            <button type="button" class="toggle-password" aria-label="Afficher le mot de passe actuel">
                                <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="eye-off-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nouveau mot de passe -->
                    <div class="form-group" data-aos="fade-left" data-aos-delay="350">
                        <label for="password">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Nouveau mot de passe
                        </label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" class="form-input" required>
                            <button type="button" class="toggle-password" aria-label="Afficher le nouveau mot de passe">
                                <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="eye-off-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <!-- Indicateur de force du mot de passe -->
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div class="strength-fill" data-strength="0"></div>
                            </div>
                            <div class="strength-label">Faible</div>
                        </div>
                        <div class="password-requirements">
                            <span class="requirement" data-requirement="length">• 8 caractères minimum</span>
                            <span class="requirement" data-requirement="uppercase">• Une lettre majuscule</span>
                            <span class="requirement" data-requirement="number">• Un chiffre</span>
                            <span class="requirement" data-requirement="special">• Un caractère spécial</span>
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div class="form-group" data-aos="fade-right" data-aos-delay="400">
                        <label for="password_confirmation">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Confirmer le mot de passe
                        </label>
                        <div class="password-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                            <button type="button" class="toggle-password" aria-label="Afficher la confirmation du mot de passe">
                                <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="eye-off-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <div class="confirmation-status">
                            <span class="status-icon"></span>
                            <span class="status-text">Les mots de passe doivent correspondre</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions du formulaire premium -->
            <div class="form-actions" data-aos="fade-up" data-aos-delay="450">
                <button type="submit" class="btn btn-primary action-btn" id="submitBtn" disabled>
                    <span class="btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                    <span class="btn-text">Mettre à jour la sécurité</span>
                    <span class="btn-glow"></span>
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary action-btn">
                    <span class="btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </span>
                    <span class="btn-text">Retour à l'accueil</span>
                    <span class="btn-glow"></span>
                </a>
            </div>
        </form>
    </div>

    <!-- Section d'informations de sécurité -->
    <div class="security-tips" data-aos="fade-up" data-aos-delay="500">
        <h3>Conseils de Sécurité</h3>
        <div class="tips-grid">
            <div class="tip-card">
                <div class="tip-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h4>Longueur minimale</h4>
                <p>Utilisez au moins 8 caractères pour une sécurité optimale</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <h4>Diversité des caractères</h4>
                <p>Combinez lettres, chiffres et caractères spéciaux</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h4>Unicité</h4>
                <p>N'utilisez pas le même mot de passe sur plusieurs sites</p>
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
        --warning: #FF9800; /* Orange */
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

    /* Indicateurs de sécurité */
    .security-indicators {
        display: flex;
        gap: 1.5rem;
    }

    .indicator-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .indicator-icon {
        width: 3rem;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .indicator-icon svg {
        width: 1.5rem;
        height: 1.5rem;
        color: var(--secondary);
    }

    .indicator-item span {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
        text-align: center;
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
    }

    /* Barre de progression */
    .form-progress {
        margin-bottom: 2.5rem;
    }

    .progress-bar {
        height: 6px;
        background: var(--neutral);
        border-radius: var(--radius-full);
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .progress-fill {
        height: 100%;
        background: var(--primary);
        border-radius: var(--radius-full);
        transition: width 0.5s ease;
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .progress-steps::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--neutral);
        transform: translateY(-50%);
        z-index: 1;
    }

    .step {
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--white);
        border: 2px solid var(--neutral);
        font-weight: 600;
        font-size: 0.875rem;
        position: relative;
        z-index: 2;
        transition: var(--transition);
    }

    .step.active {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--white);
    }

    /* Formulaire */
    .user-form {
        display: grid;
        gap: 2rem;
    }

    /* Section du formulaire */
    .form-section {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        border: 1px solid var(--neutral);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--neutral);
    }

    .section-icon {
        width: 3rem;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-md);
        background: var(--neutral);
        color: var(--primary);
    }

    .section-icon svg {
        width: 1.5rem;
        height: 1.5rem;
    }

    .section-content h2 {
        font-weight: 600;
        font-size: 1.5rem;
        color: var(--black);
        margin: 0 0 0.5rem 0;
    }

    .section-content p {
        color: var(--black);
        margin: 0;
    }

    /* Grille de formulaire */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    /* Groupes de champs améliorés */
    .form-group {
        position: relative;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        font-weight: 600;
        color: var(--black);
        font-size: 0.9375rem;
    }

    .form-group label svg {
        width: 1.25rem;
        height: 1.25rem;
        stroke-width: 1.75;
        color: var(--secondary);
    }

    /* Champs de formulaire premium */
    .form-input {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid var(--neutral);
        border-radius: var(--radius-md);
        font-size: 1rem;
        font-family: inherit;
        transition: var(--transition);
        background-color: var(--white);
        color: var(--black);
        box-shadow: var(--shadow-sm);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26, 95, 35, 0.15);
        transform: translateY(-2px);
    }

    .form-input.error {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(227, 6, 19, 0.15);
    }

    .form-input.success {
        border-color: var(--success);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
    }

    /* Champ mot de passe amélioré */
    .password-wrapper {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--blue);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: var(--radius-sm);
        transition: var(--transition);
    }

    .toggle-password:hover {
        background: var(--neutral);
        color: var(--primary);
    }

    .toggle-password svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    /* Indicateur de force du mot de passe */
    .password-strength {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.75rem;
    }

    .strength-bar {
        flex: 1;
        height: 6px;
        background: var(--neutral);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .strength-fill {
        height: 100%;
        border-radius: var(--radius-full);
        transition: all 0.5s ease;
        width: 0%;
    }

    .strength-fill[data-strength="1"] {
        background: var(--accent);
        width: 25%;
    }

    .strength-fill[data-strength="2"] {
        background: var(--warning);
        width: 50%;
    }

    .strength-fill[data-strength="3"] {
        background: var(--secondary);
        width: 75%;
    }

    .strength-fill[data-strength="4"] {
        background: var(--success);
        width: 100%;
    }

    .strength-label {
        font-size: 0.875rem;
        font-weight: 600;
        min-width: 60px;
        text-align: right;
    }

    /* Exigences du mot de passe */
    .password-requirements {
        display: grid;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .requirement {
        font-size: 0.75rem;
        color: var(--black);
        transition: var(--transition);
    }

    .requirement.met {
        color: var(--success);
    }

    .requirement.met::before {
        content: '✓ ';
        font-weight: bold;
    }

    /* Statut de confirmation */
    .confirmation-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.75rem;
        font-size: 0.875rem;
    }

    .status-icon {
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: var(--neutral);
        transition: var(--transition);
    }

    .confirmation-status.matching .status-icon {
        background: var(--success);
    }

    .confirmation-status.matching .status-text {
        color: var(--success);
    }

    .confirmation-status.mismatching .status-icon {
        background: var(--accent);
    }

    .confirmation-status.mismatching .status-text {
        color: var(--accent);
    }

    /* Messages d'erreur améliorés */
    .error-message {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--accent);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        padding: 0.5rem;
        background: rgba(227, 6, 19, 0.05);
        border-radius: var(--radius-sm);
        border-left: 3px solid var(--accent);
    }

    .error-message::before {
        content: '!';
        width: 1.25rem;
        height: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--accent);
        color: var(--white);
        border-radius: 50%;
        font-weight: bold;
        font-size: 0.75rem;
    }

    /* Actions du formulaire premium */
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

    .btn-primary:disabled {
        background-color: var(--neutral);
        color: var(--black);
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-primary:disabled:hover {
        background-color: var(--neutral);
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

    /* Section des conseils de sécurité */
    .security-tips {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        padding: 2.5rem;
        margin-bottom: 2rem;
    }

    .security-tips h3 {
        font-weight: 600;
        font-size: 1.5rem;
        color: var(--black);
        margin-bottom: 2rem;
        text-align: center;
    }

    .tips-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .tip-card {
        text-align: center;
        padding: 1.5rem;
        background: var(--neutral);
        border-radius: var(--radius-lg);
        transition: var(--transition);
    }

    .tip-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .tip-icon {
        width: 3rem;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        margin: 0 auto 1rem;
    }

    .tip-icon svg {
        width: 1.5rem;
        height: 1.5rem;
    }

    .tip-card h4 {
        font-weight: 600;
        color: var(--black);
        margin-bottom: 0.5rem;
    }

    .tip-card p {
        color: var(--black);
        font-size: 0.875rem;
        margin: 0;
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

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* Responsive */
    @media (max-width: 968px) {
        .user-form-container {
            padding: 1.5rem;
        }

        .header-content {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 1.5rem;
        }

        .security-indicators {
            justify-content: center;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .tips-grid {
            grid-template-columns: 1fr;
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

        .form-card {
            padding: 2rem 1.5rem;
        }

        .security-tips {
            padding: 2rem 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .form-title {
            font-size: 1.75rem;
        }

        .security-indicators {
            flex-direction: column;
            gap: 1rem;
        }

        .action-btn {
            padding: 0.875rem 1.5rem;
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
                number: { value: 25, density: { enable: true, value_area: 800 } },
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

        // Toggle visibilité mot de passe
        const passwordToggles = document.querySelectorAll('.toggle-password');

        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                const wrapper = e.currentTarget.closest('.password-wrapper');
                const input = wrapper.querySelector('input');
                const eyeIcon = wrapper.querySelector('.eye-icon');
                const eyeOffIcon = wrapper.querySelector('.eye-off-icon');

                if (input.type === 'password') {
                    input.type = 'text';
                    eyeIcon.style.display = 'none';
                    eyeOffIcon.style.display = 'block';
                } else {
                    input.type = 'password';
                    eyeIcon.style.display = 'block';
                    eyeOffIcon.style.display = 'none';
                }
            });
        });

        // Vérification de la force du mot de passe
        const passwordInput = document.getElementById('password');
        const strengthFill = document.querySelector('.strength-fill');
        const strengthLabel = document.querySelector('.strength-label');
        const requirements = document.querySelectorAll('.requirement');
        const confirmInput = document.getElementById('password_confirmation');
        const confirmStatus = document.querySelector('.confirmation-status');
        const submitBtn = document.getElementById('submitBtn');

        function checkPasswordStrength(password) {
            let strength = 0;

            // Longueur minimale
            const lengthMet = password.length >= 8;
            requirements[0].classList.toggle('met', lengthMet);
            if (lengthMet) strength++;

            // Lettre majuscule
            const uppercaseMet = /[A-Z]/.test(password);
            requirements[1].classList.toggle('met', uppercaseMet);
            if (uppercaseMet) strength++;

            // Chiffre
            const numberMet = /[0-9]/.test(password);
            requirements[2].classList.toggle('met', numberMet);
            if (numberMet) strength++;

            // Caractère spécial
            const specialMet = /[^A-Za-z0-9]/.test(password);
            requirements[3].classList.toggle('met', specialMet);
            if (specialMet) strength++;

            // Mise à jour de l'affichage
            strengthFill.setAttribute('data-strength', strength);

            const labels = ['Faible', 'Moyen', 'Fort', 'Très fort'];
            strengthLabel.textContent = labels[strength - 1] || 'Faible';

            return strength;
        }

        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmInput.value;

            if (confirmPassword.length === 0) {
                confirmStatus.className = 'confirmation-status';
                confirmStatus.querySelector('.status-text').textContent = 'Les mots de passe doivent correspondre';
            } else if (password === confirmPassword) {
                confirmStatus.className = 'confirmation-status matching';
                confirmStatus.querySelector('.status-text').textContent = 'Les mots de passe correspondent';
            } else {
                confirmStatus.className = 'confirmation-status mismatching';
                confirmStatus.querySelector('.status-text').textContent = 'Les mots de passe ne correspondent pas';
            }
        }

        function validateForm() {
            const currentPassword = document.getElementById('current_password').value;
            const password = passwordInput.value;
            const confirmPassword = confirmInput.value;
            const strength = checkPasswordStrength(password);

            const isCurrentPasswordValid = currentPassword.length > 0;
            const isPasswordStrong = strength >= 3;
            const isPasswordMatch = password === confirmPassword && confirmPassword.length > 0;

            submitBtn.disabled = !(isCurrentPasswordValid && isPasswordStrong && isPasswordMatch);

            // Mise à jour de la barre de progression
            const progressFill = document.querySelector('.progress-fill');
            const steps = document.querySelectorAll('.step');

            let progress = 0;
            if (isCurrentPasswordValid) progress += 33;
            if (isPasswordStrong) progress += 33;
            if (isPasswordMatch) progress += 34;

            progressFill.style.width = progress + '%';

            // Mise à jour des étapes
            steps[0].classList.toggle('active', isCurrentPasswordValid);
            steps[1].classList.toggle('active', isPasswordStrong);
            steps[2].classList.toggle('active', isPasswordMatch);
        }

        // Événements de saisie
        document.getElementById('current_password').addEventListener('input', validateForm);
        passwordInput.addEventListener('input', function() {
            checkPasswordStrength(this.value);
            checkPasswordMatch();
            validateForm();
        });
        confirmInput.addEventListener('input', function() {
            checkPasswordMatch();
            validateForm();
        });

        // Focus sur le premier champ en erreur
        const firstError = document.querySelector('.error-message');
        if (firstError) {
            const input = firstError.closest('.form-group').querySelector('input');
            input?.focus();

            // Animation d'erreur
            input.classList.add('error');
            input.addEventListener('animationend', () => {
                input.classList.remove('error');
            });
        }

        // Validation initiale
        validateForm();
    });
</script>
@endsection
