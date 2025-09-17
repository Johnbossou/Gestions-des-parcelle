@extends('layouts.app')
@section('title', 'Modifier la parcelle')
@section('content')
<div class="content-container">
    <!-- En-tête aligné sur la version standard -->
    <div class="form-header">
        <h2 class="form-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Modifier la parcelle #{{ $parcelle->numero }}
        </h2>
        <p class="form-description">Mettez à jour les informations de cette parcelle</p>
    </div>

    <div class="premium-form-card">
        <!-- Navigation latérale simplifiée -->
        <div class="form-navigation">
            <ul class="nav-items">
                <li class="nav-item active" data-section="informations">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informations
                </li>
                <li class="nav-item" data-section="superficie">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="极 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                    </svg>
                    Superficie
                </li>
                <li class="nav-item" data-section="occupation">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Occupation
                </li>
                <li class="nav-item" data-section="statut">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Statut
                </li>
                <li class="nav-item" data-section="coordonnees">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Coordonnées
                </li>
            </ul>
        </div>

        <!-- Contenu du formulaire COMPLET -->
        <div class="premium-form-content">
            <form action="{{ route('parcelles.update', $parcelle) }}" method="POST" class="premium-form-grid" id="parcelleForm">
                @csrf
                @method('PUT')

                <!-- Section Informations de base -->
                <div class="form-section active" id="informations-section">
                    <div class="form-section-header">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 极 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3>Informations de base</h3>
                    </div>

                    <div class="form-group">
                        <label for="numero">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                            Numéro
                        </label>
                        <input type="number" id="numero" name="numero" value="{{ old('numero', $parcelle->numero) }}" class="form-control" required>
                        @error('numero')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="arrondissement">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Arrondissement
                        </label>
                        <select id="arrondissement" name="arrondissement" class="form-control" required>
                            <option value="Godomey" {{ old('arrondissement', $parcelle->arrondissement) == 'Godomey' ? 'selected' : '' }}>Godomey</option>
                            <option value="Calavi" {{ old('arrondissement', $parcelle->arrondissement) == 'Calavi' ? 'selected' : '' }}>Calavi</option>
                            <option value="Hêvié" {{ old('arrondissement', $parcelle->arrondissement) == 'Hêvié' ? 'selected' : '' }}>Hêvié</option>
                            <option value="Akassato" {{ old('arrondissement', $parcelle->arrondissement) == 'Akassato' ? 'selected' : '' }}>Akassato</option>
                        </select>
                        @error('arrondissement')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="secteur">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2极1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Secteur
                        </label>
                        <input type="text" id="secteur" name="secteur" value="{{ old('secteur', $parcelle->secteur) }}" class="form-control" required>
                        @error('secteur')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lot">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Lot
                        </label>
                        <input type="number" id="lot" name="lot" value="{{ old('lot', $parcelle->lot) }}" class="form-control" required>
                        @error('lot')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="designation">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2极-3l-4 4z" />
                            </svg>
                            Adressage
                        </label>
                        <input type="text" id="designation" name="designation" value="{{ old('designation', $parcelle->designation) }}" class="form-control">
                        @error('designation')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parcelle">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Parcelle
                        </label>
                        <input type="text" id="parcelle" name="parcelle" value="{{ old('parcelle', $parcelle->parcelle) }}" class="form-control">
                        @error('parcelle')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="agent_id">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Agent
                        </label>
                        <select id="agent_id" name="agent_id" class="form-control">
                            <option value="">Sélectionnez un agent</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('agent_id', $parcelle->agent_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('agent_id')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="responsable_id">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Responsable
                        </label>
                        <select id="responsable_id" name="responsable_id" class="form-control">
                            <option value="">Sélectionnez un responsable</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('responsable_id', $parcelle->responsable_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('responsable_id')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Section Superficie -->
                <div class="form-section" id="superficie-section">
                    <div class="form-section-header">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                        </svg>
                        <h3>Superficie</h3>
                    </div>

                    <div class="form-group">
                        <label for="ancienne_superficie">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            Ancienne superficie (m²)
                        </label>
                        <input type="number" step="0.01" id="ancienne_superficie" name="ancienne_superficie" value="{{ old('ancienne_superficie', $parcelle->ancienne_superficie) }}" class="form-control">
                        @error('ancienne_superficie')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nouvelle_superficie">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Nouvelle superficie (m²)
                        </label>
                        <input type="number" step="0.01" id="nouvelle_superficie" name="nouvelle_superficie" value="{{ old('nouvelle_superficie', $parcelle->nouvelle_superficie) }}" class="form-control">
                        @error('nouvelle_superficie')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="motif">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0极" />
                            </svg>
                            Motif d'occupation
                        </label>
                        <input type="text" id="motif" name="motif" value="{{ old('motif', $parcelle->motif) }}" class="form-control">
                        @error('motif')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Section Occupation du terrain -->
                <div class="form-section" id="occupation-section">
                    <div class="form-section-header">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3>Occupation du terrain</h3>
                    </div>

                    <div class="form-group">
                        <label for="type_occupation">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2极1a2 2 0 002 2 2 2 0 012 2v2.945M8 3极35V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Type d'occupation
                        </label>
                        <select id="type_occupation" name="type_occupation" class="form-control" required onchange="toggleOccupationFields()">
                            <option value="">Sélectionnez un type</option>
                            @foreach($types_occupation as $type)
                                <option value="{{ $type }}" {{ old('type_occupation', $parcelle->type_occupation) == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('type_occupation')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="details_occupation">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Détails de l'occupation
                        </label>
                        <textarea id="details_occupation" name="details_occupation" class="form-control" rows="3">{{ old('details_occupation', $parcelle->details_occupation) }}</textarea>
                        @error('details_occupation')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champs conditionnels pour occupation Autorisé -->
                    <div id="autorisation_fields" class="form-section {{ old('type_occupation', $parcelle->type_occupation) == 'Autorisé' ? '' : 'hidden' }}">
                        <div class="form-section-header">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 极1.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <h3>Informations d'autorisation</h3>
                        </div>

                        <div class="form-group">
                            <label for="reference_autorisation">
                                <svg xmlns="http://www.w极.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Référence autorisation
                            </label>
                            <input type="text" id="reference_autorisation" name="reference_autorisation" value="{{ old('reference_autorisation', $parcelle->reference_autorisation) }}" class="form-control" placeholder="Ex: AUT-2023-001">
                            @error('reference_autorisation')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="date_autorisation">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Date d'autorisation
                            </label>
                            <input type="date" id="date_autorisation" name="date_autorisation" value="{{ old('date_autorisation', $parcelle->date_autorisation) }}" class="form-control">
                            @error('date_autorisation')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="date_expiration_autorisation">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3极8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Date d'expiration
                            </label>
                            <input type="date" id="date_expiration_autorisation" name="date_expiration_autorisation" value="{{ old('date_expiration_autorisation', $parcelle->date_expiration_autorisation) }}" class="form-control">
                            @error('date_expiration_autorisation')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Statut et litiges -->
                <div class="form-section" id="statut-section">
                    <div class="form-section-header">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <h3>Statut et litiges</h3>
                    </div>

                    <div class="form-group">
                        <label for="statut_attribution">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Statut d'attribution
                        </label>
                        <select id="statut_attribution" name="statut_attribution" class="form-control" required>
                            <option value="attribué" {{ old('statut_attribution', $parcelle->statut_attribution) == 'attribué' ? 'selected' : '' }}>Attribué</option>
                            <option value="non attribué" {{ old('statut_attribution', $parcelle->statut_attribution) == 'non attribué' ? 'selected' : '' }}>Non attribué</option>
                        </select>
                        @error('statut_attribution')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="litige">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Litige
                        </label>
                        <select id="litige" name="litige" class="form-control" required onchange="toggleLitigeFields()">
                            <option value="1" {{ old('litige', $parcelle->litige) == '1' ? 'selected' : '' }}>Oui</option>
                            <option value="0" {{ old('litige', $parcelle->litige) == '0' ? 'selected' : '' }}>Non</option>
                        </select>
                        @error('litige')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="observations">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Observations
                        </label>
                        <textarea id="observations" name="observations" class="form-control" rows="4">{{ old('observations', $parcelle->observations) }}</textarea>
                        @error('observations')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Détails litige (conditionnel) -->
                    <div id="litige_fields" class="form-group full-width {{ old('litige', $parcelle->litige) == '1' ? '' : 'hidden' }}">
                        <label for="details_litige">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Détails du litige
                        </label>
                        <textarea id="details_litige" name="details_litige" class="form-control" rows="4">{{ old('details_litige', $parcelle->details_litige) }}</textarea>
                        @error('details_litige')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Section Coordonnées -->
                <div class="form-section" id="coordonnees-section">
                    <div class="form-section-header">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3>Coordonnées</h3>
                    </div>

                    <div class="form-group">
                        <label for="structure">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Structure
                        </label>
                        <input type="text" id="structure" name="structure" value="{{ old('structure', $parcelle->structure) }}" class="form-control">
                        @error('structure')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="latitude">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Latitude
                        </label>
                        <input type="number" step="0.000001" id="latitude" name="latitude" value="{{ old('latitude', $parcelle->latitude) }}" class="form-control">
                        @error('latitude')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="longitude">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Longitude
                        </label>
                        <input type="number" step="0.000001" id="longitude" name="longitude" value="{{ old('longitude', $parcelle->longitude) }}" class="form-control">
                        @error('longitude')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Validation Directeur - Uniformisée -->
                @if(auth()->check() && auth()->user()->hasRole('chef_service'))
                <div class="form-section">
                    <div class="form-section-header">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <h3>Validation Hiérarchique</h3>
                    </div>

                    <div class="form-group">
                        <label for="director_password">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-极 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0极4h8z" />
                            </svg>
                            Authentification du Directeur <span class="required-asterisk">*</span>
                        </label>
                        <div class="password-input-container">
                            <input type="password" id="director_password" name="director_password" class="form-control @error('director_password') error @enderror" required placeholder="Saisir les identifiants du Directeur" autocomplete="current-password">
                            <button type="button" class="toggle-password" aria-label="Afficher le mot de passe" data-toggle-password="director_password">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="eye-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="eye-slash-icon" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L12 12m-2.122-2.122l4.242-4.242M12 12l6.878 6.878M12 12l-6.878 6.878" />
                                </svg>
                            </button>
                        </div>
                        @error('director_password')
                            <p class="error-message">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="form-help">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="极13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 极 0118 0z" />
                            </svg>
                            Veuillez demander au Directeur présent de saisir ses identifiants
                        </p>
                    </div>
                </div>
                @endif

                <!-- Actions du formulaire -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Mettre à jour
                    </button>
                    <a href="{{ route('parcelles.index', $parcelle) }}" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Variables CSS de la version standard */
    :root {
        --primary: #1A5F23;
        --secondary: #F9A825;
        --accent: #E30613;
        --neutral: #F5F5F5;
        --black: #333333;
        --white: #FFFFFF;
        --success: #4CAF50;
        --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.05);
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10极 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1), 0 10px 10px rgba(0, 0, 0, 0.04);
        --radius-sm: 0.25rem;
        --radius-md: 0.375rem;
        --radius-lg: 0.5rem;
        --radius-xl: 0.75rem;
        --radius-full: 9999px;
        --transition-base: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-colors: color 0.15s, background-color 0.15s, border-color 0.15s, box-shadow 0.15s;
        --transition-transform: transform 0.2s cubic-bezier(0, 0, 0.2, 1);
    }

    /* Styles de base de la version standard */
    .form-header {
        margin-bottom: 2rem;
        animation: fadeIn 0.5s ease-out;
    }

    .form-title {
        font-family: 'Roboto', Arial, sans-serif;
        font-weight: 700;
        font-size: 2rem;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .form-title svg {
        width: 2rem;
        height: 2rem;
        stroke-width: 1.5;
        color: var(--secondary);
    }

    .form-description {
        color: var(--black);
        font-size: 1.125rem;
    }

    /* Conteneur premium avec navigation */
    .premium-form-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--neutral);
        animation: slideIn 0.4s ease-out;
        display: flex;
        min-height: 600px;
    }

    /* Navigation latérale */
    .form-navigation {
        width: 250px;
        flex-shrink: 0;
        background: var(--neutral);
        border-right: 1px solid var(--neutral);
        padding: 2rem 0;
    }

    .nav-items {
        list-style: none;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.5rem;
        cursor: pointer;
        transition: var(--transition-colors);
        border-left: 3px solid transparent;
    }

    .nav-item:hover {
        background: rgba(26, 95, 35, 0.05);
    }

    .nav-item.active {
        background: rgba(26, 95, 35, 0.1);
        border-left-color: var(--primary);
    }

    .nav-item svg {
        width: 1.25rem;
        height: 1.25rem;
        color: var(--black);
    }

    .nav-item.active svg {
        color: var(--primary);
    }

    /* Contenu du formulaire */
    .premium-form-content {
        flex: 1;
        padding: 2.5rem;
        overflow-y: auto;
    }

    .premium-form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .form-section {
        display: none;
        grid-column: 1 / -1;
    }

    .form-section.active {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        animation: fadeIn 0.3s ease;
    }

    /* Styles des champs (identique à la version standard) */
    .form-section-header {
        grid-column: 1 / -1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 1.5rem 0 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--neutral);
    }

    .form-section-header h3 {
        font-family: 'Roboto', Arial, sans-serif;
        font-weight: 600;
        font-size: 1.25rem;
        color: var(--primary);
    }

    .form-section-header svg {
        width: 1.5rem;
        height: 1.5rem;
        color: var(--secondary);
    }

    .form-group {
        position: relative;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        font-weight: 500;
        color: var(--black);
        font-size: 0.9375rem;
    }

    .form-group label svg {
        width: 1.25rem;
        height: 1.25rem;
        stroke-width: 1.75;
        color: var(--secondary);
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--neutral);
        border-radius: var(--radius-md);
        font-size: 0.9375rem;
        font-family: 'Roboto', Arial, sans-serif;
        transition: var(--transition-colors);
        background-color: var(--neutral);
        color: var(--black);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--success);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
        background-color: var(--white);
    }

    .form-control.error {
        border-color: var(--accent);
        animation: shake 0.5s;
    }

    .error-message {
        color: var(--accent);
        font-size: 0.8125rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: fadeIn 0.3s;
    }

    .error-message svg {
        width: 1rem;
        height: 1rem;
        stroke-width: 1.75;
    }

    .form-help {
        color: var(--black);
        font-size: 0.8125rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: fadeIn 0.3s;
    }

    .form-help svg {
        width: 1rem;
        height: 1rem;
        stroke-width: 1.75;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .hidden {
        display: none;
    }

    .password-input-container {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.25rem;
        transition: var(--transition-colors);
        z-index: 2;
    }

    .toggle-password svg {
        width: 1.25rem;
        height: 1.25rem;
        stroke-width: 1.75;
        color: var(--black);
    }

    .toggle-password:hover svg {
        color: var(--success);
    }

    .required-asterisk {
        color: var(--accent);
        margin-left: 0.25rem;
    }

    .form-actions {
        grid-column: 1 / -1;
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--neutral);
    }

    .btn {
        padding: 0.875rem 1.75rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: var(--transition-colors);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
    }

    .btn-primary {
        background: var(--primary);
        color: var(--white);
        box-shadow: var(--shadow-sm);
    }

    .btn-primary:hover {
        background: var(--success);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-secondary {
        background: var(--secondary);
        color: var(--black);
        box-shadow: var(--shadow-sm);
    }

    .btn-secondary:hover {
        background: #FCD116;
        border-color: var(--secondary);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideIn {
        from { transform: translateX(-20px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .premium-form-card {
            flex-direction: column;
        }

        .form-navigation {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid var(--neutral);
            padding: 1rem 0;
        }

        .nav-items {
            display: flex;
            overflow-x: auto;
            padding: 0 1rem;
        }

        .nav-item {
            flex-direction: column;
            text-align: center;
            padding: 0.75rem 1rem;
            border-left: none;
            border-bottom: 3px solid transparent;
            min-width: 120px;
        }

        .nav-item.active {
            border-left: none;
            border-bottom-color: var(--primary);
        }

        .nav-item svg {
            margin-bottom: 0.5rem;
        }
    }

    @media (max-width: 768px) {
        .premium-form-content {
            padding: 1.5rem;
        }

        .premium-form-grid {
            grid-template-columns: 1fr;
        }

        .form-title {
            font-size: 1.75rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .premium-form-content {
            padding: 1.25rem;
        }

        .form-title {
            font-size: 1.5rem;
        }

        .nav-item {
            min-width: 100px;
            font-size: 0.875rem;
        }

        .nav-item svg {
            width: 1rem;
            height: 1rem;
        }
    }
</style>

<script>
    // Navigation par sections
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', () => {
            const sectionId = item.getAttribute('data-section');

            // Mettre à jour la navigation
            document.querySelectorAll('.nav-item').forEach(navItem => navItem.classList.remove('active'));
            item.classList.add('active');

            // Afficher la section correspondante
            document.querySelectorAll('.form-section').forEach(section => section.classList.remove('active'));
            document.getElementById(`${sectionId}-section`).classList.add('active');
        });
    });

    // Fonctions pour les champs conditionnels (identique à la version standard)
    function toggleOccupationFields() {
        const typeOccupation = document.getElementById('type_occupation').value;
        const autorisationFields = document.getElementById('autorisation_fields');

        if (typeOccupation === 'Autorisé') {
            autorisationFields.classList.remove('hidden');
        } else {
            autorisationFields.classList.add('hidden');
        }
    }

    function toggleLitigeFields() {
        const hasLitige = document.getElementById('litige').value === '1';
        const litigeFields = document.getElementById('litige_fields');

        if (hasLitige) {
            litigeFields.classList.remove('hidden');
        } else {
            litigeFields.classList.add('hidden');
        }
    }

    // Initialiser l'état des champs conditionnels au chargement
    document.addEventListener('DOMContentLoaded', function() {
        toggleOccupationFields();
        toggleLitigeFields();

        // Script sécurisé pour le toggle password
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-toggle-password');
                const input = document.getElementById(targetId);
                const eyeIcon = this.querySelector('.eye-icon');
                const eyeSlashIcon = this.querySelector('.eye-slash-icon');

                if (input.type === 'password') {
                    input.type = 'text';
                    eyeIcon.style.display = 'none';
                    eyeSlashIcon.style.display = 'block';
                    this.setAttribute('aria-label', 'Masquer le mot de passe');
                } else {
                    input.type = 'password';
                    eyeIcon.style.display = 'block';
                    eyeSlashIcon.style.display = 'none';
                    this.setAttribute('aria-label', 'Afficher le mot de passe');
                }

                // Sécurité: masquer automatiquement après 5 secondes
                setTimeout(() => {
                    if (input.type === 'text') {
                        input.type = 'password';
                        eyeIcon.style.display = 'block';
                        eyeSlashIcon.style.display = 'none';
                        this.setAttribute('aria-label', 'Afficher le mot de passe');
                    }
                }, 5000);
            });
        });

        // Animation pour les champs en erreur
        const errorFields = document.querySelectorAll('.form-control.error');
        if (errorFields.length > 0) {
            errorFields[0].focus();
        }
    });
</script>
@endsection
