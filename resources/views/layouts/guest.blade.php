<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Préchargement optimisé -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Chargement asynchrone des assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Style inlined pour le chargement instantané -->
    <style>
        :root {
            --color-primary: 0, 48, 135;
            --color-secondary: 0, 128, 0;
            --color-accent: 249, 115, 22;
        }

        [x-cloak] { display: none !important; }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            color: white;
            overflow-x: hidden;
            background: linear-gradient(
                135deg,
                rgba(var(--color-primary), 1) 0%,
                rgba(var(--color-secondary), 0.8) 50%,
                rgba(var(--color-accent), 0.9) 100%
            );
            background-attachment: fixed;
            background-size: 300% 300%;
            animation: gradient 12s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.36);
        }

    </style>
</head>
<body class="relative h-full overflow-hidden">
    <!-- Particules de fond -->
    <div id="particles-js" class="absolute inset-0 z-0"></div>

    <!-- Effet de lumière animé -->
    <div class="light-effect absolute -top-1/4 -left-1/4 w-1/2 h-1/2 rounded-full bg-primary/20 filter blur-3xl animate-pulse-slow opacity-70"></div>

    <main class="relative z-10 min-h-screen flex flex-col">
        @if (session('success'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-init="setTimeout(() => show = false, 5000)"
                 class="fixed top-6 right-6 z-50 px-6 py-4 glass-card rounded-lg border-l-4 border-green-400 text-white shadow-xl">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration des particules
            if (typeof particlesJS !== 'undefined') {
                particlesJS('particles-js', {
                    particles: {
                        number: { value: 80, density: { enable: true, value_area: 800 } },
                        color: { value: "#ffffff" },
                        shape: { type: "circle" },
                        opacity: { random: true, value: 0.5 },
                        size: { random: true, value: 3 },
                        line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
                        move: { enable: true, speed: 2, direction: "none", random: true, straight: false, out_mode: "out" }
                    },
                    interactivity: {
                        detect_on: "canvas",
                        events: {
                            onhover: { enable: true, mode: "repulse" },
                            onclick: { enable: true, mode: "push" }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
