@extends('layouts.app')
@section('title', 'Tableau de bord')
@section('content')

<!-- Intégration des scripts -->
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
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v16m8-8H4"/></svg>
                    </span>
                    <span class="btn-text">Nouvelle Parcelle</span>
                    <span class="btn-glow"></span>
                </a>
                @endcan
                @can('export-parcels')
                <div class="export-dropdown">
                    <button class="dropdown-toggle action-btn export-btn" aria-expanded="false" aria-label="Exporter les parcelles">
                        <span class="btn-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 15V3m0 12l-4-4m4 4l4-4M2 17l.621 2.485A2 2 0 0 0 4.561 21h14.878a2 2 0 0 0 1.94-1.515L22 17"/></svg>
                        </span>
                        <span class="btn-text">Exporter</span>
                        <span class="btn-glow"></span>
                        <svg class="chevron" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5"/></svg>
                    </button>

                    <form action="{{ route('parcelles.export') }}" method="GET" class="dropdown-menu" id="export-form">
                        <input type="hidden" name="arrondissement" value="{{ request('arrondissement') }}">
                        <input type="hidden" name="type_terrain" value="{{ request('type_terrain') }}">
                        <input type="hidden" name="statut_attribution" value="{{ request('statut_attribution') }}">
                        <input type="hidden" name="litige" value="{{ request('litige') }}">
                        <input type="hidden" name="structure" value="{{ request('structure') }}">
                        <input type="hidden" name="ancienne_superficie_min" value="{{ request('ancienne_superficie_min') }}">
                        <input type="hidden" name="ancienne_superficie_max" value="{{ request('ancienne_superficie_max') }}">

                        <button type="submit" name="format" value="excel" class="dropdown-item">
                            <svg viewBox="0 0 24 24" width="16" height="16"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 2v6h6m-8 10v-4m-2 2h4m-8-2h2v4H8v-4z"/></svg>
                            Excel
                        </button>

                        <button type="submit" name="format" value="pdf" class="dropdown-item">
                            <svg viewBox="0 0 24 24" width="16" height="16"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 2v6h6M8 12h1m3 0h1m2-2H8v4h7v-2m0 0h1"/></svg>
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
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6l2-2h14l2 2M3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6M3 6l2 2h14l2-2"/></svg>
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
                    <div class="card-trend">
                        <svg viewBox="0 0 24 24"><path d="M23 6l-9.5 9.5-5-5L1 18"/></svg>
                        <span>+5% ce mois-ci</span>
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
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
                    <div class="card-trend down">
                        <svg viewBox="0 0 24 24"><path d="M23 18l-9.5-9.5-5 5L1 6"/></svg>
                        <span>-2% ce mois-ci</span>
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
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
                    <div class="card-trend">
                        <svg viewBox="0 0 24 24"><path d="M23 6l-9.5 9.5-5-5L1 18"/></svg>
                        <span>+8% ce mois-ci</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Types de Terrain -->
        <div class="stat-card" data-aos-delay="200">
            <div class="card-inner">
                <div class="card-front">
                    <div class="card-bg"></div>
                    <div class="card-header">
                        <h3>Types de Terrain</h3>
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        </div>
                    </div>
                    <div class="card-content">
                        <p class="stat-value">{{ $stats['residentiel'] + $stats['commercial'] + $stats['agricole'] + $stats['institutionnel'] }}</p>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <p class="stat-description">Résidentiel: {{ $stats['residentiel'] }} | Commercial: {{ $stats['commercial'] }}</p>
                    </div>
                    <div class="card-sparkle"></div>
                </div>
                <div class="card-back">
                    <div class="mini-chart-container">
                        <canvas id="typesTerrainChart" width="100" height="60"></canvas>
                    </div>
                    <div class="type-distribution">
                        <div class="type-item">
                            <span class="type-dot residentiel"></span>
                            <span>Résidentiel</span>
                        </div>
                        <div class="type-item">
                            <span class="type-dot commercial"></span>
                            <span>Commercial</span>
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
                    <h3>Répartition par type de terrain</h3>
                    <div class="chart-actions">
                        <button class="chart-action-btn" title="Télécharger le graphique">
                            <svg viewBox="0 0 24 24"><path d="M12 16l4-4m0 0l-4-4m4 4H4"/></svg>
                        </button>
                        <button class="chart-action-btn" title="Agrandir le graphique">
                            <svg viewBox="0 0 24 24"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
                        </button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="terrainTypeChart"></canvas>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: rgba(26, 95, 35, 0.8);"></span>
                        <span class="legend-label">Résidentiel</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: rgba(249, 168, 37, 0.8);"></span>
                        <span class="legend-label">Commercial</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: rgba(227, 6, 19, 0.8);"></span>
                        <span class="legend-label">Agricole</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: rgba(10, 102, 194, 0.8);"></span>
                        <span class="legend-label">Institutionnel</span>
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
                            <svg viewBox="0 0 24 24"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
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

    <!-- Carte géographique interactive -->
    <div class="map-section" data-aos="fade-up" data-aos-delay="300">
        <div class="section-header">
            <h2>Répartition géographique</h2>
            <p>Visualisation des parcelles par arrondissement</p>
        </div>
        <div class="map-container">
            <div class="map-visual">
                <div class="map-placeholder">
                    <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
                    <p>Carte interactive des arrondissements</p>
                    <button class="action-btn view-btn">Activer la carte</button>
                </div>
            </div>
            <div class="map-legend">
                <h4>Légende</h4>
                <div class="legend-items">
                    @foreach ($arrondissements as $index => $arr)
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: hsl({{ $index * 30 }}, 70%, 50%);"></span>
                        <span class="legend-label">{{ $arr }}</span>
                        <span class="legend-value">{{ $index + 12 }} parcelles</span>
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
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <button id="clear-search" class="clear-search" style="display: none;" aria-label="Effacer la recherche">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="control-actions">
                    <button id="toggle-view" class="view-toggle" title="Changer de vue" aria-label="Passer à la vue cartes" aria-controls="table-view card-view">
                        <svg id="table-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                        <svg id="grid-icon" viewBox="0 0 24 24" style="display:none;" aria-hidden="true"><path d="M4 6h4M4 10h4M4 14h4M4 18h4m4-12h4m-4 4h4m-4 4h4m-4 4h4m4-12h4m-4 4h4m-4 4h4m-4 4h4"/></svg>
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
                        <label for="type_terrain">Type de Terrain</label>
                        <div class="select-wrapper">
                            <select name="type_terrain" id="type_terrain">
                                <option value="">Tous</option>
                                @foreach ($types_terrain as $type)
                                    <option value="{{ $type }}" {{ request('type_terrain') == $type ? 'selected' : '' }}>{{ $type }}</option>
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
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
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
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5"/></svg>
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
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5"/></svg>
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
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
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
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <span>{{ $parcelle->arrondissement }}</span>
                                @if ($parcelle->latitude && $parcelle->longitude)
                                <a href="https://www.google.com/maps?q={{ $parcelle->latitude }},{{ $parcelle->longitude }}" target="_blank" class="map-link" title="Voir sur Google Maps" aria-label="Voir la parcelle sur Google Maps">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                                @endif
                            </div>
                            <div class="card-row">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6l2-2h14l2 2M3 6v14a2 2 0 002 2h14a2 2 0 002-2V6M3 6l2 2h14l2-2"/></svg>
                                <span>{{ number_format($parcelle->nouvelle_superficie ?? $parcelle->ancienne_superficie ?? 0, 2) }} m²</span>
                            </div>
                            <div class="card-row">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <span class="truncate">{{ $parcelle->structure ?? 'Aucune structure' }}</span>
                            </div>
                        </div>
                        <div class="card-bottom">
                            <a href="{{ route('parcelles.show', $parcelle) }}" class="card-action view" aria-label="Voir les détails de la parcelle">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Détails
                            </a>
                            @can('edit-parcelles')
                            <a href="{{ route('parcelles.edit', $parcelle) }}" class="card-action edit" aria-label="Modifier la parcelle">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
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
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 19l-7-7 7-7"/></svg>
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
        const terrainTypeCtx = document.getElementById('terrainTypeChart').getContext('2d');
        const attributionStatusCtx = document.getElementById('attributionStatusChart').getContext('2d');

        // Graphique de répartition par type de terrain
        const terrainTypeChart = new Chart(terrainTypeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Résidentiel', 'Commercial', 'Agricole', 'Institutionnel'],
                datasets: [{
                    data: [
                        {{ $stats['residentiel'] }},
                        {{ $stats['commercial'] }},
                        {{ $stats['agricole'] }},
                        {{ $stats['institutionnel'] }}
                    ],
                    backgroundColor: [
                        'rgba(26, 95, 35, 0.8)', // Vert foncé
                        'rgba(249, 168, 37, 0.8)', // Jaune doré
                        'rgba(227, 6, 19, 0.8)', // Rouge béninois
                        'rgba(10, 102, 194, 0.8)' // Bleu institutionnel
                    ],
                    borderColor: [
                        'rgba(26, 95, 35, 1)',
                        'rgba(249, 168, 37, 1)',
                        'rgba(227, 6, 19, 1)',
                        'rgba(10, 102, 194, 1)'
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

        // Bouton d'activation de la carte
        const activateMapBtn = document.querySelector('.map-placeholder .action-btn');
        if (activateMapBtn) {
            activateMapBtn.addEventListener('click', function() {
                this.textContent = 'Carte activée';
                this.classList.add('active');
                const placeholder = this.closest('.map-placeholder');
                placeholder.innerHTML = '<div class="map-activated"><svg viewBox="0 0 24 24"><path d="M9 20l-6-6m0 0l6-6m-6 6h18"/></svg><p>Carte interactive activée</p></div>';
            });
        }
    });
</script>

<style>
    /* Variables CSS premium */
    :root {
        /* Couleurs principales */
        --primary: #1A5F23; /* Vert foncé */
        --primary-light: rgba(26, 95, 35, 0.1);
        --primary-gradient: linear-gradient(135deg, #1A5F23 0%, #2c7744 100%);
        --secondary: #F9A825; /* Jaune doré */
        --secondary-light: #FCD116; /* Jaune clair pour survol */
        --accent: #E30613; /* Rouge béninois */
        --accent-light: rgba(227, 6, 19, 0.1);
        --neutral: #F5F5F5; /* Gris clair */
        --neutral-dark: #E0E0E0;
        --black: #333333; /* Noir */
        --white: #FFFFFF; /* Blanc */
        --success: #4CAF50; /* Vert clair */
        --blue: #0A66C2; /* Bleu institutionnel */

        /* Ombres premium */
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.16);
        --shadow-xl: 0 12px 40px rgba(0, 0, 0, 0.2);
        --shadow-xxl: 0 20px 50px rgba(0, 0, 0, 0.24);

        /* Bordures */
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        --radius-xxl: 24px;
        --radius-full: 9999px;

        /* Transitions premium */
        --transition: all 0.3s ease;
        --transition-slow: all 0.5s ease;
        --transition-bounce: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);

        /* Dégradés */
        --gradient-primary: linear-gradient(135deg, var(--primary) 0%, #2c7744 100%);
        --gradient-success: linear-gradient(135deg, var(--success) 0%, #66bb6a 100%);
        --gradient-accent: linear-gradient(135deg, var(--accent) 0%, #ff5252 100%);
        --gradient-secondary: linear-gradient(135deg, var(--secondary) 0%, #ffd54f 100%);
    }

    /* Styles globaux premium */
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
    .dashboard-container {
        max-width: 1800px;
        margin: 0 auto;
        padding: 2rem;
        background: var(--neutral);
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

    .dashboard-header, .stats-grid, .charts-section, .map-section, .main-panel {
        position: relative;
        z-index: 1;
    }

    /* En-tête premium */
    .dashboard-header {
        margin-bottom: 2.5rem;
        border-radius: var(--radius-xxl);
        background: var(--gradient-primary);
        box-shadow: var(--shadow-xl);
        min-height: 200px;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        transform: rotate(15deg);
    }

    .header-content {
        position: relative;
        z-index: 2;
        width: 100%;
        padding: 2.5rem 3rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    @media (min-width: 968px) {
        .header-content {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .title-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        display: block;
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
        font-family: 'Roboto', Arial, sans-serif;
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--white);
        margin: 0;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .dashboard-subtitle {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
        margin-top: 0.75rem;
        max-width: 600px;
    }

    /* Quick stats */
    .quick-stats {
        display: flex;
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .quick-stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        backdrop-filter: blur(10px);
    }

    .quick-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--white);
    }

    .quick-stat-label {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    /* Export dropdown premium */
    .export-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 8px;
        background: var(--white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-xl);
        display: none;
        z-index: 100;
        min-width: 140px;
        padding: 8px 0;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease;
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
        padding: 10px 16px;
        background: none;
        border: none;
        display: flex;
        align-items: center;
        gap: 10px;
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

    /* Boutons d'action premium */
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
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
        background: #388e3c;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .reset-btn {
        background: var(--neutral);
        color: var(--black);
        border: 1px solid var(--neutral);
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

    /* Grille de statistiques premium */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    /* Cartes de statistiques premium avec effet 3D */
    .stat-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--neutral);
        height: 220px;
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
        padding: 1.5rem;
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
        gap: 1rem;
    }

    .mini-chart-container {
        width: 100%;
        height: 60px;
    }

    .card-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
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
        gap: 0.5rem;
        width: 100%;
    }

    .type-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .type-dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
    }

    .type-dot.residentiel {
        background: var(--primary);
    }

    .type-dot.commercial {
        background: var(--secondary);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
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
        gap: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .stat-value {
        font-size: 2.25rem;
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
    }

    /* Section des graphiques premium */
    .charts-section {
        margin-bottom: 2.5rem;
    }

    .section-header {
        margin-bottom: 1.5rem;
    }

    .section-header h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 0.5rem;
    }

    .section-header p {
        color: var(--black);
        font-size: 0.875rem;
    }

    .chart-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
    }

    .chart-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        padding: 1.5rem;
        transition: var(--transition);
    }

    .chart-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .chart-header h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--black);
    }

    .chart-actions {
        display: flex;
        gap: 0.5rem;
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
        gap: 1rem;
        margin-top: 1rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
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
        gap: 1.5rem;
        margin-top: 1rem;
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
    }

    /* Section carte géographique */
    .map-section {
        margin-bottom: 2.5rem;
    }

    .map-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }

    .map-visual {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .map-placeholder {
        text-align: center;
        padding: 2rem;
    }

    .map-placeholder svg {
        width: 3rem;
        height: 3rem;
        color: var(--black);
        margin-bottom: 1rem;
    }

    .map-placeholder p {
        margin-bottom: 1.5rem;
        color: var(--black);
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
        margin-bottom: 1rem;
    }

    .map-legend {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 1.5rem;
        height: fit-content;
    }

    .map-legend h4 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 1rem;
    }

    .legend-items {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
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

    /* Panneau principal premium */
    .main-panel {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    /* Barre de contrôle premium */
    .control-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--neutral);
        background: var(--white);
    }

    .control-left {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .control-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
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
    }

    /* Barre de recherche premium */
    .search-box {
        position: relative;
        width: 300px;
    }

    .search-box input {
        width: 100%;
        padding: 0.75rem 3rem 0.75rem 1rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral);
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
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--black);
        width: 1.25rem;
        height: 1.25rem;
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
        padding: 0.25rem;
        border-radius: var(--radius-full);
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .clear-search:hover {
        background: var(--neutral);
        color: var(--accent);
    }

    .clear-search svg {
        width: 1rem;
        height: 1rem;
    }

    .control-actions {
        display: flex;
        gap: 0.5rem;
    }

    /* Bouton de changement de vue premium */
    .view-toggle {
        width: 3rem;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-md);
        background: var(--white);
        border: 1px solid var(--neutral);
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

    /* Section des filtres premium */
    .filter-section {
        border-bottom: 1px solid var(--neutral);
    }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 2rem;
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
        gap: 0.5rem;
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
        margin-left: 0.5rem;
        display: inline-block;
    }

    .filter-counter {
        font-size: 0.875rem;
        color: var(--black);
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
        gap: 1.5rem;
        padding: 0 2rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--black);
    }

    .filter-group input,
    .filter-group select {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral);
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
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: var(--black);
        width: 1rem;
        height: 1rem;
    }

    .filter-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 1.5rem;
        padding: 0 2rem 2rem;
    }

    /* Vue des données premium */
    .data-view {
        overflow-x: auto;
        position: relative;
        padding: 0;
    }

    .data-view.hidden {
        display: none;
    }

    /* Vue tableau premium */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        padding: 1.25rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--black);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: var(--neutral);
        border-bottom: 1px solid var(--neutral);
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
        gap: 0.5rem;
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
        padding: 1.25rem 1.5rem;
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
        gap: 0.75rem;
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
        font-weight: 600;
        flex-shrink: 0;
        transition: var(--transition);
    }

    .cell-content:hover .ident-badge {
        transform: scale(1.1);
    }

    .cell-text {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .text-primary {
        font-weight: 500;
        color: var(--black);
    }

    .text-secondary {
        font-size: 0.875rem;
        color: var(--black);
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

    /* Badges de statut premium */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        font-weight: 500;
        font-family: 'Roboto', Arial, sans-serif;
    }

    .status-success {
        background: rgba(76, 175, 80, 0.1);
        color: #2e7d32;
        border: 1px solid rgba(76, 175, 80, 0.2);
    }

    .status-info {
        background: rgba(10, 102, 194, 0.1);
        color: #0d47a1;
        border: 1px solid rgba(10, 102, 194, 0.2);
    }

    .status-danger {
        background: rgba(227, 6, 19, 0.1);
        color: #c62828;
        border: 1px solid rgba(227, 6, 19, 0.2);
    }

    .status-neutral {
        background: rgba(245, 245, 245, 0.5);
        color: var(--black);
        border: 1px solid var(--neutral);
    }

    /* Point clignotant premium */
    .pulse-dot {
        display: inline-block;
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background: currentColor;
        animation: pulse 2s infinite;
    }

    /* Boutons d'action premium */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
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

    /* Vue cartes premium */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
        padding: 2rem;
    }

    .data-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--neutral);
    }

    .data-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .card-top {
        padding: 1.5rem;
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
    }

    .data-card:hover .card-badge {
        transform: scale(1.1);
    }

    .card-top h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 0.25rem;
    }

    .card-top p {
        font-size: 0.875rem;
        color: var(--black);
    }

    .card-middle {
        padding: 1.5rem;
    }

    .card-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0;
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
        gap: 0.5rem;
        padding: 1rem;
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

    /* État vide premium */
    .empty-state {
        padding: 4rem 2rem;
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
        gap: 1rem;
    }

    .empty-content svg {
        width: 4rem;
        height: 4rem;
        color: var(--black);
    }

    .empty-content h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--black);
    }

    .empty-content p {
        font-size: 0.875rem;
        color: var(--black);
        margin-bottom: 1.5rem;
    }

    /* Pagination premium */
    .pagination-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--neutral);
        background: var(--white);
    }

    .pagination-info {
        font-size: 0.875rem;
        color: var(--black);
    }

    .pagination-info span {
        font-weight: 600;
        color: var(--black);
    }

    .pagination-links {
        display: flex;
        gap: 0.5rem;
    }

    .pagination-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        border-radius: var(--radius-md);
        background: var(--white);
        color: var(--black);
        font-size: 0.875rem;
        font-weight: 500;
        transition: var(--transition);
        text-decoration: none;
        border: 1px solid var(--neutral);
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

    /* Responsive premium */
    @media (max-width: 1200px) {
        .dashboard-container {
            padding: 1.5rem;
        }

        .dashboard-title {
            font-size: 1.75rem;
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
            margin-top: 1rem;
        }
    }

    @media (max-width: 640px) {
        .dashboard-title {
            font-size: 1.5rem;
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
        }

        .filter-actions {
            flex-direction: column;
        }

        .chart-summary {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
@endsection
