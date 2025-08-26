<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Reserves de la commune d' Abomey-Calavi | @yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
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
            --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1), 0 10px 10px rgba(0, 0, 0, 0.04);

            /* Rayons */
            --radius-sm: 0.25rem;
            --radius-md: 0.375rem;
            --radius-lg: 0.5rem;
            --radius-xl: 0.75rem;
            --radius-full: 9999px;

            /* Transitions */
            --transition-base: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-colors: color 0.15s, background-color 0.15s, border-color 0.15s, box-shadow 0.15s;
            --transition-transform: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: 1.5;
            color: var(--black);
            background-color: var(--neutral);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Layout principal */
        .app-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--primary) 0%, var(--success) 100%);
            color: var(--white);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 50;
            transition: var(--transition-base);
            transform: translateX(0);
            box-shadow: var(--shadow-lg);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--secondary) rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: var(--secondary);
            border-radius: var(--radius-full);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.1) 0%, transparent 100%);
        }

        .sidebar-title {
            font-family: 'Roboto', Arial, sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            line-height: 1.2;
            letter-spacing: -0.025em;
            color: var(--white);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-title svg {
            width: 1.75rem;
            height: 1.75rem;
            stroke-width: 1.5;
            color: var(--secondary);
        }

        .user-info {
            margin-top: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-md);
            color: var(--white);
            font-size: 0.875rem;
            position: relative;
        }

        .user-info-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.75rem;
            background: none;
            border: none;
            color: var(--white);
            cursor: pointer;
            text-align: left;
            font-family: 'Roboto', Arial, sans-serif;
            font-size: 0.875rem;
            border-radius: var(--radius-md);
            transition: var(--transition-colors);
        }

        .user-info-toggle:hover {
            background: rgba(76, 175, 80, 0.2);
        }

        .user-info-toggle:focus {
            outline: 2px solid var(--secondary);
            outline-offset: 2px;
        }

        .user-name {
            font-weight: 600;
            font-size: 1rem;
            flex: 1;
        }

        .user-role {
            font-weight: 400;
            color: var(--neutral);
            text-transform: capitalize;
        }

        .dropdown-icon {
            width: 1rem;
            height: 1rem;
            color: var(--secondary);
            transition: transform 0.2s ease;
        }

        .user-info-toggle[aria-expanded="true"] .dropdown-icon {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            z-index: 100;
            margin-top: 0.25rem;
            animation: fadeIn 0.3s ease-out;
        }

        .user-info-toggle[aria-expanded="true"] + .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--black);
            text-decoration: none;
            font-size: 0.875rem;
            transition: var(--transition-colors);
        }

        .dropdown-item:hover {
            background: var(--neutral);
        }

        .dropdown-item svg {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
            color: var(--primary);
        }

        .sidebar-nav {
            padding: 1rem 0;
            flex-grow: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            margin: 0 0.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: var(--radius-md);
            transition: var(--transition-colors);
        }

        .nav-item:hover {
            background: rgba(76, 175, 80, 0.2);
            color: var(--white);
        }

        .nav-item.active {
            background: var(--success);
            color: var(--white);
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(26, 95, 35, 0.2);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--secondary);
            border-radius: var(--radius-full);
        }

        .nav-icon {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 1rem;
            stroke-width: 2;
            flex-shrink: 0;
            color: var(--secondary);
        }

        .nav-item span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Bouton mobile */
        .mobile-menu-btn {
            position: fixed;
            top: 1.25rem;
            left: 1.25rem;
            z-index: 60;
            background: var(--primary);
            color: var(--secondary);
            border: none;
            border-radius: var(--radius-full);
            width: 2.75rem;
            height: 2.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-md);
            cursor: pointer;
            transition: var(--transition-transform);
            display: none;
        }

        .mobile-menu-btn:hover {
            transform: scale(1.1);
            background: var(--success);
        }

        .mobile-menu-btn svg {
            width: 1.5rem;
            height: 1.5rem;
        }

        /* Contenu principal */
        .main-content {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
            transition: var(--transition-base);
            background-color: var(--white);
            position: relative;
        }

        .content-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Alertes */
        .alert {
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            border-radius: var(--radius-md);
            display: flex;
            align-items: flex-start;
            animation: fadeIn 0.3s ease-out;
            border-left: 4px solid transparent;
            background-color: var(--neutral);
            box-shadow: var(--shadow-sm);
            transition: var(--transition-base);
        }

        .alert-success {
            border-left-color: var(--success);
            color: var(--black);
        }

        .alert-error {
            border-left-color: var(--accent);
            color: var(--black);
        }

        .alert-icon {
            margin-right: 0.75rem;
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
            margin-top: 0.125rem;
        }

        .alert-success .alert-icon {
            color: var(--success);
        }

        .alert-error .alert-icon {
            color: var(--accent);
        }

        .alert-content {
            flex: 1;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar-visible {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: flex;
            }

            .dropdown-menu {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .content-container {
                padding: 1.5rem 1rem;
            }

            .sidebar {
                width: 260px;
            }
        }

        @media (max-width: 480px) {
            .content-container {
                padding: 1.25rem 0.75rem;
            }

            .alert {
                flex-direction: column;
                align-items: flex-start;
            }

            .alert-icon {
                margin-bottom: 0.5rem;
                margin-right: 0;
            }

            .user-info {
                padding: 0.75rem;
                font-size: 0.75rem;
            }

            .user-name {
                font-size: 0.875rem;
            }

            .dropdown-item {
                font-size: 0.75rem;
                padding: 0.5rem 1rem;
            }
        }

        /* Bouton de déconnexion */
        .logout-btn {
            background: none;
            border: none;
            color: var(--black); /* Force la couleur noire pour le texte */
            cursor: pointer;
            display: flex;
            align-items: center;
            width: 100%;
            text-align: left;
            padding: 0.75rem 1.5rem; /* Restaure le padding de .dropdown-item */
            font-family: inherit;
            font-size: inherit;
        }

        /* Effet de transition pour le contenu */
        .content-transition {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Bouton mobile -->
    <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle menu" aria-expanded="false">
        <svg id="menuIconOpen" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
        <svg id="menuIconClose" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h1 class="sidebar-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Gestion Réserve foncière</span>
            </h1>
            @auth
            <div class="user-info">
                <button class="user-info-toggle" id="userInfoToggle" aria-expanded="false" aria-controls="user-menu">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-role">{{ auth()->user()->getRoleNames()->first() }}</span>
                    <svg class="dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="dropdown-menu" id="user-menu">
                    <a href="{{ route('profile') }}" class="dropdown-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profil
                    </a>
                    <a href="{{ route('password.change') }}" class="dropdown-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1-.9-2-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2h4a2 2 0 002-2v-2m0-4v2m6-6V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v6a2 2 0 002 2h4a2 2 0 002-2v-2m0-4v2m6-6v14"></path>
                        </svg>
                        Changer le mot de passe
                    </a>
                    <button type="submit" form="logout-form" class="dropdown-item logout-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Déconnexion
                    </button>
                </div>
            </div>
            @endauth
        </div>

        <nav class="sidebar-nav">
            @can('view-parcels')
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" aria-label="Tableau de bord">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Tableau de bord</span>
            </a>
            @endcan

            @can('create-parcelles')
            <a href="{{ route('parcelles.create') }}" class="nav-item {{ request()->routeIs('parcelles.create') ? 'active' : '' }}" aria-label="Nouvelle parcelle">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Nouvelle parcelle</span>
            </a>
            @endcan

            @can('manage-users')
            <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.index') ? 'active' : '' }}" aria-label="Utilisateurs">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span>Utilisateurs</span>
            </a>
            @endcan

            <!-- Formulaire caché pour la déconnexion -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </aside>

    <!-- Contenu principal -->
    <main class="main-content" id="mainContent">
        <div class="content-container content-transition">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="alert-content">
                    {{ session('success') }}
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-error" role="alert">
                <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="alert-content">
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Toggle sidebar amélioré avec aria-expanded
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const menuIconOpen = document.getElementById('menuIconOpen');
        const menuIconClose = document.getElementById('menuIconClose');

        function toggleSidebar() {
            const isVisible = sidebar.classList.toggle('sidebar-visible');
            menuIconOpen.style.display = isVisible ? 'none' : 'block';
            menuIconClose.style.display = isVisible ? 'block' : 'none';
            mobileMenuBtn.setAttribute('aria-expanded', isVisible);

            // Empêche le défilement du corps lorsque le sidebar est ouvert
            document.body.style.overflow = isVisible ? 'hidden' : '';
        }

        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleSidebar();
        });

        // Fermer le sidebar en cliquant à l'extérieur
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 1024 && !sidebar.contains(e.target) && e.target !== mobileMenuBtn) {
                sidebar.classList.remove('sidebar-visible');
                menuIconOpen.style.display = 'block';
                menuIconClose.style.display = 'none';
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }
        });

        // Gestion du dropdown utilisateur
        const userInfoToggle = document.getElementById('userInfoToggle');
        const userMenu = document.getElementById('user-menu');

        userInfoToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const isExpanded = userInfoToggle.getAttribute('aria-expanded') === 'true';
            userInfoToggle.setAttribute('aria-expanded', !isExpanded);
        });

        // Fermer le dropdown en cliquant à l'extérieur
        document.addEventListener('click', (e) => {
            if (!userInfoToggle.contains(e.target)) {
                userInfoToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Fermer le dropdown avec la touche Échap
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                userInfoToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Navigation au clavier dans le dropdown
        const dropdownItems = userMenu.querySelectorAll('.dropdown-item');
        dropdownItems.forEach((item, index) => {
            item.setAttribute('tabindex', '0');
            item.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    item.click();
                } else if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    const next = dropdownItems[index + 1] || dropdownItems[0];
                    next.focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    const prev = dropdownItems[index - 1] || dropdownItems[dropdownItems.length - 1];
                    prev.focus();
                }
            });
        });

        // Animation fluide du contenu
        document.addEventListener('DOMContentLoaded', () => {
            const mainContent = document.getElementById('mainContent');
            mainContent.style.opacity = '0';
            setTimeout(() => {
                mainContent.style.transition = 'opacity 0.3s ease-out';
                mainContent.style.opacity = '1';
            }, 100);

            // Amélioration de l'accessibilité
            document.documentElement.lang = 'fr';
            document.documentElement.setAttribute('data-color-scheme', 'light');
        });

        // Gestion du redimensionnement de la fenêtre
        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) {
                sidebar.classList.remove('sidebar-visible');
                menuIconOpen.style.display = 'block';
                menuIconClose.style.display = 'none';
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
                userInfoToggle.setAttribute('aria-expanded', 'false');
            }
        });
    </script>

    <!-- Leaflet JS -->
    @if (!request()->routeIs('login'))
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @endif
</body>
</html>
