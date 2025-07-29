<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - Gestion Parcelles</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #003087;
            --secondary: #008000;
            --accent: #F97316;
            --white: #ffffff;
            --gray-light: #f3f4f6;
            --gray-dark: #4b5563;
            --error: #e3342f;
            --success: #38c172;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--accent) 100%);
            background-size: 300% 300%;
            animation: gradient 15s ease infinite;
            color: var(--white);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow-x: hidden;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        @keyframes halo {
            0% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4); }
            100% { box-shadow: 0 0 0 20px rgba(255, 255, 255, 0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        }

        .reset-card {
            width: 100%;
            max-width: 420px;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            z-index: 10;
            transition: transform 0.3s ease;
        }

        .reset-card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            padding: 40px 20px;
            text-align: center;
            position: relative;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.5), transparent);
        }

        .logo-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--white);
            animation: float 6s ease-in-out infinite;
            position: relative;
        }

        .logo-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 50%;
            animation: halo 2s ease-out infinite;
        }

        .logo {
            width: 40px;
            height: 40px;
            color: var(--primary);
        }

        .card-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .card-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        .card-body {
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: var(--gray-dark);
            font-weight: 500;
        }

        .input-field {
            width: 100%;
            padding: 12px 16px 12px 40px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: var(--white);
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 48, 135, 0.2);
        }

        .input-field.error {
            border-color: var(--error);
            animation: shake 0.5s ease;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-dark);
            width: 20px;
            height: 20px;
        }

        .input-wrapper {
            position: relative;
        }

        .error-message {
            color: var(--error);
            font-size: 14px;
            margin-top: 8px;
            display: block;
        }

        .success-message {
            color: var(--success);
            font-size: 14px;
            margin-top: 8px;
            display: block;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--accent));
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .login-link:hover {
            color: var(--accent);
        }

        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        @media (max-width: 480px) {
            .reset-card {
                border-radius: 12px;
            }

            .card-header {
                padding: 30px 20px;
            }

            .card-body {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <canvas class="particles"></canvas>

    <div class="reset-card glass">
        <div class="card-header">
            <div class="logo-container">
                <svg class="logo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
                </svg>
            </div>
            <h1 class="card-title">Réinitialiser le mot de passe</h1>
            <p class="card-subtitle">Entrez votre email pour recevoir un lien de réinitialisation</p>
        </div>

        <div class="card-body">
            @if (session('status'))
                <div class="success-message">{{ session('status') }}</div>
            @endif
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="input-field @error('email') error @enderror" placeholder="votre@email.com" required aria-describedby="email-error">
                    </div>
                    @error('email')
                        <span class="error-message" id="email-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Envoyer le lien de réinitialisation</button>

                <a href="{{ route('login') }}" class="login-link">Retour à la connexion</a>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.querySelector('.particles');
            const ctx = canvas.getContext('2d');

            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            const particles = [];
            const particleCount = Math.floor(window.innerWidth * window.innerHeight / 10000);

            for (let i = 0; i < particleCount; i++) {
                particles.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    size: Math.random() * 3 + 1,
                    speedX: Math.random() * 1 - 0.5,
                    speedY: Math.random() * 1 - 0.5,
                    color: `rgba(255, 255, 255, ${Math.random() * 0.5 + 0.1})`
                });
            }

            function animateParticles() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                for (let i = 0; i < particles.length; i++) {
                    const p = particles[i];

                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                    ctx.fillStyle = p.color;
                    ctx.fill();

                    p.x += p.speedX;
                    p.y += p.speedY;

                    if (p.x < 0 || p.x > canvas.width) p.speedX *= -1;
                    if (p.y < 0 || p.y > canvas.height) p.speedY *= -1;
                }

                requestAnimationFrame(animateParticles);
            }

            animateParticles();

            window.addEventListener('resize', function() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        });
    </script>
</body>
</html>
