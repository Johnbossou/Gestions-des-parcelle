@extends('layouts.app')
@section('title', 'Tableau de bord')
@section('content')

<!-- Intégration des scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="dashboard-container">
    <!-- En-tête amélioré -->
    <div class="dashboard-header" data-aos="fade-down">
        <div class="header-content">
            <div class="title-group">
                <div class="title-wrapper">
                    <div class="title-badge">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        <span>Tableau de bord</span>
                    </div>
                    <h1 class="dashboard-title">
                        Gestion des réserves de l'État
                    </h1>
                    <p class="dashboard-subtitle">Visualisation et gestion des parcelles cadastrales</p>
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

    <!-- Cartes de statistiques -->
    <div class="stats-grid" data-aos="fade-up">
        <!-- Carte Total Parcelles -->
        <div class="stat-card" data-aos-delay="50">
            <div class="card-inner">
                <div class="card-front">
                    <div class="card-header">
                        <h3>Total Parcelles</h3>
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
                </div>
            </div>
        </div>

        <!-- Carte Parcelles en Litige -->
        <div class="stat-card" data-aos-delay="100">
            <div class="card-inner">
                <div class="card-front">
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
                </div>
            </div>
        </div>

        <!-- Carte Parcelles Attribuées -->
        <div class="stat-card" data-aos-delay="150">
            <div class="card-inner">
                <div class="card-front">
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
                </div>
            </div>
        </div>

        <!-- Carte Types de Terrain -->
        <div class="stat-card" data-aos-delay="200">
            <div class="card-inner">
                <div class="card-front">
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
                </div>
            </div>
        </div>
    </div>

    <!-- Section principale -->
    <div class="main-panel" data-aos="fade-up" data-aos-delay="250">
        <!-- Barre de contrôle -->
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
                <button id="toggle-view" class="view-toggle" title="Changer de vue" aria-label="Passer à la vue cartes" aria-controls="table-view card-view">
                    <svg id="table-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                    <svg id="grid-icon" viewBox="0 0 24 24" style="display:none;" aria-hidden="true"><path d="M4 6h4M4 10h4M4 14h4M4 18h4m4-12h4m-4 4h4m-4 4h4m-4 4h4m4-12h4m-4 4h4m-4 4h4m-4 4h4"/></svg>
                </button>
            </div>
        </div>

        <!-- Filtres avancés -->
        <div class="filter-section">
            <div class="filter-header">
                <button id="toggle-filters" class="filter-toggle" aria-expanded="false" aria-controls="advanced-filters">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Filtres avancés</span>
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
            <!-- Vue tableau -->
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

            <!-- Vue cartes -->
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

            <!-- Pagination -->
            <div class="pagination-container">
                <div class="pagination-info">
                    Affichage de <span>{{ $parcelles->firstItem() }}</span> à <span>{{ $parcelles->lastItem() }}</span> sur <span>{{ $parcelles->total() }}</span> résultats
                </div>
                <div class="pagination-links">
                    @if ($parcelles->onFirstPage())
                        <span class="pagination-link disabled" aria-disabled="true">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 19l-7-7 7-7"/></svg>
                        </span>
                    @else
                        <a href="{{ $parcelles->previousPageUrl() }}" class="pagination-link" aria-label="Page précédente">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 19l-7-7 7-7"/></svg>
                        </a>
                    @endif

                    @foreach ($parcelles->getUrlRange(max(1, $parcelles->currentPage() - 2), min($parcelles->lastPage(), $parcelles->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" class="pagination-link {{ $page == $parcelles->currentPage() ? 'active' : '' }}" aria-current="{{ $page == $parcelles->currentPage() ? 'page' : 'false' }}">{{ $page }}</a>
                    @endforeach

                    @if ($parcelles->hasMorePages())
                        <a href="{{ $parcelles->nextPageUrl() }}" class="pagination-link" aria-label="Page suivante">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <span class="pagination-link disabled" aria-disabled="true">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

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
        --blue: #0A66C2; /* Bleu institutionnel */

        /* Ombres */
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);

        /* Bordures */
        --radius-sm: 4px;
        --radius-md: 8px;
        --radius-lg: 12px;
        --radius-full: 9999px;

        /* Transitions */
        --transition: all 0.3s ease;
        --transition-slow: all 0.4s ease;
    }

    /* Styles globaux */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto', Arial, sans-serif;
        background-color: var(--neutral);
        color: var(--black);
        line-height: 1.5;
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

    /* Conteneur principal */
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
        background: var(--neutral);
    }

    /* En-tête */
    .dashboard-header {
        margin-bottom: 2rem;
        border-radius: var(--radius-md);
        background: var(--primary);
        box-shadow: var(--shadow-md);
        min-height: 160px;
        display: flex;
        align-items: center;
    }

    .header-content {
        position: relative;
        z-index: 1;
        width: 100%;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    @media (min-width: 768px) {
        .header-content {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
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
    }

    .export-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .title-badge svg {
        width: 1rem;
        height: 1rem;
        color: var(--secondary);
    }

    .dashboard-title {
        font-family: 'Roboto', Arial, sans-serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--white);
        margin: 0;
    }

    .dashboard-subtitle {
        font-size: 1rem;
        color: var(--neutral);
        margin-top: 0.5rem;
        max-width: 600px;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .export-dropdown {
    position: relative;
    display: block; /* Mieux que inline-block pour éviter les écarts de rendu */
    width: fit-content; /* Empêche que le conteneur prenne toute la largeur */
    margin-left: 30 px; /* Assure qu'il n'y ait pas de marge indésirable */
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
        margin-top: 4px;
        background: white;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        display: none;
        z-index: 10;
        min-width: 120px;
        padding: 4px 0;
    }

    .export-dropdown:hover .dropdown-menu,
    .export-dropdown:focus-within .dropdown-menu {
        display: block;
    }

    .dropdown-item {
        width: 100%;
        text-align: left;
        padding: 8px 12px;
        background: none;
        border: none;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.875rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .dropdown-item:hover {
        background: var(--neutral);
    }

    .dropdown-item svg {
        width: 16px;
        height: 16px;
    }

    .chevron {
        width: 16px;
        height: 16px;
        transition: transform 0.2s;
    }

    .export-dropdown:hover .chevron {
        transform: rotate(180deg);
    }

    /* Boutons d'action */
    .action-btn {
        display: inline-flex;
        display: block;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
        border-radius: var(--radius);
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
        display: block;
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
        border: 1px solid var(--neutral);
    }

    .export-btn:hover {
        background: var(--neutral);
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

    /* Style pour le menu déroulant d'exportation */
    .select-wrapper {
        position: relative;
    }

    .select-wrapper select {
        padding: 0.5rem 2rem 0.5rem 1rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral);
        background: var(--white);
        font-size: 0.875rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .select-wrapper select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26, 95, 35, 0.1);
    }

    .select-wrapper svg {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--black);
        width: 1rem;
        height: 1rem;
        pointer-events: none;
    }

    /* Grille de statistiques */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Cartes de statistiques */
    .stat-card {
        background: var(--white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--neutral);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .card-inner {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
    }

    .card-front {
        background: var(--white);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .card-header h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--black);
    }

    .card-icon {
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-sm);
        background: var(--neutral);
        color: var(--primary);
    }

    .card-content {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--black);
    }

    .stat-progress {
        height: 6px;
        background: var(--neutral);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: var(--radius-full);
    }

    .stat-card:nth-child(1) .progress-bar {
        background: var(--primary);
    }

    .stat-card:nth-child(2) .progress-bar {
        background: var(--accent);
    }

    .stat-card:nth-child(3) .progress-bar {
        background: var(--success);
    }

    .stat-card:nth-child(4) .progress-bar {
        background: var(--blue);
    }

    .stat-description {
        font-size: 0.875rem;
        color: var(--black);
    }

    /* Panneau principal */
    .main-panel {
        background: var(--white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    /* Barre de contrôle */
    .control-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        border-bottom: 1px solid var(--neutral);
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
        font-size: 1.25rem;
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

    /* Barre de recherche */
    .search-box {
        position: relative;
        width: 250px;
    }

    .search-box input {
        width: 100%;
        padding: 0.5rem 2.5rem 0.5rem 2.5rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral);
        background: var(--white);
        transition: var(--transition);
        font-size: 0.875rem;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26, 95, 35, 0.1);
    }

    .search-box svg {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--black);
        width: 1rem;
        height: 1rem;
    }

    .clear-search {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--black);
        padding: 0.25rem;
        border-radius: var(--radius-full);
        transition: var(--transition);
    }

    .clear-search:hover {
        background: var(--neutral);
        color: var(--accent);
    }

    .clear-search svg {
        width: 1rem;
        height: 1rem;
    }

    /* Bouton de changement de vue */
    .view-toggle {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-md);
        background: var(--white);
        border: 1px solid var(--neutral);
        color: var(--black);
        cursor: pointer;
        transition: var(--transition);
    }

    .view-toggle:hover {
        background: var(--neutral);
        color: var(--primary);
    }

    /* Section des filtres */
    .filter-section {
        border-bottom: 1px solid var(--neutral);
    }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
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
        color: var(--success);
    }

    .filter-toggle svg {
        width: 1rem;
        height: 1rem;
    }

    .filter-counter {
        font-size: 0.875rem;
        color: var(--black);
    }

    .filter-counter span {
        font-weight: 600;
        color: var(--black);
    }

    .filter-content {
        padding: 1.5rem;
        background: var(--white);
        display: none;
    }

    .filter-content[style*="block"] {
        display: grid;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
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
        padding: 0.5rem 1rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral);
        background: var(--white);
        font-size: 0.875rem;
        transition: var(--transition);
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
    }

    /* Vue des données */
    .data-view {
        overflow-x: auto;
        position: relative;
    }

    .data-view.hidden {
        display: none;
    }

    /* Vue tableau */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        padding: 1rem;
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
    }

    th:hover {
        background: var(--white);
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
        padding: 1rem;
        border-bottom: 1px solid var(--neutral);
        background: var(--white);
        transition: var(--transition);
    }

    tr:hover td {
        background: var(--neutral);
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
        width: 1.5rem;
        height: 1.5rem;
        border-radius: var(--radius-sm);
        background: var(--white);
        color: var(--blue);
        transition: var(--transition);
    }

    .map-link:hover {
        background: var(--blue);
        color: var(--white);
    }

    .map-link svg {
        width: 0.75rem;
        height: 0.75rem;
    }

    /* Badges de statut */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        font-weight: 500;
        font-family: 'Roboto', Arial, sans-serif;
    }

    .status-success {
        background: var(--success);
        color: var(--white);
    }

    .status-info {
        background: var(--blue);
        color: var(--white);
    }

    .status-danger {
        background: var(--accent);
        color: var(--white);
    }

    .status-neutral {
        background: var(--neutral);
        color: var(--black);
        border: 1px solid var(--neutral);
    }

    /* Point clignotant */
    .pulse-dot {
        display: inline-block;
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background: var(--white);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
        }
        70% {
            transform: scale(1);
            box-shadow: 0 0 0 0.5rem rgba(255, 255, 255, 0);
        }
        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
        }
    }

    /* Boutons d'action */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-sm);
        transition: var(--transition);
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

    /* Vue cartes */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .data-card {
        background: var(--white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--neutral);
    }

    .data-card:hover {
        transform: translateY(-4px);
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
        padding: 1rem;
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
        padding: 0.75rem;
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

    /* État vide */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        background: var(--white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
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
        width: 3rem;
        height: 3rem;
        color: var(--black);
    }

    .empty-content h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--black);
    }

    .empty-content p {
        font-size: 0.875rem;
        color: var(--black);
        margin-bottom: 1rem;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        border-top: 1px solid var(--neutral);
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
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-full);
        background: var(--white);
        color: var(--black);
        font-size: 0.875rem;
        font-weight: 500;
        transition: var(--transition);
        text-decoration: none;
    }

    .pagination-link:hover {
        background: var(--secondary);
        color: var(--black);
    }

    .pagination-link.active {
        background: var(--primary);
        color: var(--white);
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

    /* Responsive */
    @media (max-width: 1024px) {
        .dashboard-container {
            padding: 1.5rem 1rem;
        }

        .dashboard-title {
            font-size: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .filter-grid {
            grid-template-columns: 1fr;
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

    @media (max-width: 480px) {
        .dashboard-title {
            font-size: 1.25rem;
        }

        .dashboard-subtitle {
            font-size: 0.875rem;
        }

        .pagination-container {
            flex-direction: column;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser AOS
        AOS.init({
            duration: 600,
            easing: 'ease-in-out',
            once: true
        });

        // Toggle des filtres avancés
        const toggleFilters = document.getElementById('toggle-filters');
        const advancedFilters = document.getElementById('advanced-filters');

        if (toggleFilters && advancedFilters) {
            toggleFilters.addEventListener('click', () => {
                const isExpanded = advancedFilters.style.display === 'block';
                advancedFilters.style.display = isExpanded ? 'none' : 'block';
                toggleFilters.setAttribute('aria-expanded', !isExpanded);
            });
        }

        // Toggle entre vue tableau et vue cartes
        const toggleView = document.getElementById('toggle-view');
        const tableView = document.getElementById('table-view');
        const cardView = document.getElementById('card-view');
        const tableIcon = document.getElementById('table-icon');
        const gridIcon = document.getElementById('grid-icon');

        if (toggleView && tableView && cardView) {
            toggleView.addEventListener('click', () => {
                const isTableView = tableView.classList.contains('hidden');
                tableView.classList.toggle('hidden', !isTableView);
                cardView.classList.toggle('hidden', isTableView);
                tableIcon.style.display = isTableView ? 'block' : 'none';
                gridIcon.style.display = isTableView ? 'none' : 'block';
                toggleView.setAttribute('aria-label', isTableView ? 'Passer à la vue cartes' : 'Passer à la vue tableau');
                // Réinitialiser la recherche lors du changement de vue
                quickSearch.value = '';
                clearSearch.style.display = 'none';
                updateSearchResults();
            });
        }

        // Recherche rapide
        const quickSearch = document.getElementById('quick-search');
        const clearSearch = document.getElementById('clear-search');
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
            if (parcellesTable && !tableView.classList.contains('hidden')) {
                const rows = parcellesTable.querySelectorAll('tr');
                rows.forEach(row => {
                    const text = normalizeString(row.textContent);
                    const isVisible = searchTerm === '' || text.includes(searchTerm);
                    row.style.display = isVisible ? '' : 'none';
                    if (isVisible) visibleCount++;
                });
            }

            // Filtrer la vue cartes
            if (cardsGrid && !cardView.classList.contains('hidden')) {
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
            clearSearch.style.display = quickSearch.value ? 'block' : 'none';
        }

        if (quickSearch && (parcellesTable || cardsGrid)) {
            quickSearch.addEventListener('input', updateSearchResults);
            clearSearch.addEventListener('click', () => {
                quickSearch.value = '';
                clearSearch.style.display = 'none';
                updateSearchResults();
                quickSearch.focus();
            });
        }

        // Gestion des filtres avancés
        const form = document.getElementById('filter-form');
        const filterCount = document.getElementById('filter-count');

        if (form && filterCount) {
            form.addEventListener('submit', (e) => {
                // Simulation du compteur (remplacer par logique AJAX réelle si nécessaire)
                filterCount.textContent = Math.floor(Math.random() * 100);
            });
        }

        // Confirmation de suppression
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Confirmer la suppression de cette parcelle ?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>

@endsection
