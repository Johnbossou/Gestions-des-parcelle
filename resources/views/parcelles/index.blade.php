@extends('layouts.app')
@section('title', 'Tableau de bord')
@section('content')

<!-- Intégration des scripts -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

<div class="dashboard-container">
    <!-- Particules background -->
    <div id="particles-js"></div>

    <!-- En-tête premium -->
    <div class="dashboard-header" data-aos="fade-down">
        <div class="header-content">
            <div class="title-group">
                <div class="title-wrapper">
                    <div class="title-badge">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        <span>Tableau de bord</span>
                    </div>
                    <h1 class="dashboard-title">
                        Gestion des réserves foncières de la commune d'Abomey-Calavi
                    </h1>
                    <p class="dashboard-subtitle">Visualisation et gestion des parcelles cadastrales</p>

                    <!-- Indicateurs rapides -->
                    <div class="quick-stats">
                        <div class="quick-stat">
                            <span class="quick-stat-value">{{ $stats['total'] }}</span>
                            <span class="quick-stat-label">Parcelles totales</span>
                        </div>
                        <div class="quick-stat">
                            <span class="quick-stat-value">{{ $stats['attribuees'] }}</span>
                            <span class="quick-stat-label">Attribuées</span>
                        </div>
                        <div class="quick-stat">
                            <span class="quick-stat-value">{{ $stats['litiges'] }}</span>
                            <span class="quick-stat-label">En litige</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                @can('create-parcelles')
                    <a href="{{ route('parcelles.create') }}" class="action-btn create-btn" aria-label="Créer une nouvelle parcelle">
                        <span class="btn-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 4v16m8-8H4"/>
                            </svg>
                        </span>
                        <span class="btn-text">Nouvelle Parcelle</span>
                        <span class="btn-glow"></span>
                    </a>
                @endcan
                @can('import-parcelles')
                    <a href="{{ route('parcelles.import') }}" class="action-btn import-btn" aria-label="Importer un fichier Excel">
                        <span class="btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 0015.9 6L16 6a5 5 0 011 9.9
                                    M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </span>

                        <span class="btn-text">Importer Excel</span>
                        <span class="btn-glow"></span>
                    </a>
                @endcan

                @can('export-parcels')
                <div class="export-dropdown">
                    <button class="dropdown-toggle action-btn export-btn" aria-expanded="false" aria-label="Exporter les parcelles">
                        <span class="btn-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 15V3m0 12l-4-4m4 4l4-4M2 17l.621 2.485A2 2 0 0 0 4.561 21h14.878a2 2 0 0 0 1.94-1.515L22 17"/>
                            </svg>
                        </span>
                        <span class="btn-text">Exporter</span>
                        <span class="btn-glow"></span>
                        <svg class="chevron" viewBox="0 0 24 24">
                            <path d="M7 10l5 5 5-5"/>
                        </svg>
                    </button>

                    <form action="{{ route('parcelles.export') }}" method="GET" class="dropdown-menu" id="export-form">
                        <input type="hidden" name="arrondissement" value="{{ request('arrondissement') }}">
                        <input type="hidden" name="type_occupation" value="{{ request('type_occupation') }}">
                        <input type="hidden" name="statut_attribution" value="{{ request('statut_attribution') }}">
                        <input type="hidden" name="litige" value="{{ request('litige') }}">
                        <input type="hidden" name="structure" value="{{ request('structure') }}">
                        <input type="hidden" name="ancienne_superficie_min" value="{{ request('ancienne_superficie_min') }}">
                        <input type="hidden" name="ancienne_superficie_max" value="{{ request('ancienne_superficie_max') }}">

                        <button type="submit" name="format" value="excel" class="dropdown-item flex items-center gap-2 px-4 py-2 rounded-md hover:bg-green-100 text-green-700 font-medium transition">
                            <svg viewBox="0 0 24 24" width="18" height="18" class="text-green-600">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                                <path d="M14 2v6h6m-8 10v-4m-2 2h4m-8-2h2v4H8v-4z"/>
                            </svg>
                            Exporter en Excel
                        </button>


                        <button type="submit" name="format" value="pdf" class="dropdown-item">
                            <svg viewBox="0 0 24 24" width="16" height="16">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                                <path d="M14 2v6h6M8 12h1m3 0h1m2-2H8v4h7v-2m0 0h1"/>
                            </svg>
                            PDF
                        </button>

                    </form>
                </div>
                @endcan
            </div>
        </div>
    </div>

    <!-- Cartes de statistiques premium -->
    <div class="stats-grid" data-aos="fade-up">
        <!-- Carte Total Parcelles -->
        <div class="stat-card" data-aos-delay="50">
            <div class="card-inner">
                <div class="card-front">
                    <div class="card-bg"></div>
                    <div class="card-header">
                        <h3>Total des Parcelles</h3>
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M3 6l2-2h14l2 2M3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6M3 6l2-2h14l2-2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-content">
                        <p class="stat-value">{{ $stats['total'] }}</p>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <p class="stat-description">Toutes parcelles confondues</p>
                    </div>
                    <div class="card-sparkle"></div>
                </div>
                <div class="card-back">
                    <div class="mini-chart-container">
                        <canvas id="totalParcellesChart" width="100" height="60"></canvas>
                    </div>
                    <div class="card-trend {{ $stats['evolution_mois']['total'] >= 0 ? '' : 'down' }}">
                        <svg viewBox="0 0 24 24">
                            <path d="{{ $stats['evolution_mois']['total'] >= 0 ? 'M23 6l-9.5 9.5-5-5L1 18' : 'M23 18l-9.5-9.5-5 5L1 6' }}"/>
                        </svg>
                        <span>{{ $stats['evolution_mois']['total'] >= 0 ? '+' : '' }}{{ $stats['evolution_mois']['total'] }}% ce mois-ci</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Parcelles en Litige -->
        <div class="stat-card" data-aos-delay="100">
            <div class="card-inner">
                <div class="card-front">
                    <div class="card-bg"></div>
                    <div class="card-header">
                        <h3>Parcelles en Litige</h3>
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-content">
                        <p class="stat-value">{{ $stats['litiges'] }}</p>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: {{ ($stats['litiges']/$stats['total'])*100 }}%;"></div>
                        </div>
                        <p class="stat-description">{{ round(($stats['litiges']/$stats['total'])*100, 1) }}% du total</p>
                    </div>
                    <div class="card-sparkle"></div>
                </div>
                <div class="card-back">
                    <div class="mini-chart-container">
                        <canvas id="litigesChart" width="100" height="60"></canvas>
                    </div>
                    <div class="card-trend {{ $stats['evolution_mois']['litiges'] >= 0 ? '' : 'down' }}">
                        <svg viewBox="0 0 24 24">
                            <path d="{{ $stats['evolution_mois']['litiges'] >= 0 ? 'M23 6l-9.5 9.5-5-5L1 18' : 'M23 18l-9.5-9.5-5 5L1 6' }}"/>
                        </svg>
                        <span>{{ $stats['evolution_mois']['litiges'] >= 0 ? '+' : '' }}{{ $stats['evolution_mois']['litiges'] }}% ce mois-ci</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Parcelles Attribuées -->
        <div class="stat-card" data-aos-delay="150">
            <div class="card-inner">
                <div class="card-front">
                    <div class="card-bg"></div>
                    <div class="card-header">
                        <h3>Parcelles Attribuées</h3>
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-content">
                        <p class="stat-value">{{ $stats['attribuees'] }}</p>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: {{ ($stats['attribuees']/$stats['total'])*100 }}%;"></div>
                        </div>
                        <p class="stat-description">{{ round(($stats['attribuees']/$stats['total'])*100, 1) }}% du total</p>
                    </div>
                    <div class="card-sparkle"></div>
                </div>
                <div class="card-back">
                    <div class="mini-chart-container">
                        <canvas id="attribueesChart" width="100" height="60"></canvas>
                    </div>
                    <div class="card-trend {{ $stats['evolution_mois']['attribuees'] >= 0 ? '' : 'down' }}">
                        <svg viewBox="0 0 24 24">
                            <path d="{{ $stats['evolution_mois']['attribuees'] >= 0 ? 'M23 6l-9.5 9.5-5-5L1 18' : 'M23 18l-9.5-9.5-5 5L1 6' }}"/>
                        </svg>
                        <span>{{ $stats['evolution_mois']['attribuees'] >= 0 ? '+' : '' }}{{ $stats['evolution_mois']['attribuees'] }}% ce mois-ci</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Types d'Occupation -->
        <div class="stat-card" data-aos-delay="200">
            <div class="card-inner">
                <div class="card-front">
                    <div class="card-bg"></div>
                    <div class="card-header">
                        <h3>Types d'Occupation</h3>
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        </div>
                    </div>
                    <div class="card-content">
                        <p class="stat-value">{{ $stats['autorise'] + $stats['anarchique'] + $stats['libre'] }}</p>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <p class="stat-description">
                            Autorisé: {{ $stats['autorise'] }} | Anarchique: {{ $stats['anarchique'] }} | Libre: {{ $stats['libre'] }}
                        </p>
                    </div>
                    <div class="card-sparkle"></div>
                </div>
                <div class="card-back">
                    <div class="mini-chart-container">
                        <canvas id="typesOccupationChart" width="100" height="60"></canvas>
                    </div>
                    <div class="type-distribution">
                        <div class="type-item">
                            <span class="type-dot autorise"></span>
                            <span>Autorisé: {{ $stats['autorise'] }}</span>
                        </div>
                        <div class="type-item">
                            <span class="type-dot anarchique"></span>
                            <span>Anarchique: {{ $stats['anarchique'] }}</span>
                        </div>
                        <div class="type-item">
                            <span class="type-dot libre"></span>
                            <span>Libre: {{ $stats['libre'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des graphiques avancés -->
    <div class="charts-section" data-aos="fade-up" data-aos-delay="250">
        <div class="section-header">
            <h2>Analytiques des parcelles</h2>
            <p>Visualisation des données et tendances</p>
        </div>
        <div class="chart-row">
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Répartition par type d'occupation</h3>
                    <div class="chart-actions">
                        <button class="chart-action-btn" title="Télécharger le graphique">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 16l4-4m0 0l-4-4 4 4H4"/>
                            </svg>
                        </button>
                        <button class="chart-action-btn" title="Agrandir le graphique">
                            <svg viewBox="0 0 24 24">
                                <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="occupationTypeChart"></canvas>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: rgba(56, 161, 105, 0.8);"></span>
                        <span class="legend-label">Autorisé</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: rgba(227, 6, 19, 0.8);"></span>
                        <span class="legend-label">Anarchique</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: rgba(49, 130, 206, 0.8);"></span>
                        <span class="legend-label">Libre</span>
                    </div>
                </div>
            </div>
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Statut d'attribution</h3>
                    <div class="chart-actions">
                        <button class="chart-action-btn" title="Télécharger le graphique">
                            <svg viewBox="0 0 24 24"><path d="M12 16l4-4m0 0l-4-4m4 4H4"/></svg>
                        </button>
                        <button class="chart-action-btn" title="Agrandir le graphique">
                            <svg viewBox="0 0 24 24">
                                <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="attributionStatusChart"></canvas>
                </div>
                <div class="chart-summary">
                    <div class="summary-item">
                        <span class="summary-value">{{ $stats['attribuees'] }}</span>
                        <span class="summary-label">Parcelles attribuées</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-value">{{ $stats['total'] - $stats['attribuees'] }}</span>
                        <span class="summary-label">Parcelles disponibles</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Carte géographique interactive MISE À JOUR -->
    <div class="map-section" data-aos="fade-up" data-aos-delay="300">
        <div class="section-header">
            <h2>Répartition géographique</h2>
            <p>Visualisation des parcelles par arrondissement</p>
        </div>
        <div class="map-container">
            <div class="map-visual">
                <div id="interactive-map"></div>
                <div class="map-controls">
                    <h3><i class="fas fa-layer-group"></i> Légende</h3>

                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #38A169;"></div>
                        <div class="legend-label">Autorisé</div>
                    </div>

                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #E30613;"></div>
                        <div class="legend-label">Anarchique</div>
                    </div>

                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #3182CE;"></div>
                        <div class="legend-label">Libre</div>
                    </div>

                    <div class="map-actions">
                        <button class="map-action-btn" id="zoom-to-bounds">
                            <i class="fas fa-expand"></i> Voir toutes les parcelles
                        </button>
                        <button class="map-action-btn" id="reset-map">
                            <i class="fas fa-sync-alt"></i> Réinitialiser la vue
                        </button>
                    </div>
                </div>
            </div>
            <div class="map-legend">
                <h4>Répartition par arrondissement</h4>
                <div class="legend-items">
                    @foreach ($stats['arrondissements_data'] as $arrondissement => $count)
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: hsl({{ $loop->index * 30 }}, 70%, 50%);"></span>
                        <span class="legend-label">{{ $arrondissement }}</span>
                        <span class="legend-value">{{ $count }} parcelles</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Section principale premium -->
    <div class="main-panel" data-aos="fade-up" data-aos-delay="350">
        <!-- Barre de contrôle premium -->
        <div class="control-bar">
            <div class="control-left">
                <h2 class="section-title">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 20l-6-6m0 0l6-6m-6 6h18"/></svg>
                    Liste des Parcelles
                </h2>
                <p class="section-subtitle">Gestion complète du cadastre</p>
            </div>
            <div class="control-right">
                <div class="search-box">
                    <input type="text" id="quick-search" placeholder="Rechercher..." aria-label="Rechercher des parcelles" aria-describedby="search-results">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <button id="clear-search" class="clear-search" style="display: none;" aria-label="Effacer la recherche">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="control-actions">
                    <button id="toggle-view" class="view-toggle" title="Changer de vue" aria-label="Passer à la vue cartes" aria-controls="table-view card-view">
                        <svg id="table-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                        <svg id="grid-icon" viewBox="0 0 24 24" style="display:none;" aria-hidden="true">
                            <path d="M4 6h4M4 10h4M4 14h4M4 18h4m4-12h4m-4 4h4m-4 4h4m-4 4h4m4-12h4m-4 4h4m-4 4h4m-4 4h4"/>
                        </svg>
                    </button>
                    <button class="action-btn filter-toggle" id="toggle-filters-main">
                        <svg viewBox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filtres
                    </button>
                </div>
            </div>
        </div>

        <!-- Filtres avancés premium -->
        <div class="filter-section">
            <div class="filter-header">
                <button id="toggle-filters" class="filter-toggle" aria-expanded="false" aria-controls="advanced-filters">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Filtres avancés</span>
                    <span class="filter-indicator"></span>
                </button>
                <div class="filter-counter">
                    <span id="filter-count">{{ $parcelles->total() }}</span> parcelles correspondantes
                </div>
            </div>
            <div id="advanced-filters" class="filter-content">
                <form id="filter-form" class="filter-grid" method="GET" action="{{ route('parcelles.index') }}">
                    <div class="filter-group">
                        <label for="arrondissement">Arrondissement</label>
                        <div class="select-wrapper">
                            <select name="arrondissement" id="arrondissement">
                                <option value="">Tous</option>
                                @foreach ($arrondissements as $arr)
                                    <option value="{{ $arr }}" {{ request('arrondissement') == $arr ? 'selected' : '' }}>{{ $arr }}</option>
                                @endforeach
                            </select>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5"/></svg>
                        </div>
                    </div>
                    <div class="filter-group">
                        <label for="type_occupation">Type d'Occupation</label>
                        <div class="select-wrapper">
                            <select name="type_occupation" id="type_occupation">
                                <option value="">Tous</option>
                                @foreach ($types_occupation as $type)
                                    <option value="{{ $type }}" {{ request('type_occupation') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5"/></svg>
                        </div>
                    </div>

                    <div class="filter-group">
                        <label for="statut_attribution">Statut</label>
                        <div class="select-wrapper">
                            <select name="statut_attribution" id="statut_attribution">
                                <option value="">Tous</option>
                                @foreach ($statuts as $statut)
                                    <option value="{{ $statut }}" {{ request('statut_attribution') == $statut ? 'selected' : '' }}>{{ ucfirst($statut) }}</option>
                                @endforeach
                            </select>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5"/></svg>
                        </div>
                    </div>
                    <div class="filter-group">
                        <label for="litige">Litige</label>
                        <div class="select-wrapper">
                            <select name="litige" id="litige">
                                <option value="">Tous</option>
                                <option value="1" {{ request('litige') === '1' ? 'selected' : '' }}>Oui</option>
                                <option value="0" {{ request('litige') === '0' ? 'selected' : '' }}>Non</option>
                            </select>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5"/></svg>
                        </div>
                    </div>
                    <div class="filter-group">
                        <label for="structure">Structure</label>
                        <input type="text" name="structure" id="structure" value="{{ request('structure') }}" placeholder="Rechercher une structure...">
                    </div>
                    <div class="filter-group">
                        <label for="ancienne_superficie_min">Superficie min (ancienne)</label>
                        <input type="number" step="0.01" name="ancienne_superficie_min" id="ancienne_superficie_min" value="{{ request('ancienne_superficie_min') }}" placeholder="Min">
                    </div>
                    <div class="filter-group">
                        <label for="ancienne_superficie_max">Superficie max (ancienne)</label>
                        <input type="number" step="0.01" name="ancienne_superficie_max" id="ancienne_superficie_max" value="{{ request('ancienne_superficie_max') }}" placeholder="Max">
                    </div>
                </form>
                <div class="filter-actions">
                    <button type="submit" form="filter-form" class="action-btn apply-btn" aria-label="Appliquer les filtres">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 13l4 4L19 7"/></svg>
                        Appliquer
                    </button>
                    <a href="{{ route('parcelles.index') }}" class="action-btn reset-btn" aria-label="Réinitialiser les filtres">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Réinitialiser
                    </a>
                </div>
            </div>
        </div>

        <!-- Message de résultats de recherche -->
        <div id="search-results" class="sr-only" aria-live="polite"></div>

        <!-- Contenu principal -->
        @if ($parcelles->isEmpty())
            <div class="empty-state">
                <div class="empty-content">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M9.172 16.172a4 4 0 015.656 0M9 12h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3>Aucune parcelle trouvée</h3>
                    <p>Modifiez vos filtres ou créez une nouvelle parcelle.</p>
                    @can('create-parcels')
                    <a href="{{ route('parcelles.create') }}" class="action-btn create-btn" aria-label="Créer une nouvelle parcelle">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v16m8-8H4"/></svg>
                        Créer une parcelle
                    </a>
                    @endcan
                </div>
            </div>
        @else
            <!-- Vue tableau premium -->
            <div id="table-view" class="data-view">
                <table>
                    <thead>
                        <tr>
                            <th data-sort="parcelle">
                                <span>Identifiant</span>
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5"/></svg>
                            </th>
                            <th data-sort="arrondissement">
                                <span>Localisation</span>
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5"/></svg>
                            </th>
                            <th data-sort="statut_attribution">
                                <span>Statut</span>
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M10 10l5 5 5-5"/>
                                </svg>
                            </th>
                            <th data-sort="nouvelle_superficie">
                                <span>Superficie</span>
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5"/></svg>
                            </th>
                            <th data-sort="litige">
                                <span>Litige</span>
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5"/></svg>
                            </th>
                            <th data-sort="structure">
                                <span>Structure</span>
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M7 10l5 5 5-5"/>
                                </svg>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="parcelles-table">
                        @foreach ($parcelles as $parcelle)
                        <tr>
                            <td>
                                <div class="cell-content">
                                    <div class="ident-badge">{{ substr($parcelle->parcelle, 0, 3) }}</div>
                                    <div class="cell-text">
                                        <div class="text-primary">{{ $parcelle->parcelle }}</div>
                                        <div class="text-secondary">{{ $parcelle->numero }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-content">
                                    <div class="cell-text">{{ $parcelle->arrondissement }}</div>
                                    @if ($parcelle->latitude && $parcelle->longitude)
                                    <a href="https://www.google.com/maps?q={{ $parcelle->latitude }},{{ $parcelle->longitude }}" target="_blank" class="map-link" title="Voir sur Google Maps" aria-label="Voir la parcelle sur Google Maps">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    </a>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'attribué' => 'status-success',
                                        'non attribué' => 'status-info',
                                        'default' => 'status-neutral'
                                    ];
                                    $color = $statusColors[$parcelle->statut_attribution] ?? $statusColors['default'];
                                @endphp
                                <span class="status-badge {{ $color }}">
                                    {{ ucfirst($parcelle->statut_attribution ?? 'N/A') }}
                                </span>
                            </td>
                            <td>
                                <div class="cell-content">
                                    <span>{{ number_format($parcelle->nouvelle_superficie ?? $parcelle->ancienne_superficie ?? 0, 2) }} m²</span>
                                    @if ($parcelle->ecart_superficie)
                                        <span class="text-secondary">({{ $parcelle->ecart_superficie > 0 ? '+' : '' }}{{ number_format($parcelle->ecart_superficie, 2) }} m²)</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if ($parcelle->litige)
                                    <span class="status-badge status-danger">
                                        <span class="pulse-dot"></span>
                                        Oui
                                    </span>
                                @else
                                    <span class="status-badge status-success">Non</span>
                                @endif
                            </td>
                            <td>
                                <div class="truncate">{{ $parcelle->structure ?? 'Aucune' }}</div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('parcelles.show', $parcelle) }}" class="action-btn view-btn" title="Voir détails" aria-label="Voir les détails de la parcelle">
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    @can('edit-parcelles')
                                    <a href="{{ route('parcelles.edit', $parcelle) }}" class="action-btn edit-btn" title="Modifier" aria-label="Modifier la parcelle">
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    @endcan
                                    @can('delete-parcelles')
                                    <form action="{{ route('parcelles.destroy', $parcelle) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete-btn" title="Supprimer" aria-label="Supprimer la parcelle">
                                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Vue cartes premium -->
            <div id="card-view" class="data-view hidden">
                <div class="cards-grid">
                    @foreach ($parcelles as $parcelle)
                    <div class="data-card">
                        <div class="card-top">
                            <div class="card-badge">{{ substr($parcelle->parcelle, 0, 3) }}</div>
                            <h3>{{ $parcelle->parcelle }}</h3>
                            <p>{{ $parcelle->numero }}</p>
                        </div>
                        <div class="card-middle">
                            <div class="card-row">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M7.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <span>{{ $parcelle->arrondissement }}</span>
                                @if ($parcelle->latitude && $parcelle->longitude)
                                <a href="https://www.google.com/maps?q={{ $parcelle->latitude }},{{ $parcelle->longitude }}" target="_blank" class="map-link" title="Voir sur Google Maps" aria-label="Voir la parcelle sur Google Maps">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                                @endif
                            </div>
                            <div class="card-row">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M3 6l2-2h14l2 2M3 6v14a2 2 0 002 2h14a2 2 0 002-2V6M3 6l2-2h14l2-2"/>
                                </svg>
                                <span>{{ number_format($parcelle->nouvelle_superficie ?? $parcelle->ancienne_superficie ?? 0, 2) }} m²</span>
                            </div>
                            <div class="card-row">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                @php
                                    $statusColors = [
                                        'attribué' => 'text-success',
                                        'non attribué' => 'text-info',
                                        'default' => 'text-neutral'
                                    ];
                                    $color = $statusColors[$parcelle->statut_attribution] ?? $statusColors['default'];
                                @endphp
                                <span class="{{ $color }}">{{ ucfirst($parcelle->statut_attribution ?? 'N/A') }}</span>
                            </div>
                            <div class="card-row">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0"/>
                                </svg>
                                @if ($parcelle->litige)
                                    <span class="text-danger">
                                        <span class="pulse-dot"></span>
                                        En litige
                                    </span>
                                @else
                                    <span class="text-success">Aucun litige</span>
                                @endif
                            </div>
                            <div class="card-row">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1.5m-4 0h4"/>
                                </svg>
                                <span class="truncate">{{ $parcelle->structure ?? 'Aucune structure' }}</span>
                            </div>
                        </div>
                        <div class="card-bottom">
                            <a href="{{ route('parcelles.show', $parcelle) }}" class="card-action view" aria-label="Voir les détails de la parcelle">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Détails
                            </a>

                            @can('edit-parcelles')
                            <a href="{{ route('parcelles.edit', $parcelle) }}" class="card-action edit" aria-label="Modifier la parcelle">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M11 5H1a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Modifier
                            </a>

                            @endcan
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination premium -->
            <div class="pagination-container">
                <div class="pagination-info">
                    Affichage de <span>{{ $parcelles->firstItem() }}</span> à <span>{{ $parcelles->lastItem() }}</span> sur <span>{{ $parcelles->total() }}</span> résultats
                </div>
                <div class="pagination-links">
                    @if ($parcelles->onFirstPage())
                        <span class="pagination-link disabled" aria-disabled="true">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 19l-7-7 7-7"/></svg>
                            Précédent
                        </span>
                    @else
                        <a href="{{ $parcelles->previousPageUrl() }}" class="pagination-link" rel="prev">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M15 19l-7-7 7-7"/>
                            </svg>
                            Précédent
                        </a>

                    @endif

                    @foreach ($parcelles->getUrlRange(1, $parcelles->lastPage()) as $page => $url)
                        @if ($page == $parcelles->currentPage())
                            <span class="pagination-link active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($parcelles->hasMorePages())
                        <a href="{{ $parcelles->nextPageUrl() }}" class="pagination-link" rel="next">
                            Suivant
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <span class="pagination-link disabled" aria-disabled="true">
                            Suivant
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Scripts JavaScript premium -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser AOS
        AOS.init({
            duration: 1000,
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
                opacity: { value: 0.2, random: true },
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


        // Configuration des graphiques
        const occupationTypeCtx = document.getElementById('occupationTypeChart').getContext('2d');
        const attributionStatusCtx = document.getElementById('attributionStatusChart').getContext('2d');

        // Graphique de répartition par type d'occupation
        const occupationTypeChart = new Chart(occupationTypeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Autorisé', 'Anarchique', 'Libre'],
                datasets: [{
                    data: [
                        {{ $stats['autorise'] }},
                        {{ $stats['anarchique'] }},
                        {{ $stats['libre'] }}
                    ],
                    backgroundColor: [
                        'rgba(56, 161, 105, 0.8)', // Vert pour autorisé
                        'rgba(227, 6, 19, 0.8)',   // Rouge pour anarchique
                        'rgba(49, 130, 206, 0.8)'  // Bleu pour libre
                    ],
                    borderColor: [
                        'rgba(56, 161, 105, 1)',
                        'rgba(227, 6, 19, 1)',
                        'rgba(49, 130, 206, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Répartition par type d\'occupation'
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

        // Graphique de statut d'attribution
        const attributionStatusChart = new Chart(attributionStatusCtx, {
            type: 'pie',
            data: {
                labels: ['Attribuées', 'Non attribuées'],
                datasets: [{
                    data: [
                        {{ $stats['attribuees'] }},
                        {{ $stats['total'] - $stats['attribuees'] }}
                    ],
                    backgroundColor: [
                        'rgba(26, 95, 35, 0.8)', // Vert foncé
                        'rgba(227, 6, 19, 0.8)' // Rouge béninois
                    ],
                    borderColor: [
                        'rgba(26, 95, 35, 1)',
                        'rgba(227, 6, 19, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

        // INITIALISATION DE LA CARTE INTERACTIVE
        const map = L.map('interactive-map').setView([6.4485, 2.3554], 13);

        // Ajout des tuiles OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Données des parcelles
        const parcellesData = [
            @foreach ($parcelles as $parcelle)
            @if($parcelle->latitude && $parcelle->longitude)
            {
                id: {{ $parcelle->id }},
                numero: "{{ $parcelle->numero }}",
                parcelle: "{{ $parcelle->parcelle }}",
                latitude: {{ $parcelle->latitude }},
                longitude: {{ $parcelle->longitude }},
                arrondissement: "{{ $parcelle->arrondissement }}",
                statut: "{{ $parcelle->statut_attribution }}",
                type_occupation: "{{ $parcelle->type_occupation }}", // CORRIGÉ: type_terrain → type_occupation
                superficie: {{ $parcelle->nouvelle_superficie ?? $parcelle->ancienne_superficie ?? 0 }},
                litige: {{ $parcelle->litige ? 'true' : 'false' }},
                structure: "{{ $parcelle->structure ?? 'N/A' }}"
            },
            @endif
            @endforeach
        ];

        // Fonction pour déterminer la couleur en fonction du type d'occupation
        function getColorForOccupation(type) {
            switch(type) {
                case 'Autorisé': return '#38A169'; // Vert
                case 'Anarchique': return '#E30613'; // Rouge
                case 'Libre': return '#3182CE'; // Bleu
                default: return '#A0AEC0'; // Gris
            }
        }

        // Fonction pour formater les nombres
        function formatNumber(num) {
            return new Intl.NumberFormat('fr-FR').format(num);
        }

        // Création des marqueurs pour chaque parcelle
        const markers = [];
        let bounds = L.latLngBounds();

        parcellesData.forEach(parcelle => {
            const marker = L.marker([parcelle.latitude, parcelle.longitude], {
                icon: L.divIcon({
                    className: 'custom-marker',
                    html: `<div style="background-color: ${getColorForOccupation(parcelle.type_occupation)};
                            width: 20px;
                            height: 20px;
                            border-radius: 50%;
                            border: 2px solid white;
                            box-shadow: 0 0 10px rgba(0,0,0,0.5);
                            cursor: pointer;"></div>`,
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            });

            // Contenu du popup
            const popupContent = `
                <div class="custom-popup">
                    <div class="popup-header">
                        <div class="popup-title">${parcelle.parcelle}</div>
                        <div class="popup-status status-${parcelle.type_occupation.toLowerCase()}">
                            ${parcelle.type_occupation}
                        </div>
                    </div>
                    <div class="popup-details">
                        <div class="popup-detail">
                            <span class="label">Numéro:</span>
                            <span class="value">${parcelle.numero}</span>
                        </div>
                        <div class="popup-detail">
                            <span class="label">Arrondissement:</span>
                            <span class="value">${parcelle.arrondissement}</span>
                        </div>
                        <div class="popup-detail">
                            <span class="label">Type:</span>
                            <span class="value">${parcelle.type_occupation}</span>
                        </div>
                        <div class="popup-detail">
                            <span class="label">Superficie:</span>
                            <span class="value">${formatNumber(parcelle.superficie)} m²</span>
                        </div>
                        <div class="popup-detail">
                            <span class="label">Structure:</span>
                            <span class="value">${parcelle.structure}</span>
                        </div>
                    </div>
                    <div class="popup-actions">
                        <button class="popup-btn btn-view" onclick="window.location.href='/parcelles/${parcelle.id}'">
                            <i class="fas fa-eye"></i> Voir détails
                        </button>
                        <button class="popup-btn btn-edit" onclick="window.location.href='/parcelles/${parcelle.id}/edit'">
                            <i class="fas fa-edit"></i> Modifier
                        </button>
                    </div>
                </div>
            `;

            // Liaison du popup au marqueur
            marker.bindPopup(popupContent, {
                maxWidth: 300,
                className: 'custom-popup-container'
            });

            // Ajout du marqueur à la carte
            marker.addTo(map);
            markers.push(marker);
            bounds.extend(marker.getLatLng());
        });

        // Ajuster la vue de la carte pour montrer tous les marqueurs
        if (markers.length > 0) {
            map.fitBounds(bounds, { padding: [50, 50] });
        }

        // Gestion des boutons de contrôle de la carte
        document.getElementById('zoom-to-bounds').addEventListener('click', function() {
            if (markers.length > 0) {
                map.fitBounds(bounds, { padding: [50, 50] });
            }
        });

        document.getElementById('reset-map').addEventListener('click', function() {
            map.setView([6.4485, 2.3554], 13);
        });

        // Gestion des filtres avancés
        const toggleFiltersBtn = document.getElementById('toggle-filters');
        const advancedFilters = document.getElementById('advanced-filters');

        if (toggleFiltersBtn && advancedFilters) {
            toggleFiltersBtn.addEventListener('click', function() {
                const expanded = this.getAttribute('aria-expanded') === 'true' || false;
                this.setAttribute('aria-expanded', !expanded);

                if (!expanded) {
                    advancedFilters.style.maxHeight = advancedFilters.scrollHeight + 'px';
                } else {
                    advancedFilters.style.maxHeight = '0';
                }
            });
        }

        // Gestion de la recherche rapide
        const quickSearch = document.getElementById('quick-search');
        const clearSearchBtn = document.getElementById('clear-search');
        const parcellesTable = document.getElementById('parcelles-table');
        const cardsGrid = document.querySelector('.cards-grid');
        const searchResults = document.getElementById('search-results');

        function normalizeString(str) {
            return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
        }

        function updateSearchResults() {
            const searchTerm = normalizeString(quickSearch.value);
            let visibleCount = 0;

            // Filtrer la vue tableau
            if (parcellesTable && !document.getElementById('table-view').classList.contains('hidden')) {
                const rows = parcellesTable.querySelectorAll('tr');
                rows.forEach(row => {
                    const text = normalizeString(row.textContent);
                    const isVisible = searchTerm === '' || text.includes(searchTerm);
                    row.style.display = isVisible ? '' : 'none';
                    if (isVisible) visibleCount++;
                });
            }

            // Filtrer la vue cartes
            if (cardsGrid && !document.getElementById('card-view').classList.contains('hidden')) {
                const cards = cardsGrid.querySelectorAll('.data-card');
                cards.forEach(card => {
                    const text = normalizeString(card.textContent);
                    const isVisible = searchTerm === '' || text.includes(searchTerm);
                    card.style.display = isVisible ? '' : 'none';
                    if (isVisible) visibleCount++;
                });
            }

            // Mettre à jour le message de résultats pour l'accessibilité
            searchResults.textContent = searchTerm === ''
                ? 'Tous les résultats sont affichés.'
                : `${visibleCount} parcelle${visibleCount !== 1 ? 's' : ''} trouvée${visibleCount !== 1 ? 's' : ''} pour "${quickSearch.value}".`;

            // Afficher/masquer le bouton de réinitialisation
            clearSearchBtn.style.display = quickSearch.value ? 'flex' : 'none';
        }

        if (quickSearch && (parcellesTable || cardsGrid)) {
            quickSearch.addEventListener('input', updateSearchResults);
            clearSearchBtn.addEventListener('click', () => {
                quickSearch.value = '';
                clearSearchBtn.style.display = 'none';
                updateSearchResults();
                quickSearch.focus();
            });
        }

        // Gestion du changement de vue
        const toggleViewBtn = document.getElementById('toggle-view');
        const tableView = document.getElementById('table-view');
        const cardView = document.getElementById('card-view');
        const tableIcon = document.getElementById('table-icon');
        const gridIcon = document.getElementById('grid-icon');

        if (toggleViewBtn && tableView && cardView) {
            toggleViewBtn.addEventListener('click', function() {
                const isTableView = !tableView.classList.contains('hidden');

                if (isTableView) {
                    tableView.classList.add('hidden');
                    cardView.classList.remove('hidden');
                    tableIcon.style.display = 'none';
                    gridIcon.style.display = 'block';
                    this.setAttribute('aria-label', 'Passer à la vue tableau');
                } else {
                    tableView.classList.remove('hidden');
                    cardView.classList.add('hidden');
                    tableIcon.style.display = 'block';
                    gridIcon.style.display = 'none';
                    this.setAttribute('aria-label', 'Passer à la vue cartes');
                }

                // Réinitialiser la recherche lors du changement de vue
                if (quickSearch) {
                    quickSearch.value = '';
                    updateSearchResults();
                }
            });
        }

        // Gestion des dropdowns
        const exportDropdown = document.querySelector('.export-dropdown');
        if (exportDropdown) {
            const dropdownToggle = exportDropdown.querySelector('.dropdown-toggle');
            const dropdownMenu = exportDropdown.querySelector('.dropdown-menu');

            dropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const expanded = this.getAttribute('aria-expanded') === 'true' || false;
                this.setAttribute('aria-expanded', !expanded);
                dropdownMenu.classList.toggle('show');
            });

            // Fermer le dropdown en cliquant ailleurs
            document.addEventListener('click', function() {
                dropdownToggle.setAttribute('aria-expanded', 'false');
                dropdownMenu.classList.remove('show');
            });

            // Empêcher la fermeture en cliquant dans le dropdown
            dropdownMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Gestion des formulaires de suppression
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Êtes-vous sûr de vouloir supprimer cette parcelle ? Cette action est irréversible.')) {
                    this.submit();
                }
            });
        });

        // Tri des colonnes
        const sortableHeaders = document.querySelectorAll('th[data-sort]');
        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const sortBy = this.getAttribute('data-sort');
                const currentUrl = new URL(window.location.href);
                const currentSort = currentUrl.searchParams.get('sort');
                const currentOrder = currentUrl.searchParams.get('order');

                let newOrder = 'asc';
                if (currentSort === sortBy && currentOrder === 'asc') {
                    newOrder = 'desc';
                }

                currentUrl.searchParams.set('sort', sortBy);
                currentUrl.searchParams.set('order', newOrder);
                window.location.href = currentUrl.toString();
            });
        });

        // Animation des cartes de statistiques
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.querySelector('.card-inner').style.transform = 'rotateY(180deg)';
            });

            card.addEventListener('mouseleave', function() {
                this.querySelector('.card-inner').style.transform = 'rotateY(0deg)';
            });
        });

        // Effet de scintillement sur les cartes
        const sparkles = document.querySelectorAll('.card-sparkle');
        sparkles.forEach(sparkle => {
            setInterval(() => {
                sparkle.style.opacity = Math.random() > 0.5 ? '1' : '0';
            }, 2000);
        });

        // Animation de fond sur les cartes
        const cardBgs = document.querySelectorAll('.card-bg');
        cardBgs.forEach(bg => {
            bg.addEventListener('mousemove', function(e) {
                const x = e.offsetX;
                const y = e.offsetY;
                this.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(255,255,255,0.1), transparent)`;
            });

            bg.addEventListener('mouseleave', function() {
                this.style.background = '';
            });
        });
    });
</script>

<style>
    /* Variables CSS premium améliorées */
    :root {
        /* Couleurs principales */
        --primary: #1A5F23; /* Vert foncé */
        --primary-light: rgba(26, 95, 35, 0.1);
        --primary-gradient: linear-gradient(135deg, #1A5F23 0%, #2c7744 100%);
        --secondary: #F9A825; /* Jaune doré */
        --secondary-light: #FCD116; /* Jaune clair pour survol */
        --accent: #E30613; /* Rouge béninois */
        --accent-light: rgba(227, 6, 19, 0.1);
        --neutral: #F8FAFC; /* Gris clair plus doux */
        --neutral-dark: #E2E8F0;
        --black: #2D3748; /* Noir plus doux */
        --white: #FFFFFF; /* Blanc */
        --success: #38A169; /* Vert clair */
        --blue: #3182CE; /* Bleu institutionnel plus doux */

        /* Ombres premium améliorées */
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --shadow-xxl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);

        /* Bordures améliorées */
        --radius-sm: 6px;
        --radius-md: 8px;
        --radius-lg: 12px;
        --radius-xl: 16px;
        --radius-xxl: 20px;
        --radius-full: 9999px;

        /* Transitions premium améliorées */
        --transition: all 0.2s ease-in-out;
        --transition-slow: all 0.3s ease-in-out;
        --transition-bounce: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);

        /* Dégradés améliorés */
        --gradient-primary: linear-gradient(135deg, var(--primary) 0%, #2c7744 100%);
        --gradient-success: linear-gradient(135deg, var(--success) 0%, #48BB78 100%);
        --gradient-accent: linear-gradient(135deg, var(--accent) 0%, #FC8181 100%);
        --gradient-secondary: linear-gradient(135deg, var(--secondary) 0%, #F6E05E 100%);

        /* Espacement amélioré */
        --space-xs: 0.25rem;
        --space-sm: 0.5rem;
        --space-md: 1rem;
        --space-lg: 1.5rem;
        --space-xl: 2rem;
        --space-2xl: 3rem;
    }

    /* Styles globaux premium améliorés */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', 'Roboto', Arial, sans-serif;
        background-color: var(--neutral);
        color: var(--black);
        line-height: 1.6;
        overflow-x: hidden;
        font-size: 14px;
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

    /* Conteneur principal premium amélioré */
    .dashboard-container {
        max-width: 1800px;
        margin: 0 auto;
        padding: var(--space-xl);
        background: var(--neutral);
        position: relative;
        min-height: 100vh;
    }

    /* Particules background amélioré */
    #particles-js {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none;
    }

    .dashboard-header, .stats-grid, .charts-section, .map-section, .main-panel {
        position: relative;
        z-index: 1;
    }

    /* En-tête premium amélioré */
    .dashboard-header {
        margin-bottom: var(--space-2xl);
        border-radius: var(--radius-xl);
        background: var(--gradient-primary);
        box-shadow: var(--shadow-xl);
        min-height: 220px;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        transition: var(--transition-slow);
    }

    .dashboard-header:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xxl);
    }
    #interactive-map {
    height: 100%;
    width: 100%;
    z-index: 1;
}

.custom-marker {
    background: transparent;
    border: none;
}

.leaflet-popup-content-wrapper {
    border-radius: 8px;
}

.custom-popup-container .leaflet-popup-content {
    margin: 0;
    width: 100% !important;
}

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        transform: rotate(15deg);
    }


    .header-content {
        position: relative;
        z-index: 2;
        width: 100%;
        padding: var(--space-2xl);
        display: flex;
        flex-direction: column;
        gap: var(--space-lg);
    }

    @media (min-width: 968px) {
        .header-content {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .title-group {
        flex: 1;
    }

    .title-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--space-sm);
        padding: var(--space-sm) var(--space-md);
        border-radius: var(--radius-full);
        background: rgba(255, 255, 255, 0.2);
        color: var(--white);
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: var(--space-md);
        backdrop-filter: blur(10px);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .title-badge svg {
        width: 1rem;
        height: 1rem;
        color: var(--secondary);
    }

    .dashboard-title {
        font-family: 'Inter', 'Roboto', Arial, sans-serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--white);
        margin: 0;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: var(--space-sm);
    }

    .dashboard-subtitle {
        font-size: 1.125rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: var(--space-lg);
        max-width: 600px;
        font-weight: 400;
    }
    .type-dot.autorise {
        background: #38A169; /* Vert */
    }

    .type-dot.anarchique {
        background: #E30613; /* Rouge */
    }

    .type-dot.libere {
        background: #3182CE; /* Bleu pour Libre - NOUVEAU */
    }

    /* Quick stats amélioré */
    .quick-stats {
        display: flex;
        gap: var(--space-lg);
        margin-top: var(--space-lg);
        flex-wrap: wrap;
    }

    .quick-stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: var(--space-md);
        background: rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-lg);
        backdrop-filter: blur(10px);
        min-width: 120px;
        transition: var(--transition);
    }

    .quick-stat:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.15);
    }

    .quick-stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--white);
        margin-bottom: var(--space-xs);
    }

    .quick-stat-label {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .header-actions {
        display: flex;
        gap: var(--space-md);
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    /* Export dropdown premium amélioré */
    .export-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        position: relative;
    }

    .action-btn.import-btn {
        background-color: var(--success);
        color: white;
        border-radius: var(--radius-md);
        padding: var(--space-md) var(--space-lg);
        display: inline-flex;
        align-items: center;
        gap: var(--space-sm);
        position: relative;
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .action-btn.import-btn:hover {
        background-color: #2F855A;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .dropdown-menu {
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: var(--space-xs);
        background: var(--white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-xl);
        display: none;
        z-index: 100;
        min-width: 160px;
        padding: var(--space-sm) 0;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        border: 1px solid var(--neutral-dark);
    }

    .export-dropdown:hover .dropdown-menu,
    .export-dropdown:focus-within .dropdown-menu {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .dropdown-item {
        width: 100%;
        text-align: left;
        padding: var(--m) var(--space-md);
        background: none;
        border: none;
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        font-size: 0.875rem;
        cursor: pointer;
        transition: var(--transition);
        color: var(--black);
    }

    .dropdown-item:hover {
        background: var(--neutral);
        color: var(--primary);
    }

    .dropdown-item svg {
        width: 16px;
        height: 16px;
    }

    .chevron {
        width: 16px;
        height: 16px;
        transition: transform 0.3s ease;
    }

    .export-dropdown:hover .chevron {
        transform: rotate(180deg);
    }

    /* Boutons d'action premium améliorés */
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: var(--space-sm);
        padding: var(--space-md) var(--space-lg);
        border-radius: var(--radius-md);
        font-weight: 500;
        transition: var(--transition);
        position: relative;
        min-width: fit-content;
        overflow: hidden;
        text-align: center;
        border: none;
        justify-content: center;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
        font-size: 0.875rem;
    }

    .action-btn svg {
        width: 1rem;
        height: 1rem;
    }

    .create-btn {
        background: var(--secondary);
        color: var(--black);
    }

    .create-btn:hover {
        background: var(--secondary-light);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .export-btn {
        background: var(--white);
        color: var(--black);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .export-btn:hover {
        background: rgba(255, 255, 255, 0.9);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .apply-btn {
        background: var(--success);
        color: var(--white);
    }

    .apply-btn:hover {
        background: #2F855A;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .reset-btn {
        background: var(--neutral);
        color: var(--black);
        border: 1px solid var(--neutral-dark);
    }

    .reset-btn:hover {
        background: var(--white);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .view-btn {
        background: var(--white);
        color: var(--primary);
    }

    .view-btn:hover {
        background: var(--primary);
        color: var(--white);
    }

    .edit-btn {
        background: var(--white);
        color: var(--secondary);
    }

    .edit-btn:hover {
        background: var(--secondary);
        color: var(--black);
    }

    .delete-btn {
        background: var(--white);
        color: var(--accent);
    }

    .delete-btn:hover {
        background: var(--accent);
        color: var(--white);
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

    /* Grille de statistiques premium améliorée */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--space-lg);
        margin-bottom: var(--space-2xl);
    }

    /* Cartes de statistiques premium avec effet 3D amélioré */
    .stat-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--neutral-dark);
        height: 240px;
        perspective: 1000px;
    }

    .stat-card:hover {
        transform: translateY(-5px) rotateX(2deg);
        box-shadow: var(--shadow-lg);
    }

    .card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.6s;
        transform-style: preserve-3d;
    }

    .card-front, .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        padding: var(--space-lg);
    }

    .card-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.03;
        z-index: 0;
    }

    .card-sparkle {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 1rem;
        height: 1rem;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%231A5F23' d='M12 0l3.09 8.91L24 12l-8.91 3.09L12 24l-3.09-8.91L0 12l8.91-3.09L12 0z'/%3E%3C/svg%3E");
        background-size: contain;
        opacity: 0.5;
        transition: var(--transition);
    }

    .card-back {
        transform: rotateY(180deg);
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--white);
        flex-direction: column;
        gap: var(--space-md);
    }

    .mini-chart-container {
        width: 100%;
        height: 60px;
    }

    .card-trend {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        font-size: 0.875rem;
        color: var(--success);
    }

    .card-trend.down {
        color: var(--accent);
    }


    .card-trend svg {
        width: 1rem;
        height: 1rem;
    }

    .type-distribution {
        display: flex;
        flex-direction: column;
        gap: var(--space-sm);
        width: 100%;
    }

    .type-item {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        font-size: 0.875rem;
    }

    .type-dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-md);
        position: relative;
        z-index: 1;
    }

    .card-header h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--black);
    }

    .card-icon {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-md);
        background: var(--neutral);
        color: var(--primary);
    }

    .card-content {
        display: flex;
        flex-direction: column;
        gap: var(--space-sm);
        position: relative;
        z-index: 1;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--black);
    }

    .stat-progress {
        height: 8px;
        background: var(--neutral);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: var(--radius-full);
        transition: width 1s ease-in-out;
    }

    .stat-card:nth-child(1) .progress-bar {
        background: var(--gradient-primary);
    }

    .stat-card:nth-child(2) .progress-bar {
        background: var(--gradient-accent);
    }

    .stat-card:nth-child(3) .progress-bar {
        background: var(--gradient-success);
    }

    .stat-card:nth-child(4) .progress-bar {
        background: var(--gradient-secondary);
    }

    .stat-description {
        font-size: 0.875rem;
        color: var(--black);
        opacity: 0.7;
    }

    /* Section des graphiques premium améliorée */
    .charts-section {
        margin-bottom: var(--space-2xl);
    }

    .section-header {
        margin-bottom: var(--space-lg);
        text-align: center;
    }

    .section-header h2 {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--black);
        margin-bottom: var(--space-sm);
    }

    .section-header p {
        color: var(--black);
        font-size: 1rem;
        opacity: 0.7;
    }

    .chart-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: var(--space-lg);
    }

    .chart-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        padding: var(--space-lg);
        transition: var(--transition);
        border: 1px solid var(--neutral-dark);
    }

    .chart-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-md);
    }

    .chart-header h1 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--black);
    }


    .chart-actions {
        display: flex;
        gap: var(--space-sm);
    }

    .chart-action-btn {
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-sm);
        background: var(--neutral);
        color: var(--black);
        border: none;
        cursor: pointer;
        transition: var(--transition);
    }

    .chart-action-btn:hover {
        background: var(--primary);
        color: var(--white);
    }

    .chart-container {
        height: 250px;
        position: relative;
    }

    .chart-legend {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-md);
        margin-top: var(--space-md);
        justify-content: center;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }

    .legend-color {
        width: 1rem;
        height: 1rem;
        border-radius: var(--radius-sm);
    }

    .legend-label {
        font-size: 0.875rem;
        color: var(--black);
    }

    .chart-summary {
        display: flex;
        gap: var(--space-lg);
        margin-top: var(--space-md);
        justify-content: center;
    }

    .summary-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }


    .summary-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
    }

    .summary-label {
        font-size: 0.75rem;
        color: var(--black);
        opacity: 0.7;
    }

    /* Section carte géographique améliorée */
    .map-section {
        margin-bottom: var(--space-2xl);
    }

    .map-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: var(--space-lg);
    }

    .map-visual {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--neutral-dark);
    }

    .map-placeholder {
        text-align: center;
        padding: var(--space-2xl);
    }

    .map-placeholder svg {
        width: 3rem;
        height: 3rem;
        color: var(--black);
        margin-bottom: var(--space-md);
        opacity: 0.5;
    }

    .map-placeholder p {
        margin-bottom: var(--space-lg);
        color: var(--black);
        opacity: 0.7;
    }

    .map-activated {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .map-activated svg {
        width: 3rem;
        height: 3rem;
        color: var(--primary);
        margin-bottom: var(--space-md);
    }

    .map-legend {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        padding: var(--space-lg);
        height: fit-content;
        border: 1px solid var(--neutral-dark);
    }

    .map-legend h4 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--black);
        margin-bottom: var(--space-md);
    }

    .legend-items {
        display: flex;
        flex-direction: column;
        gap: var(--space-sm);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: var(--space-md);
        padding: var(--space-sm) 0;
        border-bottom: 1px solid var(--neutral);
    }

    .legend-item:last-child {
        border-bottom: none;
    }

    .legend-color {
        width: 1rem;
        height: 1rem;
        border-radius: var(--radius-sm);
    }

    .legend-label {
        flex: 1;
        font-size: 0.875rem;
        color: var(--black);
    }

    .legend-value {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--primary);
    }

    /* Panneau principal premium amélioré */
    .main-panel {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        border: 1px solid var(--neutral-dark);
    }

    /* Barre de contrôle premium améliorée */
    .control-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: var(--space-lg);
        padding: var(--space-lg) var(--space-xl);
        border-bottom: 1px solid var(--neutral-dark);
        background: var(--white);
    }


    .control-left {
        display: flex;
        flex-direction: column;
        gap: var(--space-xs);
    }

    .control-right {
        display: flex;
        align-items: center;
        gap: var(--space-md);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--black);
    }

    .section-title svg {
        color: var(--primary);
    }

    .section-subtitle {
        font-size: 0.875rem;
        color: var(--black);
        opacity: 0.7;
    }


    /* Barre de recherche premium améliorée */
    .search-box {
        position: relative;
        width: 300px;
    }

    .search-box input {
        width: 100%;
        padding: var(--space-md) var(--space-xl) var(--space-md) var(--space-md);
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral-dark);
        background: var(--white);
        transition: var(--transition);
        font-size: 0.875rem;
        box-shadow: var(--shadow-sm);
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26, 95, 35, 0.1);
    }

    .search-box svg {
        position: absolute;
        right: var(--space-md);
        top: 50%;
        transform: translateY(-50%);
        color: var(--black);
        width: 1.25rem;
        height: 1.25rem;
        opacity: 0.5;
    }

    .clear-search {
        position: absolute;
        right: 2.5rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--black);
        padding: var(--space-xs);
        border-radius: var(--radius-full);
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.5;
    }

    .clear-search:hover {
        background: var(--neutral);
        color: var(--accent);
        opacity: 1;
    }

    .clear-search svg {
        width: 1rem;
        height: 1rem;
    }

    .control-actions {
        display: flex;
        gap: var(--space-sm);
    }

    /* Bouton de changement de vue premium amélioré */
    .view-toggle {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-md);
        background: var(--white);
        border: 1px solid var(--neutral-dark);
        color: var(--black);
        cursor: pointer;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }

    .view-toggle:hover {
        background: var(--neutral);
        color: var(--primary);
        border-color: var(--primary);
    }

    /* Section des filtres premium améliorée */
    .filter-section {
        border-bottom: 1px solid var(--neutral-dark);
    }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-md) var(--space-xl);
        background: var(--white);
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-header:hover {
        background: var(--neutral);
    }

    .filter-toggle {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        background: none;
        border: none;
        color: var(--primary);
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-toggle:hover {
        color: var(--accent);
    }

    .filter-toggle svg {
        width: 1rem;
        height: 1rem;
    }

    .filter-indicator {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background: var(--accent);
        margin-left: var(--space-sm);
        display: inline-block;
    }

    .filter-counter {
        font-size: 0.875rem;
        color: var(--black);
        opacity: 0.7;
    }

    .filter-counter span {
        font-weight: 600;
        color: var(--primary);
    }

    .filter-content {
        padding: 0;
        background: var(--white);
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: var(--space-lg);
        padding: 0 var(--space-xl);
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: var(--space-sm);
    }

    .filter-group label {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--black);
    }

    .filter-group input,
    .filter-group select {
        width: 100%;
        padding: var(--space-md);
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral-dark);
        background: var(--white);
        font-size: 0.875rem;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }

    .filter-group input:focus,
    .filter-group select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26, 95, 35, 0.1);
    }


    .select-wrapper {
        position: relative;
    }

    .select-wrapper svg {
        position: absolute;
        right: var(--space-md);
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: var(--black);
        width: 1rem;
        height: 1rem;
        opacity: 0.5;
    }

    .filter-actions {
        display: flex;
        justify-content: flex-end;
        gap: var(--space-md);
        margin-top: var(--space-lg);
        padding: 0 var(--space-xl) var(--space-xl);
    }

    /* Vue des données premium améliorée */
    .data-view {
        overflow-x: auto;
        position: relative;
        padding: 0;
    }

    .data-view.hidden {
        display: none;
    }

    /* Vue tableau premium améliorée */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        padding: var(--space-md) var(--space-lg);
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--black);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: var(--neutral);
        border-bottom: 1px solid var(--neutral-dark);
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
    }

    th:hover {
        background: rgba(26, 95, 35, 0.1);
    }

    th span {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }

    th svg {
        width: 0.75rem;
        height: 0.75rem;
        opacity: 0.5;
        transition: var(--transition);
    }

    th:hover svg {
        opacity: 1;
    }

    td {
        padding: var(--space-md) var(--space-lg);
        border-bottom: 1px solid var(--neutral);
        background: var(--white);
        transition: var(--transition);
    }

    tr:hover td {
        background: rgba(245, 245, 245, 0.5);
    }

    .cell-content {
        display: flex;
        align-items: center;
        gap: var(--space-md);
    }

    .ident-badge {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-sm);
        background: var(--primary);
        color: var(--white);
        font-weight: 700;
        flex-shrink: 0;
        transition: var(--transition);
        font-size: 0.875rem;
    }

    .cell-content:hover .ident-badge {
        transform: scale(1.1);
    }

    .cell-text {
        display: flex;
        flex-direction: column;
        gap: var(--space-xs);
    }

    .text-primary {
        font-weight: 500;
        color: var(--black);
    }

    .text-secondary {
        font-size: 0.875rem;
        color: var(--black);
        opacity: 0.7;
    }

    .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }

    .map-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: var(--radius-sm);
        background: var(--white);
        color: var(--blue);
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--neutral-dark);
    }

    .map-link:hover {
        background: var(--blue);
        color: var(--white);
        transform: scale(1.1);
    }

    .map-link svg {
        width: 1rem;
        height: 1rem;
    }

    /* Badges de statut premium améliorés */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--space-sm);
        padding: var(--space-xs) var(--space-sm);
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 500;
        font-family: 'Inter', 'Roboto', Arial, sans-serif;
    }

    .status-success {
        background: rgba(56, 161, 105, 0.1);
        color: #2F855A;
        border: 1px solid rgba(56, 161, 105, 0.2);
    }

    .status-info {
        background: rgba(49, 130, 206, 0.1);
        color: #2C5282;
        border: 1px solid rgba(49, 130, 206, 0.2);
    }


    .status-danger {
        background: rgba(227, 6, 19, 0.1);
        color: #C53030;
        border: 1px solid rgba(227, 6, 19, 0.2);
    }

    .status-neutral {
        background: rgba(247, 250, 252, 0.5);
        color: var(--black);
        border: 1px solid var(--neutral);
    }

    /* Point clignotant premium amélioré */
    .pulse-dot {
        display: inline-block;
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background: currentColor;
        animation: pulse 2s infinite;
    }

    /* Boutons d'action premium améliorés */
    .action-buttons {
        display: flex;
        gap: var(--space-sm);
    }

    .action-btn {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-sm);
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--neutral-dark);
    }

    .action-btn svg {
        width: 1rem;
        height: 1rem;
    }

    /* Formulaire de suppression */
    .delete-form {
        display: inline-block;
        margin: 0;
    }

    /* Vue cartes premium améliorée */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: var(--space-lg);
        padding: var(--space-xl);
    }

    .data-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--neutral-dark);
    }

    .data-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .card-top {
        padding: var(--space-lg);
        border-bottom: 1px solid var(--neutral);
        position: relative;
    }

    .card-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-sm);
        background: var(--primary);
        color: var(--white);
        font-weight: 600;
        transition: var(--transition);
        font-size: 0.875rem;
    }

    .data-card:hover .card-badge {
        transform: scale(1.1);
    }

    .card-top h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--black);
        margin-bottom: var(--space-xs);
    }

    .card-top p {
        font-size: 0.875rem;
        color: var(--black);
        opacity: 0.7;
    }

    .card-middle {
        padding: var(--space-lg);
    }

    .card-row {
        display: flex;
        align-items: center;
        gap: var(--space-md);
        padding: var(--space-sm) 0;
        border-bottom: 1px solid var(--neutral);
    }

    .card-row:last-child {
        border-bottom: none;
    }

    .card-row svg {
        width: 1rem;
        height: 1rem;
        color: var(--black);
        flex-shrink: 0;
        opacity: 0.7;
    }

    .text-success {
        color: var(--success);
    }

    .text-info {
        color: var(--blue);
    }

    .text-danger {
        color: var(--accent);
    }

    .text-neutral {
        color: var(--black);
        opacity: 0.7;
    }

    .card-bottom {
        display: flex;
        border-top: 1px solid var(--neutral);
    }

    .card-action {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-sm);
        padding: var(--space-md);
        font-size: 0.875rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .card-action svg {
        width: 1rem;
        height: 1rem;
    }

    .card-action.view {
        background: var(--white);
        color: var(--primary);
    }

    .card-action.view:hover {
        background: var(--primary);
        color: var(--white);
    }

    .card-action.edit {
        background: var(--white);
        color: var(--secondary);
    }

    .card-action.edit:hover {
        background: var(--secondary);
        color: var(--black);
    }

    /* État vide premium amélioré */
    .empty-state {
        padding: var(--space-2xl) var(--space-xl);
        text-align: center;
        background: var(--white);
        border-radius: var(--radius-lg);
    }

    .empty-content {
        max-width: 400px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: var(--space-md);
    }

    .empty-content svg {
        width: 4rem;
        height: 4rem;
        color: var(--black);
        opacity: 0.5;
    }

    .empty-content h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--black);
    }

    .empty-content p {
        font-size: 0.875rem;
        color: var(--black);
        opacity: 0.7;
        margin-bottom: var(--space-lg);
    }

    /* Pagination premium améliorée */
    .pagination-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: var(--space-md);
        padding: var(--space-lg) var(--space-xl);
        border-top: 1px solid var(--neutral-dark);
        background: var(--white);
    }

    .pagination-info {
        font-size: 0.875rem;
        color: var(--black);
        opacity: 0.7;
    }

    .pagination-info span {
        font-weight: 600;
        color: var(--black);
    }

    .pagination-links {
        display: flex;
        gap: var(--s-xs);
    }


    .pagination-link {
        display: flex;
        align-items: center;
        gap: var(--space-xs);
        padding: var(--space-sm) var(--space-md);
        border-radius: var(--radius-md);
        background: var(--white);
        color: var(--black);
        font-size: 0.875rem;
        font-weight: 500;
        transition: var(--transition);
        text-decoration: none;
        border: 1px solid var(--neutral-dark);
    }

    .pagination-link:hover {
        background: var(--neutral);
        color: var(--primary);
        border-color: var(--primary);
    }

    .pagination-link.active {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }
            .map-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: var(--space-lg);
            height: 500px;
        }

        .map-visual {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            border: 1px solid var(--neutral-dark);
            height: 100%;
            position: relative;
        }

        #interactive-map {
            height: 100%;
            width: 100%;
            z-index: 1;
        }

        .map-controls {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: var(--white);
            padding: 12px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            width: 200px;
        }

        .map-controls h3 {
            font-size: 14px;
            margin-bottom: 8px;
            color: var(--primary);
            display: flex;
            align-items: center;
        }

        .map-controls h3 i {
            margin-right: 8px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            margin-right: 8px;
            border: 2px solid var(--white);
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
        }

        .legend-label {
            font-size: 12px;
        }

        .map-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 10px;
        }

        .map-action-btn {
            padding: 6px 10px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            background: var(--primary);
            color: var(--white);
            border: none;
            transition: var(--transition);
        }

        .map-action-btn:hover {
            background: #14451b;
        }

        .map-action-btn i {
            font-size: 12px;
        }

        /* Popup personnalisé */
        .custom-popup {
            padding: 10px;
            min-width: 250px;
        }

        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--neutral-dark);
        }

        .popup-title {
            font-weight: 600;
            color: var(--primary);
            font-size: 16px;
        }

        .popup-status {
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }


        .status-autorise {
            background: rgba(56, 161, 105, 0.2);
            color: #2F855A;
        }

        .status-anarchique {
            background: rgba(227, 6, 19, 0.2);
            color: #C53030;
        }

        .status-libre {
            background: rgba(49, 130, 206, 0.2);
            color: #2C5282;
        }

        .popup-details {
            margin-bottom: 10px;
        }

        .popup-detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .popup-detail .label {
            color: var(--black);
            opacity: 0.7;
        }

        .popup-detail .value {
            font-weight: 500;
        }

        .popup-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 10px;
        }

        .popup-btn {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
        }

        .popup-btn i {
            margin-right: 5px;
            font-size: 12px;
        }

        .btn-view {
            background: var(--primary);
            color: var(--white);
        }

        .btn-edit {
            background: var(--secondary);
            color: var(--black);
        }

        /* Ajustements responsives */
        @media (max-width: 968px) {
            .map-container {
                grid-template-columns: 1fr;
                height: auto;
            }

            .map-controls {
                position: relative;
                top: 0;
                right: 0;
                width: 100%;
                margin-top: 15px;
            }

            #interactive-map {
                height: 400px;
            }
        }

    .pagination-link.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-link svg {
        width: 1rem;
        height: 1rem;
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

    /* Responsive premium amélioré */
    @media (max-width: 1200px) {
        .dashboard-container {
            padding: var(--space-lg);
        }

        .dashboard-title {
            font-size: 2rem;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        .chart-row {
            grid-template-columns: 1fr;
        }

        .map-container {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 968px) {
        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
            justify-content: flex-start;
        }

        .quick-stats {
            flex-wrap: wrap;
        }

        .filter-grid {
            grid-template-columns: 1fr 1fr;
        }

        .cards-grid {
            grid-template-columns: 1fr;
        }

        .search-box {
            width: 100%;
        }

        .control-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .control-right {
            width: 100%;
            margin-top: var(--space-md);
            flex-direction: column;
            align-items: flex-start;
        }

        .control-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }

    @media (max-width: 640px) {
        .dashboard-title {
            font-size: 1.75rem;
        }

        .dashboard-subtitle {
            font-size: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .pagination-container {
            flex-direction: column;
            gap: var(--space-md);
        }

        .filter-actions {
            flex-direction: column;
        }

        .chart-summary {
            flex-direction: column;
            gap: var(--space-md);
        }

        .header-actions {
            gap: var(--space-sm);
        }

        .action-btn {
            padding: var(--space-sm) var(--space-md);
            font-size: 0.8125rem;
        }
    }
</style>

@endsection
