<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle parcelle</title>
    <style>
        :root {
            /* Couleurs principales */
            --primary: #1A5F23; /* Vert foncé */
            --secondary: #F9A825; /* Jaune doré */
            --accent: #E30613; /* Rouge béninois */
            --neutral: #F5F5F5; /* Gris clair */
            --black: #333333; /* Noir */
            --white: #FFFFFF; /* Blanc */
            --success: #4CAF50; /* Vert clair */
            --secondary-light: #FCD116; /* Jaune clair pour survol */

            /* Ombres */
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);

            /* Rayons */
            --border-radius: 8px;

            /* Transitions */
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: var(--neutral);
            color: var(--black);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 0.8s ease-out;
        }

        h1 {
            font-family: 'Roboto', Arial, sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
            letter-spacing: -0.5px;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 4px;
            background: var(--secondary);
            border-radius: 2px;
        }

        .form-container {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid var(--neutral);
        }

        .form-header {
            background: var(--primary);
            padding: 25px 40px;
            color: var(--white);
        }

        .form-header h2 {
            font-family: 'Roboto', Arial, sans-serif;
            font-weight: 600;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-header h2 svg {
            width: 28px;
            height: 28px;
            color: var(--secondary);
        }

        .form-content {
            padding: 40px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: var(--black);
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group label svg {
            width: 20px;
            height: 20px;
            color: var(--secondary);
        }

        .form-control {
            width: 100%;
            padding: 16px 18px;
            border: 2px solid var(--neutral);
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-family: 'Roboto', Arial, sans-serif;
            transition: var(--transition);
            background-color: var(--neutral);
            color: var(--black);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--success);
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.15);
            background-color: var(--white);
        }

        .form-control.error {
            border-color: var(--accent);
            animation: shake 0.5s;
        }

        .error-message {
            color: var(--accent);
            font-size: 0.9rem;
            margin-top: 8px;
            display: block;
            animation: fadeIn 0.3s;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .form-actions {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            padding-top: 30px;
            border-top: 1px solid var(--neutral);
        }

        .btn {
            padding: 16px 32px;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 1.05rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: none;
        }

        .btn-submit {
            background: var(--primary);
            color: var(--white);
            box-shadow: var(--shadow-sm);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            background: var(--success);
        }

        .btn-cancel {
            background: var(--secondary);
            color: var(--black);
            box-shadow: var(--shadow-sm);
        }

        .btn-cancel:hover {
            background: var(--secondary-light);
            color: var(--black);
        }

        .section-title {
            font-family: 'Roboto', Arial, sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary);
            margin: 40px 0 25px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--neutral);
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 80px;
            height: 2px;
            background: var(--secondary);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        @keyframes glow {
            0% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.5); }
            70% { box-shadow: 0 0 0 12px rgba(76, 175, 80, 0); }
            100% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0); }
        }

        .glow-animation {
            animation: glow 1.5s infinite;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 2rem;
            }

            .form-content {
                padding: 25px;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Nouvelle parcelle</h1>
            <p>Remplissez les détails pour créer une nouvelle parcelle</p>
        </header>

        <div class="form-container">
            <div class="form-header">
                <h2>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informations de base
                </h2>
            </div>

            <div class="form-content">
                <form action="{{ route('parcelles.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="arrondissement">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Arrondissement
                            </label>
                            <select id="arrondissement" name="arrondissement" class="form-control" required>
                                <option value="">Sélectionnez un arrondissement</option>
                                <option value="Godomey">Godomey</option>
                                <option value="Calavi">Calavi</option>
                                <option value="Hêvié">Hêvié</option>
                                <option value="Akassato">Akassato</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="secteur">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Secteur
                            </label>
                            <input type="text" id="secteur" name="secteur" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="lot">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                Lot
                            </label>
                            <input type="number" id="lot" name="lot" class="form-control" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="designation">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                Désignation
                            </label>
                            <input type="text" id="designation" name="designation" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="parcelle">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Parcelle
                            </label>
                            <input type="text" id="parcelle" name="parcelle" class="form-control">
                        </div>
                    </div>

                    <div class="section-title">Superficie</div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="ancienne_superficie">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                                </svg>
                                Ancienne superficie (m²)
                            </label>
                            <input type="number" step="0.1" id="ancienne_superficie" name="ancienne_superficie" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="nouvelle_superficie">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Nouvelle superficie (m²)
                            </label>
                            <input type="number" step="0.1" id="nouvelle_superficie" name="nouvelle_superficie" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="motif">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Motif
                            </label>
                            <input type="text" id="motif" name="motif" class="form-control">
                        </div>
                    </div>

                    <div class="section-title">Caractéristiques</div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="type_terrain">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Type de terrain
                            </label>
                            <select id="type_terrain" name="type_terrain" class="form-control" required>
                                <option value="">Sélectionnez un type</option>
                                <option value="Résidentiel">Résidentiel</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Agricole">Agricole</option>
                                <option value="Institutionnel">Institutionnel</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="statut_attribution">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Statut d'attribution
                            </label>
                            <select id="statut_attribution" name="statut_attribution" class="form-control" required>
                                <option value="">Sélectionnez un statut</option>
                                <option value="attribué">Attribué</option>
                                <option value="non attribué">Non attribué</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="litige">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Litige
                            </label>
                            <select id="litige" name="litige" class="form-control" required>
                                <option value="">Sélectionnez une option</option>
                                <option value="1">Oui</option>
                                <option value="0">Non</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label for="observations">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Observations
                            </label>
                            <textarea id="observations" name="observations" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="form-group full-width">
                            <label for="details_litige">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Détails litige
                            </label>
                            <textarea id="details_litige" name="details_litige" class="form-control" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="section-title">Coordonnées</div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="structure">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Structure
                            </label>
                            <input type="text" id="structure" name="structure" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="latitude">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Latitude
                            </label>
                            <input type="number" step="0.000001" id="latitude" name="latitude" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="longitude">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Longitude
                            </label>
                            <input type="number" step="0.000001" id="longitude" name="longitude" class="form-control">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-submit glow-animation">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Créer
                        </button>
                        <button type="button" class="btn btn-cancel" onclick="window.location.href='{{ route('parcelles.index') }}'">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
