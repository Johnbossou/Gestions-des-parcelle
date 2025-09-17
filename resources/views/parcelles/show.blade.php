@extends('layouts.app')
@section('title', 'Détails de la parcelle #' . $parcelle->numero)
@section('content')

<!-- Intégration de Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="parcelle-details-container">
    <!-- Header avec image d'en-tête -->
    <div class="parcelle-hero">
        <div class="hero-overlay">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.161 2.58a1.875 1.875 0 011.678 0l4.993 2.498c.106.052.23.052.336 0l3.869-1.935A1.875 1.875 0 0121.75 4.82v12.485c0 .71-.401 1.36-1.037 1.677l-4.875 2.437a1.875 1.875 0 01-1.676 0l-4.994-2.497a.375.375 0 00-.336 0l-3.868 1.935A1.875 1.875 0 012.25 19.18V6.695c0-.71.401-1.36 1.036-1.677l4.875-2.437zM9 6a.75.75 0 01.75.75V15a.75.75 0 01-1.5 0V6.75A.75.75 0 019 6zm6.75 3a.75.75 0 00-1.5 0v8.25a.75.75 0 001.5 0V9z" clip-rule="evenodd" />
                        </svg>
                        Parcelle #{{ $parcelle->numero }}
                    </h1>
                    <p class="hero-subtitle">{{ $parcelle->designation ?? 'Parcelle cadastrale' }}</p>
                    <div class="hero-badges">
                        <span class="status-badge {{ $parcelle->statut_attribution == 'attribué' ? 'statut-active' : 'statut-inactif' }}">
                            <i class="fas fa-{{ $parcelle->statut_attribution == 'attribué' ? 'check-circle' : 'times-circle' }}"></i>
                            {{ $parcelle->statut_attribution ?? 'Non spécifié' }}
                        </span>
                        <span class="status-badge {{ $parcelle->litige ? 'statut-alerte' : 'statut-succes' }}">
                            <i class="fas fa-{{ $parcelle->litige ? 'exclamation-triangle' : 'peace' }}"></i>
                            {{ $parcelle->litige ? 'Avec litige' : 'Sans litige' }}
                        </span>
                    </div>
                </div>
                <div class="hero-actions">
                    @can('edit-parcelles')
                    <a href="{{ route('parcelles.edit', $parcelle) }}" class="btn btn-icon btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                            <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                        </svg>
                        Modifier
                    </a>
                    @endcan
                    @can('delete-parcels')
                    <form action="{{ route('parcelles.destroy', $parcelle) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette parcelle ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-icon btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                            </svg>
                            Supprimer
                        </button>
                    </form>
                    @endcan
                    <a href="{{ route('parcelles.index') }}" class="btn btn-icon btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.72 12.53a.75.75 0 010-1.06l7.5-7.5a.75.75 0 111.06 1.06L9.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5z" clip-rule="evenodd" />
                        </svg>
                        Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation par onglets -->
    <div class="tabs-navigation">
        <div class="tabs-container">
            <button class="tab-btn active" data-tab="informations">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                </svg>
                Informations
            </button>
            <button class="tab-btn" data-tab="localisation">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.683 2.282 16.975 16.975 0 001.144.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
                Localisation
            </button>
            <button class="tab-btn" data-tab="metadonnees">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" clip-rule="evenodd" />
                </svg>
                Métadonnées
            </button>
        </div>
    </div>

    <!-- Contenu des onglets -->
    <div class="tab-content-container">
        <!-- Onglet Informations Générales -->
        <div id="informations" class="tab-content active">
            <div class="info-cards-grid">
                <!-- Carte Identification -->
                <div class="info-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 00-3 3v10.5a3 3 0 003 3h15a3 3 0 003-3V6.75a3 3 0 00-3-3h-15zm4.125 3a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5zm-3.873 8.703a4.5 4.5 0 017.746 0 .75.75 0 01-.351.97 7.5 7.5 0 01-7.044 0 .75.75 0 01-.351-.97zM15 8.25a.75.75 0 000 1.5h3.75a.75.75 0 000-1.5H15zM14.25 12a.75.75 0 01.75-.75h3.75a.75.75 0 010 1.5H15a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3.75a.75.75 0 000-1.5H15z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h2>Identification</h2>
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
                        </div>
                    </div>
                </div>

                <!-- Carte Occupation -->
                <div class="info-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19.006 3.705a.75.75 0 00-.512-1.41L6 6.838V3a.75.75 0 00-.75-.75h-1.5A.75.75 0 003 3v4.93l-1.006.365a.75.75 0 00.512 1.41l16.5-6z" />
                                <path fill-rule="evenodd" d="M3.019 11.115L18 5.667V9.09l4.006 1.456a.75.75 0 11-.512 1.41l-.494-.18v8.475h.75a.75.75 0 010 1.5H2.25a.75.75 0 010-1.5H3v-9.129l.019-.006zM18 20.25v-9.565l1.5.545v9.02H18zm-9-6a.75.75 0 00-.75.75v4.5c0 .414.336.75.75.75h3a.75.75 0 00.75-.75V15a.75.75 0 00-.75-.75H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h2>Occupation</h2>
                    </div>
                    <div class="card-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <span class="detail-label">Type d'occupation</span>
                                <span class="detail-value">{{ $parcelle->type_occupation ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Détails occupation</span>
                                <span class="detail-value">{{ $parcelle->details_occupation ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Référence autorisation</span>
                                <span class="detail-value">{{ $parcelle->reference_autorisation ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Date autorisation</span>
                                <span class="detail-value">{{ $parcelle->date_autorisation ? $parcelle->date_autorisation->format('d/m/Y') : 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Date expiration</span>
                                <span class="detail-value">{{ $parcelle->date_expiration_autorisation ? $parcelle->date_expiration_autorisation->format('d/m/Y') : 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Statut d'attribution</span>
                                <span class="detail-value status-indicator {{ $parcelle->statut_attribution == 'attribué' ? 'status-active' : 'status-inactive' }}">
                                    {{ ucfirst($parcelle->statut_attribution ?? 'N/A') }}
                                </span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Motif d'occupation</span>
                                <span class="detail-value">{{ $parcelle->motif ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Structure</span>
                                <span class="detail-value">{{ $parcelle->structure ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte Superficie -->
                <div class="info-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.75 3a.75.75 0 00-.75.75v16.5c0 .414.336.75.75.75h16.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75H3.75zM6 7.5a.75.75 0 00.75.75h3a.75.75 0 000-1.5h-3A.75.75 0 006 7.5zm.75 3a.75.75 0 000 1.5h10.5a.75.75 0 000-1.5H6.75zm0 3a.75.75 0 000 1.5h10.5a.75.75 0 000-1.5H6.75zm0 3a.75.75 0 000 1.5h10.5a.75.75 0 000-1.5H6.75z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h2>Superficie</h2>
                    </div>
                    <div class="card-body">
                        <div class="superficie-comparison">
                            <div class="superficie-item">
                                <div class="superficie-label">Ancienne</div>
                                <div class="superficie-value">{{ $parcelle->ancienne_superficie ? number_format($parcelle->ancienne_superficie, 2) . ' m²' : 'N/A' }}</div>
                            </div>

                            <div class="comparison-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                </svg>
                            </div>

                            <div class="superficie-item">
                                <div class="superficie-label">Nouvelle</div>
                                <div class="superficie-value">{{ $parcelle->nouvelle_superficie ? number_format($parcelle->nouvelle_superficie, 2) . ' m²' : 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="ecart-superficie">
                            @php
                                $ancienne = $parcelle->ancienne_superficie ?? 0;
                                $nouvelle = $parcelle->nouvelle_superficie ?? 0;
                                $ecart = $nouvelle - $ancienne;
                                $pourcentage = $ancienne > 0 ? round(($ecart / $ancienne) * 100, 2) : 0;
                            @endphp

                            <div class="ecart-label">Écart de superficie</div>
                            <div class="ecart-value {{ $ecart > 0 ? 'positive' : ($ecart < 0 ? 'negative' : 'neutral') }}">
                                {{ ($ecart > 0 ? '+' : '') . number_format($ecart, 2) . ' m²' }}
                                <span class="ecart-percentage">({{ $pourcentage }}%)</span>
                            </div>

                            @if($ancienne > 0 && $nouvelle > 0)
                            <div class="progress-bar-container">
                                <div class="progress-bar">
                                    <div class="progress-fill {{ $ecart > 0 ? 'positive' : ($ecart < 0 ? 'negative' : '') }}"
                                         style="width: {{ min(abs($pourcentage), 100) }}%">
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Carte Autres informations -->
                <div class="info-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h2>Autres informations</h2>
                    </div>
                    <div class="card-body">
                        <div class="detail-grid">
                            <div class="detail-item full-width">
                                <span class="detail-label">Observations</span>
                                <span class="detail-value">{{ $parcelle->observations ?? 'Aucune observation' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Litige</span>
                                <span class="detail-value">
                                    <span class="status-indicator {{ $parcelle->litige ? 'status-warning' : 'status-success' }}">
                                        {{ $parcelle->litige ? 'Oui' : 'Non' }}
                                    </span>
                                </span>
                            </div>
                            <div class="detail-item full-width">
                                <span class="detail-label">Détails litige</span>
                                <span class="detail-value">{{ $parcelle->details_litige ?? 'Aucun détail de litige' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet Localisation -->
        <div id="localisation" class="tab-content">
            <div class="localisation-container">
                <div class="map-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.683 2.282 16.975 16.975 0 001.144.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h2>Localisation Géographique</h2>
                    </div>
                    <div class="card-body">
                        <div class="coordinates-grid">
                            <div class="coordinate-item">
                                <span class="coordinate-label">Latitude</span>
                                <span class="coordinate-value">{{ $parcelle->latitude ?? 'N/A' }}</span>
                            </div>
                            <div class="coordinate-item">
                                <span class="coordinate-label">Longitude</span>
                                <span class="coordinate-value">{{ $parcelle->longitude ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="map-wrapper">
                            <div id="map" class="map-view" aria-describedby="map-description"></div>
                            <div class="map-overlay" id="map-overlay" style="{{ $parcelle->latitude && $parcelle->longitude ? 'display: none;' : '' }}">
                                <div class="overlay-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.161 2.58a1.875 1.875 0 011.678 0l4.993 2.498c.106.052.23.052.336 0l3.869-1.935A1.875 1.875 0 0121.75 4.82v12.485c0 .71-.401 1.36-1.037 1.677l-4.875 2.437a1.875 1.875 0 01-1.676 0l-4.994-2.497a.375.375 0 00-.336 0l-3.868 1.935A1.875 1.875 0 012.25 19.18V6.695c0-.71.401-1.36 1.036-1.677l4.875-2.437zM9 6a.75.75 0 01.75.75V15a.75.75 0 01-1.5 0V6.75A.75.75 0 019 6zm6.75 3a.75.75 0 00-1.5 0v8.25a.75.75 0 001.5 0V9z" clip-rule="evenodd" />
                                    </svg>
                                    <p>Aucune coordonnée disponible</p>
                                </div>
                            </div>
                        </div>

                        @if($parcelle->latitude && $parcelle->longitude)
                        <div class="map-actions">
                            <a href="https://www.google.com/maps?q={{ $parcelle->latitude }},{{ $parcelle->longitude }}" target="_blank" class="btn btn-icon btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.161 2.58a1.875 1.875 0 011.678 0l4.993 2.498c.106.052.23.052.336 0l3.869-1.935A1.875 1.875 0 0121.75 4.82v12.485c0 .71-.401 1.36-1.037 1.677l-4.875 2.437a1.875 1.875 0 01-1.676 0l-4.994-2.497a.375.375 0 00-.336 0l-3.868 1.935A1.875 1.875 0 012.25 19.18V6.695c0-.71.401-1.36 1.036-1.677l4.875-2.437zM9 6a.75.75 0 01.75.75V15a.75.75 0 01-1.5 0V6.75A.75.75 0 019 6zm6.75 3a.75.75 0 00-1.5 0v8.25a.75.75 0 001.5 0V9z" clip-rule="evenodd" />
                                </svg>
                                Voir sur Google Maps
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="location-details-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                                <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z" clip-rule="evenodd" />
                                <path d="M2.25 18a.75.75 0 000 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 00-.75-.75H2.25z" />
                            </svg>
                        </div>
                        <h2>Détails de Localisation</h2>
                    </div>
                    <div class="card-body">
                        <div class="location-details-grid">
                            <div class="location-detail-item">
                                <span class="location-detail-label">Arrondissement</span>
                                <span class="location-detail-value">{{ $parcelle->arrondissement ?? 'N/A' }}</span>
                            </div>
                            <div class="location-detail-item">
                                <span class="location-detail-label">Secteur</span>
                                <span class="location-detail-value">{{ $parcelle->secteur ?? 'N/A' }}</span>
                            </div>
                            <div class="location-detail-item">
                                <span class="location-detail-label">Lot</span>
                                <span class="location-detail-value">{{ $parcelle->lot ?? 'N/A' }}</span>
                            </div>
                            <div class="location-detail-item full-width">
                                <span class="location-detail-label">Adresse complète</span>
                                <span class="location-detail-value">{{ $parcelle->designation ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet Métadonnées -->
        <div id="metadonnees" class="tab-content">
            <div class="metadata-container">
                <div class="metadata-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 00-3 3v10.5a3 3 0 003 3h15a3 3 0 003-3V6.75a3 3 0 00-3-3h-15zm15 1.5a1.5 1.5 0 011.5 1.5v10.5a1.5 1.5 0 01-1.5 1.5h-15a1.5 1.5 0 01-1.5-1.5V6.75a1.5 1.5 0 011.5-1.5h15zM4.5 7.5a.75.75 0 00-.75.75v7.5a.75.75 0 001.5 0v-7.5a.75.75 0 00-.75-.75zm3.75 2.25a.75.75 0 00-.75.75v5.25a.75.75 0 001.5 0V10.5a.75.75 0 00-.75-.75zm3.75 2.25a.75.75 0 00-.75.75v3a.75.75 0 001.5 0v-3a.75.75 0 00-.75-.75zm3.75 1.5a.75.75 0 00-.75.75v1.5a.75.75 0 001.5 0v-1.5a.75.75 0 00-.75-.75z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h2>Métadonnées</h2>
                    </div>
                    <div class="card-body">
                        <div class="metadata-grid">
                            <div class="metadata-item">
                                <span class="metadata-label">Agent</span>
                                <span class="metadata-value">{{ optional($parcelle->agent)->name ?? 'N/A' }}</span>
                            </div>
                            <div class="metadata-item">
                                <span class="metadata-label">Responsable</span>
                                <span class="metadata-value">{{ optional($parcelle->responsable)->name ?? 'N/A' }}</span>
                            </div>
                            <div class="metadata-item">
                                <span class="metadata-label">Créé par</span>
                                <span class="metadata-value">
                                    {{ optional($parcelle->createdBy)->name ?? 'N/A' }}
                                    @if($parcelle->createdBy)
                                        <span class="role-badge">{{ $parcelle->createdBy->getRoleNames()->first() ?? 'Aucun rôle' }}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="metadata-item">
                                <span class="metadata-label">Date de création</span>
                                <span class="metadata-value">
                                    {{ $parcelle->created_at ? $parcelle->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </span>
                            </div>
                            <div class="metadata-item">
                                <span class="metadata-label">Mis à jour par</span>
                                <span class="metadata-value">{{ optional($parcelle->updatedBy)->name ?? 'N/A' }}</span>
                            </div>
                            <div class="metadata-item">
                                <span class="metadata-label">Validé par</span>
                                <span class="metadata-value">
                                    @if($parcelle->validationLogs->isNotEmpty() && $parcelle->validationLogs->first()->director)
                                        {{ $parcelle->validationLogs->first()->director->name }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="metadata-item">
                                <span class="metadata-label">Date de validation</span>
                                <span class="metadata-value">
                                    @if($parcelle->validationLogs->isNotEmpty())
                                        {{ $parcelle->validationLogs->first()->created_at->format('d/m/Y H:i') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="metadata-item">
                                <span class="metadata-label">Dernière mise à jour</span>
                                <span class="metadata-value">
                                    {{ $parcelle->updated_at ? $parcelle->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour la carte -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Gestion des onglets
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.getAttribute('data-tab');

                // Désactiver tous les onglets
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Activer l'onglet sélectionné
                button.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Initialisation de la carte
        const latitude = {{ $parcelle->latitude ?? 'null' }};
        const longitude = {{ $parcelle->longitude ?? 'null' }};
        const mapElement = document.getElementById('map');

        if (latitude && longitude) {
            const map = L.map('map').setView([latitude, longitude], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);

            // Marqueur personnalisé
            const customIcon = L.divIcon({
                className: 'custom-map-marker',
                html: `
                    <div class="map-marker">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.683 2.282 16.975 16.975 0 001.144.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                `,
                iconSize: [40, 40],
                iconAnchor: [20, 40]
            });

            const marker = L.marker([latitude, longitude], {icon: customIcon}).addTo(map);

            marker.bindPopup(`
                <div class="map-popup">
                    <h3 class="popup-title">Parcelle #{{ $parcelle->numero }}</h3>
                    <p class="popup-text">{{ $parcelle->parcelle }}</p>
                    <p class="popup-text">{{ $parcelle->arrondissement }}</p>
                    <p class="popup-coords">Lat: ${latitude}, Lng: ${longitude}</p>
                </div>
            `).openPopup();
        } else {
            document.getElementById('map-overlay').style.display = 'flex';
        }

        // Animation des cartes au chargement
        document.querySelectorAll('.info-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-in');
        });
    });
</script>

<style>
    /* Variables CSS cohérentes avec la charte existante */
    :root {
        --primary: #1A5F23;
        --primary-light: #2e7d32;
        --primary-dark: #0d4014;
        --secondary: #F9A825;
        --secondary-light: #ffb74d;
        --secondary-dark: #f57c00;
        --accent: #E30613;
        --accent-light: #ef5350;
        --accent-dark: #c62828;
        --neutral: #F5F5F5;
        --neutral-light: #ffffff;
        --neutral-dark: #e0e0e0;
        --text-primary: #333333;
        --text-secondary: #666666;
        --text-light: #ffffff;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
    }

    /* Styles généraux */
    .parcelle-details-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0;
        background: var(--neutral);
        min-height: 100vh;
    }

    /* Hero section */
    .parcelle-hero {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: var(--text-light);
        padding: 2rem 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .parcelle-hero::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%230d4014' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.1;
    }

    .hero-content {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        position: relative;
        z-index: 2;
    }

    @media (min-width: 768px) {
        .hero-content {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .hero-text {
        flex: 1;
    }

    .hero-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .hero-title svg {
        width: 2rem;
        height: 2rem;
        color: var(--secondary);
    }

    .hero-subtitle {
        font-size: 1.125rem;
        margin: 0 0 1rem 0;
        opacity: 0.9;
    }

    /* NOUVEAUX STYLES POUR LES BADGES - REMPLACEMENT DES ANCIENS */
    .hero-badges {
        display: flex;
        gap: 15px;
        margin: 25px 0;
        flex-wrap: wrap;
    }

    .status-badge {
        padding: 12px 20px;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
        border: 2px solid transparent;
    }

    .statut-active {
        background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
        color: white;
        border-color: rgba(255, 255, 255, 0.3);
    }

    .statut-inactif {
        background: linear-gradient(135deg, #9E9E9E 0%, #616161 100%);
        color: white;
        border-color: rgba(255, 255, 255, 0.3);
    }

    .statut-alerte {
        background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
        color: white;
        border-color: rgba(255, 255, 255, 0.3);
    }

    .statut-succes {
        background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
        color: white;
        border-color: rgba(255, 255, 255, 0.3);
    }

    .status-badge:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }
    /* FIN DES NOUVEAUX STYLES POUR LES BADGES */

    .hero-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* Boutons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        border-radius: var(--radius-md);
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
    }

    .btn-icon {
        padding: 0.5rem 1rem;
    }

    .btn-primary {
        background-color: var(--secondary);
        color: var(--text-primary);
    }

    .btn-primary:hover {
        background-color: var(--secondary-light);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-secondary {
        background-color: rgba(255, 255, 255, 0.15);
        color: var(--text-light);
        backdrop-filter: blur(10px);
    }

    .btn-secondary:hover {
        background-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-danger {
        background-color: var(--accent);
        color: var(--text-light);
    }

    .btn-danger:hover {
        background-color: var(--accent-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Navigation par onglets */
    .tabs-navigation {
        background-color: var(--neutral-light);
        border-bottom: 1px solid var(--neutral-dark);
        padding: 0 1.5rem;
    }

    .tabs-container {
        display: flex;
        gap: 0;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .tabs-container::-webkit-scrollbar {
        display: none;
    }

    .tab-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        color: var(--text-secondary);
        font-weight: 500;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .tab-btn svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .tab-btn:hover {
        color: var(--primary);
        background-color: rgba(26, 95, 35, 0.05);
    }

    .tab-btn.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
        background-color: rgba(26, 95, 35, 0.08);
    }

    /* Contenu des onglets */
    .tab-content-container {
        padding: 1.5rem;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Grille de cartes d'information */
    .info-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    /* Cartes */
    .info-card {
        background: var(--neutral-light);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
    }

    .info-card.animate-in {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .info-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-5px);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: var(--text-light);
    }

    .card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: var(--radius-md);
        background: rgba(255, 255, 255, 0.15);
    }

    .card-icon svg {
        width: 1.5rem;
        height: 1.5rem;
    }

    .card-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Grille de détails */
    .detail-grid {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 0.75rem;
        border-radius: var(--radius-sm);
        background: var(--neutral);
        transition: background 0.2s ease;
    }

    .detail-item:hover {
        background: var(--neutral-dark);
    }

    .detail-item.full-width {
        flex-direction: column;
        gap: 0.5rem;
        align-items: stretch;
    }

    .detail-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .detail-value {
        color: var(--text-secondary);
        text-align: right;
        word-break: break-word;
    }

    .detail-item.full-width .detail-value {
        text-align: left;
    }

    /* Indicateurs de statut */
    .status-indicator {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Superficie */
    .superficie-comparison {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: var(--neutral);
        border-radius: var(--radius-md);
    }

    .superficie-item {
        text-align: center;
        flex: 1;
    }

    .superficie-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }

    .superficie-value {
        display: block;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
    }

    .comparison-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
    }

    .comparison-arrow svg {
        width: 1.5rem;
        height: 1.5rem;
    }

    .ecart-superficie {
        text-align: center;
        padding: 1rem;
        background: var(--neutral);
        border-radius: var(--radius-md);
    }

    .ecart-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }

    .ecart-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .ecart-value.positive {
        color: var(--primary);
    }

    .ecart-value.negative {
        color: var(--accent);
    }

    .ecart-value.neutral {
        color: var(--text-secondary);
    }

    .ecart-percentage {
        font-size: 1rem;
        font-weight: 500;
    }

    .progress-bar-container {
        width: 100%;
        height: 0.5rem;
        background: var(--neutral-dark);
        border-radius: 9999px;
        overflow: hidden;
    }

    .progress-bar {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .progress-fill {
        height: 100%;
        border-radius: 9999px;
        transition: width 1s ease-in-out;
    }

    .progress-fill.positive {
        background: var(--primary);
    }

    .progress-fill.negative {
        background: var(--accent);
    }

    /* Localisation */
    .localisation-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }

    @media (max-width: 1024px) {
        .localisation-container {
            grid-template-columns: 1fr;
        }
    }

    .map-card, .location-details-card {
        background: var(--neutral-light);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .coordinates-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .coordinate-item {
        display: flex;
        flex-direction: column;
        padding: 1rem;
        background: var(--neutral);
        border-radius: var(--radius-md);
    }

    .coordinate-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }

    .coordinate-value {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--primary);
        font-family: monospace;
    }

    .map-wrapper {
        position: relative;
        border-radius: var(--radius-md);
        overflow: hidden;
        margin-bottom: 1.5rem;
        height: 400px;
    }

    .map-view {
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .map-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(245, 245, 245, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        border-radius: var(--radius-md);
    }

    .overlay-content {
        text-align: center;
        color: var(--text-secondary);
    }

    .overlay-content svg {
        width: 3rem;
        height: 3rem;
        margin-bottom: 1rem;
        color: var(--text-secondary);
    }

    .map-actions {
        display: flex;
        justify-content: center;
    }

    .location-details-grid {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .location-detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        border-radius: var(--radius-sm);
        background: var(--neutral);
    }

    .location-detail-item.full-width {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .location-detail-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .location-detail-value {
        color: var(--text-secondary);
    }

    /* Métadonnées */
    .metadata-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .metadata-card {
        background: var(--neutral-light);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .metadata-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1rem;
    }

    .metadata-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        border-radius: var(--radius-sm);
        background: var(--neutral);
    }

    .metadata-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .metadata-value {
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .role-badge {
        padding: 0.2rem 0.5rem;
        border-radius: var(--radius-sm);
        background: var(--primary);
        color: var(--text-light);
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Marqueur de carte personnalisé */
    .custom-map-marker {
        background: transparent;
        border: none;
    }

    .map-marker {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50% 50% 50% 0;
        background: var(--accent);
        color: white;
        transform: rotate(-45deg);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    .map-marker svg {
        transform: rotate(45deg);
        width: 20px;
        height: 20px;
    }

    /* Popup de carte */
    .map-popup {
        font-family: inherit;
        padding: 0.5rem;
    }

    .popup-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary);
        margin: 0 0 0.5rem 0;
    }

    .popup-text {
        font-size: 0.875rem;
        margin: 0 0 0.25rem 0;
        color: var(--text-primary);
    }

    .popup-coords {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin: 0.5rem 0 0 0;
        font-family: monospace;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 1.75rem;
        }

        .hero-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .hero-actions {
            width: 100%;
            justify-content: center;
        }

        .info-cards-grid {
            grid-template-columns: 1fr;
        }

        .superficie-comparison {
            flex-direction: column;
            text-align: center;
        }

        .comparison-arrow {
            transform: rotate(90deg);
            margin: 0.5rem 0;
        }

        .coordinates-grid {
            grid-template-columns: 1fr;
        }

        .metadata-grid {
            grid-template-columns: 1fr;
        }

        .tab-btn {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }

        .tab-btn svg {
            width: 1rem;
            height: 1rem;
        }
    }

    @media (max-width: 480px) {
        .parcelle-hero {
            padding: 1.5rem 1rem;
        }

        .tab-content-container {
            padding: 1rem;
        }

        .card-header {
            padding: 1rem;
        }

        .card-body {
            padding: 1rem;
        }

        .hero-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
