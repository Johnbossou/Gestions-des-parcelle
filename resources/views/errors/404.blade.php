<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page introuvable</title>
    <style>
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', Arial, sans-serif; background: #F5F5F5; color: #333; }
        .container { text-align: center; padding: 2rem; }
        h1 { font-size: 6rem; margin: 0; color: #1A5F23; }
        h2 { font-size: 1.5rem; color: #F9A825; margin: 0.5rem 0 1rem; }
        p { color: #666; margin-bottom: 2rem; }
        a { display: inline-block; padding: 0.75rem 1.5rem; background: #1A5F23; color: #fff; text-decoration: none; border-radius: 0.5rem; font-weight: 500; transition: background 0.2s; }
        a:hover { background: #4CAF50; }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h2>Page introuvable</h2>
        <p>La page que vous recherchez n'existe pas ou a été déplacée.</p>
        <a href="{{ url('/dashboard') }}">Retour au tableau de bord</a>
    </div>
</body>
</html>
