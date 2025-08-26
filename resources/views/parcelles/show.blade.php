@extends('layouts.app')
@section('title', 'Détails de la parcelle #' . $parcelle->numero)
@section('content')

<!-- Intégration de Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>

<div class="content-container">
    <!-- En-tête amélioré -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Détails de la parcelle #{{ $parcelle->numero }}
            </h1>
            <p class="page-description">Informations complètes sur cette parcelle cadastrale</p>
        </div>
        <div class="header-actions">
            @can('edit-parcels')
            <a href="{{ route('parcelles.edit', $parcelle) }}" class="btn btn-secondary" aria-label="Modifier la parcelle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifier
            </a>
            @endcan
            @can('delete-parcels')
            <form action="{{ route('parcelles.destroy', $parcelle) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette parcelle ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" aria-label="Supprimer la parcelle">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer
                </button>
            </form>
            @endcan
        </div>
    </div>

    <!-- Grille de cartes -->
    <div class="card-grid">
        <!-- Carte Informations Générales -->
        <div class="card">
            <div class="card-header">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h2>Informations générales</h2>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Numéro</span>
                        <span class="detail-value">{{ $parcelle->numero ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Parcelle</span>
                        <span class="detail-value">{{ $parcelle->parcelle ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Arrondissement</span>
                        <span class="detail-value">{{ $parcelle->arrondissement ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Secteur</span>
                        <span class="detail-value">{{ $parcelle->secteur ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Lot</span>
                        <span class="detail-value">{{ $parcelle->lot ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Adressage</span>
                        <span class="detail-value">{{ $parcelle->designation ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Type de terrain</span>
                        <span class="detail-value">{{ $parcelle->type_terrain ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Statut d'attribution</span>
                        <span class="detail-value">{{ ucfirst($parcelle->statut_attribution ?? 'N/A') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Ancienne superficie</span>
                        <span class="detail-value">{{ $parcelle->ancienne_superficie ? number_format($parcelle->ancienne_superficie, 2) . ' m²' : 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Nouvelle superficie</span>
                        <span class="detail-value">{{ $parcelle->nouvelle_superficie ? number_format($parcelle->nouvelle_superficie, 2) . ' m²' : 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Écart superficie</span>
                        <span class="detail-value">
                            @if($parcelle->ecart_superficie)
                                <span class="{{ $parcelle->ecart_superficie > 0 ? 'text-success' : ($parcelle->ecart_superficie < 0 ? 'text-danger' : '') }}">
                                    {{ ($parcelle->ecart_superficie > 0 ? '+' : '') . number_format($parcelle->ecart_superficie, 2) . ' m²' }}
                                </span>
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Motif d'occupation</span>
                        <span class="detail-value">{{ $parcelle->motif ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Observations</span>
                        <span class="detail-value">{{ $parcelle->observations ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Litige</span>
                        <span class="detail-value">
                            <span class="badge {{ $parcelle->litige ? 'badge-danger' : 'badge-success' }}">
                                {{ $parcelle->litige ? 'Oui' : 'Non' }}
                            </span>
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Détails litige</span>
                        <span class="detail-value">{{ $parcelle->details_litige ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Structure</span>
                        <span class="detail-value">{{ $parcelle->structure ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Localisation -->
        <div class="card">
            <div class="card-header">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <h2>Localisation</h2>
            </div>
            <div class="card-body">
                <div class="detail-grid mb-6">
                    <div class="detail-item">
                        <span class="detail-label">Latitude</span>
                        <span class="detail-value">{{ $parcelle->latitude ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Longitude</span>
                        <span class="detail-value">{{ $parcelle->longitude ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="map-container">
                    <div id="map" class="map-view" aria-describedby="map-description"></div>
                    <span id="map-description" class="sr-only">Carte interactive montrant la localisation de la parcelle #{{ $parcelle->numero }}</span>
                    @if($parcelle->latitude && $parcelle->longitude)
                        <a href="https://www.google.com/maps?q={{ $parcelle->latitude }},{{ $parcelle->longitude }}" target="_blank" class="btn btn-accent mt-4" aria-label="Voir la parcelle sur Google Maps">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            Voir sur Google Maps
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Carte Métadonnées -->
        <div class="card">
            <div class="card-header">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <h2>Métadonnées</h2>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Agent</span>
                        <span class="detail-value">{{ optional($parcelle->agent)->name ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Responsable</span>
                        <span class="detail-value">{{ optional($parcelle->responsable)->name ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Créé par</span>
                        <span class="detail-value">
                            {{ optional($parcelle->createdBy)->name ?? 'N/A' }}
                            @if($parcelle->createdBy && $parcelle->createdBy->hasRole('Superviseur_administratif'))
                                (Superviseur Administratif)
                            @elseif($parcelle->createdBy && $parcelle->createdBy->hasRole('Chef_Administratif'))
                                (Chef Administratif)
                            @else
                                (Aucun rôle)
                            @endif
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date de création</span>
                        <span class="detail-value">
                            {{ $parcelle->created_at ? $parcelle->created_at->format('d/m/Y H:i') : 'N/A' }}
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Mis à jour par</span>
                        <span class="detail-value">{{ optional($parcelle->updatedBy)->name ?? 'N/A' }}</span>
                    </div>
                    <!-- Nouveau champ : Directeur ayant validé -->
                    <div class="detail-item">
                        <span class="detail-label">Validé par</span>
                        <span class="detail-value">
                            @if($parcelle->validationLogs->isNotEmpty() && $parcelle->validationLogs->first()->director)
                                {{ $parcelle->validationLogs->first()->director->name }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date de validation</span>
                        <span class="detail-value">
                            @if($parcelle->validationLogs->isNotEmpty())
                                {{ $parcelle->validationLogs->first()->created_at->format('d/m/Y H:i') }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date de mise à jour</span>
                        <span class="detail-value">
                            {{ $parcelle->date_mise_a_jour ? $parcelle->date_mise_a_jour->format('d/m/Y H:i') : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles spécifiques à la page -->
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
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);

        /* Rayons */
        --radius-sm: 4px;
        --radius-md: 8px;
        --radius-lg: 12px;
        --radius-full: 9999px;

        /* Transitions */
        --transition-base: all 0.3s ease;
        --transition-transform: transform 0.3s ease;
    }

    /* Structure de la page */
    .content-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
        background: var(--neutral);
    }

    /* En-tête de page */
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-bottom: 2rem;
        background: var(--primary);
        padding: 1.5rem;
        border-radius: var(--radius-md);
        color: var(--white);
        box-shadow: var(--shadow-md);
    }

    @media (min-width: 768px) {
        .page-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
        }
    }

    .header-content {
        flex: 1;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .page-title {
        font-family: 'Roboto', Arial, sans-serif;
        font-weight: 700;
        font-size: 1.75rem;
        color: var(--white);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .page-title svg {
        width: 1.5rem;
        height: 1.5rem;
        stroke-width: 2;
        color: var(--secondary);
    }

    .page-description {
        color: var(--neutral);
        font-size: 1rem;
        font-family: 'Roboto', Arial, sans-serif;
    }

    /* Grille de cartes */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    /* Cartes */
    .card {
        background: var(--white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        transition: var(--transition-base);
        border: 1px solid var(--neutral);
    }

    .card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-4px);
    }

    .card-header {
        background: var(--primary);
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--white);
    }

    .card-header svg {
        width: 1.25rem;
        height: 1.25rem;
        color: var(--secondary);
    }

    .card-header h2 {
        font-family: 'Roboto', Arial, sans-serif;
        font-weight: 600;
        font-size: 1.25rem;
        color: var(--white);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Grille de détails */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        padding: 0.75rem;
        border-radius: var(--radius-sm);
        transition: var(--transition-base);
        background: var(--white);
        border: 1px solid var(--neutral);
    }

    .detail-item:hover {
        background: var(--neutral);
        box-shadow: var(--shadow-sm);
    }

    .detail-label {
        font-size: 0.875rem;
        color: var(--black);
        font-weight: 600;
        margin-bottom: 0.25rem;
        font-family: 'Roboto', Arial, sans-serif;
    }

    .detail-value {
        font-size: 1rem;
        color: var(--black);
        font-weight: 400;
        word-break: break-word;
        font-family: 'Roboto', Arial, sans-serif;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        font-weight: 500;
        font-family: 'Roboto', Arial, sans-serif;
    }

    .badge-success {
        background-color: var(--success);
        color: var(--white);
    }

    .badge-danger {
        background-color: var(--accent);
        color: var(--white);
    }

    /* Carte de localisation */
    .map-container {
        position: relative;
    }

    .map-view {
        height: 320px;
        width: 100%;
        border-radius: var(--radius-md);
        overflow: hidden;
        background: var(--neutral);
        border: 1px solid var(--neutral);
    }

    /* Boutons */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: var(--transition-base);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
        box-shadow: var(--shadow-sm);
        font-family: 'Roboto', Arial, sans-serif;
    }

    .btn-secondary {
        background: var(--secondary);
        color: var(--black);
    }

    .btn-secondary:hover {
        background: var(--secondary-light);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-danger {
        background: var(--accent);
        color: var(--white);
    }

    .btn-danger:hover {
        background: #c62828; /* Rouge légèrement plus foncé */
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-accent {
        background: var(--secondary);
        color: var(--black);
    }

    .btn-accent:hover {
        background: var(--secondary-light);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Couleurs textes */
    .text-success {
        color: var(--success);
    }

    .text-danger {
        color: var(--accent);
    }

    /* Popup Leaflet */
    .map-popup {
        font-family: 'Roboto', Arial, sans-serif;
        color: var(--black);
    }

    .map-popup .popup-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.25rem;
    }

    .map-popup .popup-text {
        font-size: 0.875rem;
        color: var(--black);
    }

    /* Screen reader only */
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-container {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .card-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.25rem;
        }

        .page-header {
            padding: 1rem;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Script pour la carte -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const latitude = {{ $parcelle->latitude ?? 'null' }};
        const longitude = {{ $parcelle->longitude ?? 'null' }};
        const mapContainer = document.getElementById('map');

        if (latitude && longitude) {
            const map = L.map('map').setView([latitude, longitude], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            const marker = L.marker([latitude, longitude]).addTo(map);
            marker.bindPopup(`
                <div class="map-popup">
                    <h3 class="popup-title">Parcelle #{{ $parcelle->numero }}</h3>
                    <p class="popup-text">{{ $parcelle->parcelle }}</p>
                    <p class="popup-text">{{ $parcelle->arrondissement }}</p>
                </div>
            `).openPopup();
        } else {
            mapContainer.innerHTML = `
                <div class="flex items-center justify-center h-full text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Coordonnées non disponibles
                </div>
            `;
        }
    });
</script>
@endsection
