@extends('layouts.app')
@section('title', 'Modifier la parcelle')
@section('content')
<div class="content-container">
    <!-- En-tête premium -->
    <div class="premium-header">
        <div class="header-content">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div class="header-text">
                <h1 class="premium-title">Modifier la parcelle #{{ $parcelle->numero }}</h1>
                <p class="premium-subtitle">Mettez à jour les informations de cette parcelle</p>
            </div>
        </div>
        <div class="header-badge">
            <span class="badge-version">Édition Premium</span>
        </div>
    </div>

    <div class="premium-form-container">
        <!-- Navigation latérale élégante -->
        <div class="premium-navigation">
            <div class="nav-header">
                <h3>Sections</h3>
                <div class="nav-progress">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 20%"></div>
                    </div>
                    <span>1/5</span>
                </div>
            </div>
            <ul class="premium-nav-items">
                <li class="premium-nav-item active" data-section="informations">
                    <div class="nav-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="nav-text">
                        <span class="nav-title">Informations</span>
                        <span class="nav-desc">Données principales</span>
                    </div>
                    <div class="nav-indicator"></div>
                </li>
                <li class="premium-nav-item" data-section="superficie">
                    <div class="nav-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                        </svg>
                    </div>
                    <div class="nav-text">
                        <span class="nav-title">Superficie</span>
                        <span class="nav-desc">Dimensions et motifs</span>
                    </div>
                    <div class="nav-indicator"></div>
                </li>
                <li class="premium-nav-item" data-section="occupation">
                    <div class="nav-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="nav-text">
                        <span class="nav-title">Occupation</span>
                        <span class="nav-desc">Type et autorisations</span>
                    </div>
                    <div class="nav-indicator"></div>
                </li>
                <li class="premium-nav-item" data-section="statut">
                    <div class="nav-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="nav-text">
                        <span class="nav-title">Statut</span>
                        <span class="nav-desc">Attribution et litiges</span>
                    </div>
                    <div class="nav-indicator"></div>
                </li>
                <li class="premium-nav-item" data-section="coordonnees">
                    <div class="nav-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="nav-text">
                        <span class="nav-title">Coordonnées</span>
                        <span class="nav-desc">Localisation précise</span>
                    </div>
                    <div class="nav-indicator"></div>
                </li>
            </ul>
        </div>

        <!-- Contenu principal du formulaire -->
        <div class="premium-form-main">
            <form action="{{ route('parcelles.update', $parcelle) }}" method="POST" class="premium-form" id="parcelleForm">
                @csrf
                @method('PUT')

                <!-- Section Informations de base -->
                <div class="form-section active" id="informations-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="section-title">
                            <h2>Informations de base</h2>
                            <p>Données fondamentales de la parcelle</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="input-group">
                            <label for="numero" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                    </svg>
                                </span>
                                Numéro de parcelle
                            </label>
                            <input type="number" id="numero" name="numero" value="{{ old('numero', $parcelle->numero) }}" class="modern-input" required>
                            @error('numero')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label for="arrondissement" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                </span>
                                Arrondissement
                            </label>
                            <select id="arrondissement" name="arrondissement" class="modern-select" required>
                                <option value="Godomey" {{ old('arrondissement', $parcelle->arrondissement) == 'Godomey' ? 'selected' : '' }}>Godomey</option>
                                <option value="Calavi" {{ old('arrondissement', $parcelle->arrondissement) == 'Calavi' ? 'selected' : '' }}>Calavi</option>
                                <option value="Hêvié" {{ old('arrondissement', $parcelle->arrondissement) == 'Hêvié' ? 'selected' : '' }}>Hêvié</option>
                                <option value="Akassato" {{ old('arrondissement', $parcelle->arrondissement) == 'Akassato' ? 'selected' : '' }}>Akassato</option>
                            </select>
                            @error('arrondissement')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label for="secteur" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                Secteur
                            </label>
                            <input type="text" id="secteur" name="secteur" value="{{ old('secteur', $parcelle->secteur) }}" class="modern-input" required>
                            @error('secteur')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label for="lot" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </span>
                                Lot
                            </label>
                            <input type="number" id="lot" name="lot" value="{{ old('lot', $parcelle->lot) }}" class="modern-input" required>
                            @error('lot')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group full-width">
                            <label for="designation" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                </span>
                                Adressage
                            </label>
                            <input type="text" id="designation" name="designation" value="{{ old('designation', $parcelle->designation) }}" class="modern-input">
                            @error('designation')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label for="parcelle" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                Parcelle
                            </label>
                            <input type="text" id="parcelle" name="parcelle" value="{{ old('parcelle', $parcelle->parcelle) }}" class="modern-input">
                            @error('parcelle')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label for="agent" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </span>
                                Agent
                            </label>
                            <select id="agent" name="agent" class="modern-select">
                                <option value="">Sélectionnez un agent</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('agent', $parcelle->agent) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('agent')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label for="responsable_id" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </span>
                                Responsable
                            </label>
                            <select id="responsable_id" name="responsable_id" class="modern-select">
                                <option value="">Sélectionnez un responsable</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('responsable_id', $parcelle->responsable_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('responsable_id')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Superficie -->
                <div class="form-section" id="superficie-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                            </svg>
                        </div>
                        <div class="section-title">
                            <h2>Superficie</h2>
                            <p>Dimensions et informations de surface</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="input-group">
                            <label for="ancienne_superficie" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </span>
                                Ancienne superficie (m²)
                            </label>
                            <input type="number" step="0.01" id="ancienne_superficie" name="ancienne_superficie" value="{{ old('ancienne_superficie', $parcelle->ancienne_superficie) }}" class="modern-input">
                            @error('ancienne_superficie')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label for="nouvelle_superficie" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </span>
                                Nouvelle superficie (m²)
                            </label>
                            <input type="number" step="0.01" id="nouvelle_superficie" name="nouvelle_superficie" value="{{ old('nouvelle_superficie', $parcelle->nouvelle_superficie) }}" class="modern-input">
                            @error('nouvelle_superficie')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group full-width">
                            <label for="motif" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                Motif d'occupation
                            </label>
                            <input type="text" id="motif" name="motif" value="{{ old('motif', $parcelle->motif) }}" class="modern-input">
                            @error('motif')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Occupation du terrain -->
                <div class="form-section" id="occupation-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="section-title">
                            <h2>Occupation du terrain</h2>
                            <p>Type et détails d'occupation</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="input-group">
                            <label for="type_occupation" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                Type d'occupation
                            </label>
                            <select id="type_occupation" name="type_occupation" class="modern-select" required onchange="toggleOccupationFields()">
                                <option value="">Sélectionnez un type</option>
                                @foreach($types_occupation as $type)
                                    <option value="{{ $type }}" {{ old('type_occupation', $parcelle->type_occupation) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('type_occupation')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group full-width">
                            <label for="details_occupation" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </span>
                                Détails de l'occupation
                            </label>
                            <textarea id="details_occupation" name="details_occupation" class="modern-input" rows="3">{{ old('details_occupation', $parcelle->details_occupation) }}</textarea>
                            @error('details_occupation')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Champs conditionnels pour occupation Autorisé -->
                        <div id="autorisation_fields" class="input-group full-width {{ old('type_occupation', $parcelle->type_occupation) == 'Autorisé' ? '' : 'hidden' }}">
                            <div class="section-subheader">
                                <h3>Informations d'autorisation</h3>
                                <p>Détails de l'autorisation d'occupation</p>
                            </div>

                            <div class="subform-grid">
                                <div class="input-group">
                                    <label for="reference_autorisation" class="input-label">
                                        <span class="label-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </span>
                                        Référence autorisation
                                    </label>
                                    <input type="text" id="reference_autorisation" name="reference_autorisation" value="{{ old('reference_autorisation', $parcelle->reference_autorisation) }}" class="modern-input" placeholder="Ex: AUT-2023-001">
                                    @error('reference_autorisation')
                                        <p class="error-text">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <label for="date_autorisation" class="input-label">
                                        <span class="label-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                                        Date d'autorisation
                                    </label>
                                    <input type="date" id="date_autorisation" name="date_autorisation" value="{{ old('date_autorisation', $parcelle->date_autorisation) }}" class="modern-input">
                                    @error('date_autorisation')
                                        <p class="error-text">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <label for="date_expiration_autorisation" class="input-label">
                                        <span class="label-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                                        Date d'expiration
                                    </label>
                                    <input type="date" id="date_expiration_autorisation" name="date_expiration_autorisation" value="{{ old('date_expiration_autorisation', $parcelle->date_expiration_autorisation) }}" class="modern-input">
                                    @error('date_expiration_autorisation')
                                        <p class="error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Statut et litiges -->
                <div class="form-section" id="statut-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="section-title">
                            <h2>Statut et litiges</h2>
                            <p>État d'attribution et contentieux</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="input-group">
                            <label for="statut_attribution" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </span>
                                Statut d'attribution
                            </label>
                            <select id="statut_attribution" name="statut_attribution" class="modern-select" required>
                                <option value="attribué" {{ old('statut_attribution', $parcelle->statut_attribution) == 'attribué' ? 'selected' : '' }}>Attribué</option>
                                <option value="non attribué" {{ old('statut_attribution', $parcelle->statut_attribution) == 'non attribué' ? 'selected' : '' }}>Non attribué</option>
                            </select>
                            @error('statut_attribution')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label for="litige" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </span>
                                Litige
                            </label>
                            <select id="litige" name="litige" class="modern-select" required onchange="toggleLitigeFields()">
                                <option value="1" {{ old('litige', $parcelle->litige) == '1' ? 'selected' : '' }}>Oui</option>
                                <option value="0" {{ old('litige', $parcelle->litige) == '0' ? 'selected' : '' }}>Non</option>
                            </select>
                            @error('litige')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group full-width">
                            <label for="observations" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </span>
                                Observations
                            </label>
                            <textarea id="observations" name="observations" class="modern-input" rows="4">{{ old('observations', $parcelle->observations) }}</textarea>
                            @error('observations')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Détails litige (conditionnel) -->
                        <div id="litige_fields" class="input-group full-width {{ old('litige', $parcelle->litige) == '1' ? '' : 'hidden' }}">
                            <label for="details_litige" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </span>
                                Détails du litige
                            </label>
                            <textarea id="details_litige" name="details_litige" class="modern-input" rows="4">{{ old('details_litige', $parcelle->details_litige) }}</textarea>
                            @error('details_litige')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Coordonnées -->
                <div class="form-section" id="coordonnees-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="section-title">
                            <h2>Coordonnées</h2>
                            <p>Localisation géographique</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="input-group">
                            <label for="structure" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </span>
                                Structure
                            </label>
                            <input type="text" id="structure" name="structure" value="{{ old('structure', $parcelle->structure) }}" class="modern-input">
                            @error('structure')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label for="latitude" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </span>
                                Latitude
                            </label>
                            <input type="number" step="0.000001" id="latitude" name="latitude" value="{{ old('latitude', $parcelle->latitude) }}" class="modern-input">
                            @error('latitude')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label for="longitude" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </span>
                                Longitude
                            </label>
                            <input type="number" step="0.000001" id="longitude" name="longitude" value="{{ old('longitude', $parcelle->longitude) }}" class="modern-input">
                            @error('longitude')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Validation hiérarchique CORRIGÉE -->
                @if(auth()->check() && auth()->user()->getRoleNames()->first() === 'chef_service')
                <div class="form-section" id="validation-section">
                    <div class="section-header">
                        <div class="section-icon security">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div class="section-title">
                            <h2>Validation Hiérarchique</h2>
                            <p>Authentification requise pour la modification</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="input-group full-width">
                            <label for="director_password" class="input-label">
                                <span class="label-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                Authentification du Directeur
                                <span class="required-star">*</span>
                            </label>
                            <div class="password-container">
                                <input type="password" id="director_password" name="director_password" class="modern-input password-input" required placeholder="Saisir les identifiants du Directeur">
                                <button type="button" class="password-toggle" data-target="director_password">
                                    <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878l-5.5-5.5m5.5 5.5l5.5 5.5" />
                                    </svg>
                                </button>
                            </div>
                            @error('director_password')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                            <p class="help-text">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Veuillez demander au Directeur présent de saisir ses identifiants
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Actions du formulaire -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Mettre à jour la parcelle
                    </button>
                    <a href="{{ route('parcelles.index') }}" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour au tableau
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Variables modernes */
    :root {
        --primary: #1A5F23;
        --primary-dark: #14501c;
        --primary-light: #e8f5e9;
        --secondary: #F9A825;
        --accent: #E30613;
        --success: #4CAF50;
        --warning: #FF9800;
        --info: #2196F3;
        --neutral: #F8FAFC;
        --neutral-dark: #E2E8F0;
        --text: #1E293B;
        --text-light: #64748B;
        --white: #FFFFFF;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.08);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.06);
        --shadow-lg: 0 10px 25px rgba(0,0,0,0.1), 0 5px 10px rgba(0,0,0,0.05);
        --shadow-xl: 0 20px 40px rgba(0,0,0,0.15);
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* En-tête premium */
    .premium-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: var(--radius-lg);
        padding: 2rem;
        margin-bottom: 2rem;
        color: var(--white);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .premium-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .header-icon {
        background: rgba(255,255,255,0.1);
        padding: 1rem;
        border-radius: var(--radius-md);
        backdrop-filter: blur(10px);
    }

    .header-icon svg {
        width: 2.5rem;
        height: 2.5rem;
        color: var(--white);
    }

    .premium-title {
        font-size: 2.25rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .premium-subtitle {
        font-size: 1.125rem;
        opacity: 0.9;
        margin: 0.5rem 0 0 0;
    }

    .header-badge {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        z-index: 2;
    }

    .badge-version {
        background: var(--secondary);
        color: var(--text);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Conteneur principal */
    .premium-form-container {
        display: flex;
        gap: 2rem;
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xl);
        overflow: hidden;
        min-height: 600px;
    }

    /* Navigation latérale */
    .premium-navigation {
        width: 320px;
        background: linear-gradient(180deg, var(--neutral) 0%, var(--white) 100%);
        border-right: 1px solid var(--neutral-dark);
        padding: 2rem;
        flex-shrink: 0;
    }

    .nav-header {
        margin-bottom: 2rem;
    }

    .nav-header h3 {
        color: var(--text);
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .nav-progress {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.875rem;
        color: var(--text-light);
    }

    .progress-bar {
        flex: 1;
        height: 4px;
        background: var(--neutral-dark);
        border-radius: 2px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary) 0%, var(--success) 100%);
        border-radius: 2px;
        transition: var(--transition);
    }

    .premium-nav-items {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .premium-nav-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        margin-bottom: 0.5rem;
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        border: 1px solid transparent;
    }

    .premium-nav-item:hover {
        background: var(--primary-light);
        border-color: var(--primary);
    }

    .premium-nav-item.active {
        background: var(--white);
        border-color: var(--primary);
        box-shadow: var(--shadow-sm);
    }

    .nav-icon-wrapper {
        background: var(--neutral);
        padding: 0.75rem;
        border-radius: var(--radius-sm);
        transition: var(--transition);
    }

    .premium-nav-item.active .nav-icon-wrapper {
        background: var(--primary);
    }

    .nav-icon-wrapper svg {
        width: 1.25rem;
        height: 1.25rem;
        color: var(--text-light);
        transition: var(--transition);
    }

    .premium-nav-item.active .nav-icon-wrapper svg {
        color: var(--white);
    }

    .nav-text {
        flex: 1;
    }

    .nav-title {
        display: block;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 0.25rem;
    }

    .nav-desc {
        display: block;
        font-size: 0.875rem;
        color: var(--text-light);
    }

    .nav-indicator {
        width: 8px;
        height: 8px;
        background: var(--success);
        border-radius: 50%;
        opacity: 0;
        transition: var(--transition);
    }

    .premium-nav-item.active .nav-indicator {
        opacity: 1;
    }

    /* Contenu principal */
    .premium-form-main {
        flex: 1;
        padding: 2rem;
        overflow-y: auto;
    }

    .premium-form {
        max-width: 100%;
    }

    /* CORRECTION CRITIQUE : Gestion des sections */
    .form-section {
        display: none;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .form-section.active {
        display: block;
        opacity: 1;
        transform: translateY(0);
        animation: fadeInUp 0.5s ease-out;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--neutral-dark);
    }

    .section-icon {
        background: var(--primary-light);
        padding: 1rem;
        border-radius: var(--radius-md);
    }

    .section-icon.security {
        background: #FFEBEE;
    }

    .section-icon svg {
        width: 1.5rem;
        height: 1.5rem;
        color: var(--primary);
    }

    .section-icon.security svg {
        color: var(--accent);
    }

    .section-title h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text);
        margin: 0;
    }

    .section-title p {
        color: var(--text-light);
        margin: 0.25rem 0 0 0;
    }

    /* Sous-en-tête pour les sections conditionnelles */
    .section-subheader {
        margin: 1.5rem 0 1rem 0;
        padding: 1rem;
        background: var(--neutral);
        border-radius: var(--radius-md);
        border-left: 4px solid var(--primary);
    }

    .section-subheader h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text);
        margin: 0 0 0.25rem 0;
    }

    .section-subheader p {
        color: var(--text-light);
        margin: 0;
        font-size: 0.875rem;
    }

    /* Grille de formulaire */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .subform-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .input-group {
        display: flex;
        flex-direction: column;
    }

    .input-group.full-width {
        grid-column: 1 / -1;
    }

    .input-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        font-weight: 600;
        color: var(--text);
        font-size: 0.9375rem;
    }

    .label-icon {
        display: flex;
        align-items: center;
    }

    .label-icon svg {
        width: 1.125rem;
        height: 1.125rem;
        color: var(--primary);
    }

    .required-star {
        color: var(--accent);
        margin-left: 0.25rem;
    }

    /* Champs modernes */
    .modern-input, .modern-select, .modern-input textarea {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid var(--neutral-dark);
        border-radius: var(--radius-md);
        font-size: 0.9375rem;
        font-family: inherit;
        transition: var(--transition);
        background: var(--white);
        color: var(--text);
        resize: vertical;
    }

    .modern-input:focus, .modern-select:focus, .modern-input textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26, 95, 35, 0.1);
        background: var(--white);
    }

    .modern-input::placeholder {
        color: var(--text-light);
        opacity: 0.7;
    }

    /* Conteneur mot de passe */
    .password-container {
        position: relative;
    }

    .password-input {
        padding-right: 3.5rem;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: var(--radius-sm);
        transition: var(--transition);
    }

    .password-toggle:hover {
        background: var(--neutral);
    }

    .password-toggle svg {
        width: 1.25rem;
        height: 1.25rem;
        color: var(--text-light);
    }

    /* Gestion des champs conditionnels */
    .hidden {
        display: none !important;
    }

    /* Messages */
    .error-text {
        color: var(--accent);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .help-text {
        color: var(--text-light);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .help-text svg {
        width: 1rem;
        height: 1rem;
        flex-shrink: 0;
    }

    /* Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid var(--neutral-dark);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        border: none;
        border-radius: var(--radius-md);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: var(--white);
        box-shadow: var(--shadow-md);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-secondary {
        background: var(--neutral);
        color: var(--text);
        border: 1px solid var(--neutral-dark);
    }

    .btn-secondary:hover {
        background: var(--neutral-dark);
        transform: translateY(-1px);
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
    @media (max-width: 1024px) {
        .premium-form-container {
            flex-direction: column;
        }

        .premium-navigation {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid var(--neutral-dark);
        }

        .premium-nav-items {
            display: flex;
            overflow-x: auto;
            gap: 0.5rem;
        }

        .premium-nav-item {
            flex-direction: column;
            text-align: center;
            min-width: 140px;
        }

        .nav-text {
            text-align: center;
        }
    }

    @media (max-width: 768px) {
        .premium-header {
            padding: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .premium-title {
            font-size: 1.75rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .subform-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            justify-content: center;
        }
    }
</style>

<script>
    // Navigation par sections - VERSION CORRIGÉE
    document.querySelectorAll('.premium-nav-item').forEach(item => {
        item.addEventListener('click', function() {
            const sectionId = this.getAttribute('data-section');
            console.log('Clic sur:', sectionId);

            // 1. Mettre à jour la navigation
            document.querySelectorAll('.premium-nav-item').forEach(navItem => {
                navItem.classList.remove('active');
            });
            this.classList.add('active');

            // 2. Mettre à jour la progression
            const navItems = document.querySelectorAll('.premium-nav-item');
            const activeIndex = Array.from(navItems).indexOf(this);
            const progress = ((activeIndex + 1) / navItems.length) * 100;

            const progressFill = document.querySelector('.progress-fill');
            const progressText = document.querySelector('.nav-progress span');

            if (progressFill) progressFill.style.width = `${progress}%`;
            if (progressText) progressText.textContent = `${activeIndex + 1}/${navItems.length}`;

            // 3. Afficher la section correspondante - CORRECTION CRITIQUE
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });

            const targetSection = document.getElementById(`${sectionId}-section`);
            if (targetSection) {
                targetSection.classList.add('active');
                console.log('Section activée:', targetSection.id);
            } else {
                console.error('Section non trouvée:', `${sectionId}-section`);
            }
        });
    });

    // Toggle password visibility
    document.querySelectorAll('.password-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const eyeOpen = this.querySelector('.eye-open');
            const eyeClosed = this.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                input.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }

            // Sécurité: masquer automatiquement après 5 secondes
            setTimeout(() => {
                if (input.type === 'text') {
                    input.type = 'password';
                    eyeOpen.style.display = 'block';
                    eyeClosed.style.display = 'none';
                }
            }, 5000);
        });
    });

    // Fonctions pour les champs conditionnels
    function toggleOccupationFields() {
        const typeOccupation = document.getElementById('type_occupation');
        const autorisationFields = document.getElementById('autorisation_fields');

        if (typeOccupation && autorisationFields) {
            if (typeOccupation.value === 'Autorisé') {
                autorisationFields.classList.remove('hidden');
            } else {
                autorisationFields.classList.add('hidden');
            }
        }
    }

    function toggleLitigeFields() {
        const litigeSelect = document.getElementById('litige');
        const litigeFields = document.getElementById('litige_fields');

        if (litigeSelect && litigeFields) {
            if (litigeSelect.value === '1') {
                litigeFields.classList.remove('hidden');
            } else {
                litigeFields.classList.add('hidden');
            }
        }
    }

    // Initialisation au chargement
    document.addEventListener('DOMContentLoaded', function() {
        console.log('=== INITIALISATION DU FORMULAIRE ===');

        // S'assurer que la première section est active
        const activeSections = document.querySelectorAll('.form-section.active');
        if (activeSections.length === 0) {
            const firstNavItem = document.querySelector('.premium-nav-item');
            if (firstNavItem) {
                firstNavItem.click();
            }
        }

        // Initialiser les champs conditionnels
        toggleOccupationFields();
        toggleLitigeFields();

        // Ajouter les écouteurs d'événements pour les champs conditionnels
        const typeOccupation = document.getElementById('type_occupation');
        const litigeSelect = document.getElementById('litige');

        if (typeOccupation) {
            typeOccupation.addEventListener('change', toggleOccupationFields);
        }
        if (litigeSelect) {
            litigeSelect.addEventListener('change', toggleLitigeFields);
        }

        console.log('Formulaire initialisé avec succès');
    });
</script>
@endsection
