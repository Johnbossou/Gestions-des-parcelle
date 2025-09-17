@extends('layouts.app')
@section('title', 'Nouvelle parcelle')
@section('content')

<div class="content-container">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="icon-title" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Nouvelle parcelle
            </h1>
            <p class="page-description">Remplissez les détails pour créer une nouvelle parcelle</p>
        </div>
    </div>

    <div class="form-container">
        <div class="form-header">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945
                        M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064
                        M15 20.488V18a2 2 0 012-2h3.064
                        M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                Informations de base
            </h2>
        </div>

        <div class="form-content">
            <form action="{{ route('parcelles.store') }}" method="POST">
                @csrf

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="form-grid">
                    <div class="form-group">
                        <label for="arrondissement">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Arrondissement *
                        </label>
                        <select id="arrondissement" name="arrondissement" class="form-control @error('arrondissement') error @enderror" required>
                            <option value="">Sélectionnez un arrondissement</option>
                            <option value="Akassato" {{ old('arrondissement') == 'Akassato' ? 'selected' : '' }}>Akassato</option>
                            <option value="Calavi" {{ old('arrondissement') == 'Calavi' ? 'selected' : '' }}>Calavi</option>
                            <option value="Glo-Djigbé" {{ old('arrondissement') == 'Glo-Djigbé' ? 'selected' : '' }}>Glo-Djigbé</option>
                            <option value="Godomey" {{ old('arrondissement') == 'Godomey' ? 'selected' : '' }}>Godomey</option>
                            <option value="Hêvié" {{ old('arrondissement') == 'Hêvié' ? 'selected' : '' }}>Hêvié</option>
                            <option value="Kpanroun" {{ old('arrondissement') == 'Kpanroun' ? 'selected' : '' }}>Kpanroun</option>
                            <option value="Ouèdo" {{ old('arrondissement') == 'Ouèdo' ? 'selected' : '' }}>Ouèdo</option>
                            <option value="Togba" {{ old('arrondissement') == 'Togba' ? 'selected' : '' }}>Togba</option>
                            <option value="Zinvié" {{ old('arrondissement') == 'Zinvié' ? 'selected' : '' }}>Zinvié</option>
                        </select>
                        @error('arrondissement')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="secteur">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945
                                    M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064
                                    M15 20.488V18a2 2 0 012-2h3.064
                                    M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            Secteur *
                        </label>
                        <input type="text" id="secteur" name="secteur" class="form-control @error('secteur') error @enderror" value="{{ old('secteur') }}" required>
                        @error('secteur')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lot">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Lot *
                        </label>
                        <input type="number" id="lot" name="lot" class="form-control @error('lot') error @enderror" value="{{ old('lot') }}" required>
                        @error('lot')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="designation">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                            Adressage
                        </label>
                        <input type="text" id="designation" name="designation" class="form-control @error('designation') error @enderror" value="{{ old('designation') }}">
                        @error('designation')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parcelle">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6
                                    m-6 4h6
                                    m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293
                                    l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                            Parcelle
                        </label>
                        <input type="text" id="parcelle" name="parcelle" class="form-control @error('parcelle') error @enderror" value="{{ old('parcelle') }}">
                        @error('parcelle')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="agent">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Agent
                        </label>
                        <select id="agent" name="agent" class="form-control @error('agent') error @enderror" onchange="toggleCustomInput(this, 'agent_input')">
                            <option value="">Sélectionnez un agent</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('agent', $parcelle->agent ?? '') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                            <option value="custom" {{ old('agent_name') ? 'selected' : '' }}>Autre...</option>
                        </select>
                        <input type="text" id="agent_input" name="agent_name" class="form-control mt-2 @error('agent_name') error @enderror"
                            placeholder="Entrez le nom de l'agent" value="{{ old('agent_name') ?? $parcelle->agent_name ?? '' }}"
                            style="display:{{ old('agent_name') || isset($parcelle->agent_name) ? 'block' : 'none' }};">
                        @error('agent')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('agent_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="responsable_id">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Responsable
                        </label>
                        <select id="responsable_id" name="responsable_id" class="form-control @error('responsable_id') error @enderror" onchange="toggleCustomInput(this, 'responsable_input')">
                            <option value="">Sélectionnez un responsable</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('responsable_id', $parcelle->responsable_id ?? '') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                            <option value="custom" {{ old('responsable_name') ? 'selected' : '' }}>Autre...</option>
                        </select>
                        <input type="text" id="responsable_input" name="responsable_name" class="form-control mt-2 @error('responsable_name') error @enderror"
                            placeholder="Entrez le nom du responsable" value="{{ old('responsable_name') ?? $parcelle->responsable_name ?? '' }}"
                            style="display:{{ old('responsable_name') || isset($parcelle->responsable_name) ? 'block' : 'none' }};">
                        @error('responsable_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('responsable_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
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
                        <input type="number" step="0.01" id="ancienne_superficie" name="ancienne_superficie" class="form-control @error('ancienne_superficie') error @enderror" value="{{ old('ancienne_superficie') }}">
                        @error('ancienne_superficie')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nouvelle_superficie">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Nouvelle superficie (m²)
                        </label>
                        <input type="number" step="0.01" id="nouvelle_superficie" name="nouvelle_superficie" class="form-control @error('nouvelle_superficie') error @enderror" value="{{ old('nouvelle_superficie') }}">
                        @error('nouvelle_superficie')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="motif">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Motif
                        </label>
                        <input
                            type="text"
                            id="motif"
                            name="motif"
                            class="form-control @error('motif') error @enderror"
                            value="{{ old('motif') }}"
                        />
                        @error('motif')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="section-title">Occupation du terrain</div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="type_occupation">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945
                                    M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064
                                    M15 20.488V18a2 2 0 012-2h3.064
                                    M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            Type d'occupation *
                        </label>
                        <select id="type_occupation" name="type_occupation" class="form-control @error('type_occupation') error @enderror" required onchange="toggleOccupationFields()">
                            <option value="">Sélectionnez un type</option>
                            @foreach($types_occupation as $type)
                                <option value="{{ $type }}" {{ old('type_occupation') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('type_occupation')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="details_occupation">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Détails de l'occupation
                        </label>
                        <textarea id="details_occupation" name="details_occupation" class="form-control @error('details_occupation') error @enderror" rows="3" placeholder="Décrivez les détails de l'occupation du terrain">{{ old('details_occupation') }}</textarea>
                        @error('details_occupation')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Champs conditionnels pour occupation Autorisé -->
                <div id="autorisation_fields" class="conditional-fields {{ old('type_occupation') == 'Autorisé' ? '' : 'hidden' }}">
                    <h3 style="color: var(--primary); margin-bottom: 15px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20" style="vertical-align: middle; margin-right: 8px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Informations d'autorisation
                    </h3>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="reference_autorisation">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Référence autorisation
                            </label>
                            <input type="text" id="reference_autorisation" name="reference_autorisation" class="form-control @error('reference_autorisation') error @enderror"
                                placeholder="Ex: AUT-2023-001" value="{{ old('reference_autorisation') }}">
                            @error('reference_autorisation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="date_autorisation">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 7V3
                                        m8 4V3
                                        m-9 8h10
                                        M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>
                                Date d'autorisation
                            </label>
                            <input type="date" id="date_autorisation" name="date_autorisation" class="form-control @error('date_autorisation') error @enderror" value="{{ old('date_autorisation') }}">
                            @error('date_autorisation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="date_expiration_autorisation">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Date d'expiration
                            </label>
                            <input type="date" id="date_expiration_autorisation" name="date_expiration_autorisation" class="form-control @error('date_expiration_autorisation') error @enderror" value="{{ old('date_expiration_autorisation') }}">
                            @error('date_expiration_autorisation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="section-title">Statut et litiges</div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="statut_attribution">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Statut d'attribution *
                        </label>
                        <select id="statut_attribution" name="statut_attribution" class="form-control @error('statut_attribution') error @enderror" required>
                            <option value="">Sélectionnez un statut</option>
                            <option value="attribué" {{ old('statut_attribution') == 'attribué' ? 'selected' : '' }}>Attribué</option>
                            <option value="non attribué" {{ old('statut_attribution') == 'non attribué' ? 'selected' : '' }}>Non attribué</option>
                        </select>
                        @error('statut_attribution')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="litige">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Litige *
                        </label>
                        <select id="litige" name="litige" class="form-control @error('litige') error @enderror" required onchange="toggleLitigeFields()">
                            <option value="">Sélectionnez une option</option>
                            <option value="1" {{ old('litige') == '1' ? 'selected' : '' }}>Oui</option>
                            <option value="0" {{ old('litige') == '0' ? 'selected' : '' }}>Non</option>
                        </select>
                        @error('litige')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="observations">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Observations
                        </label>
                        <textarea id="observations" name="observations" class="form-control @error('observations') error @enderror" rows="4">{{ old('observations') }}</textarea>
                        @error('observations')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Détails litige (conditionnel) -->
                    <div id="litige_fields" class="form-group full-width {{ old('litige') == '1' ? '' : 'hidden' }}">
                        <label for="details_litige">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Détails du litige
                        </label>
                        <textarea id="details_litige" name="details_litige" class="form-control @error('details_litige') error @enderror" rows="4" placeholder="Décrivez les détails du litige...">{{ old('details_litige') }}</textarea>
                        @error('details_litige')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="section-title">Coordonnées</div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="structure">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16
                                    m14 0h2
                                    m-2 0h-5
                                    m-9 0H3
                                    m2 0h5
                                    M9 7h1
                                    m-1 4h1
                                    m4-4h1
                                    m-1 4h1
                                    m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5
                                    m-4 0h4"
                                />
                            </svg>

                            Structure
                        </label>
                        <input type="text" id="structure" name="structure" class="form-control @error('structure') error @enderror" value="{{ old('structure') }}">
                        @error('structure')
                            <span class="error-message">{{ $message }}</span>
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
                        <input type="number" step="0.000001" id="latitude" name="latitude" class="form-control @error('latitude') error @enderror" value="{{ old('latitude') }}">
                        @error('latitude')
                            <span class="error-message">{{ $message }}</span>
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
                        <input type="number" step="0.000001" id="longitude" name="longitude" class="form-control @error('longitude') error @enderror" value="{{ old('longitude') }}">
                        @error('longitude')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
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

    .content-container {
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        text-align: center;
        margin-bottom: 40px;
        animation: fadeInDown 0.8s ease-out;
    }

    .page-title {
        font-family: 'Roboto', Arial, sans-serif;
        font-weight: 700;
        font-size: 2.5rem;
        color: var(--primary);
        margin-bottom: 10px;
        position: relative;
        display: inline-block;
        letter-spacing: -0.5px;
    }

    .page-title::after {
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

    .page-description {
        color: var(--black);
        font-size: 1.1rem;
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
        animation: fade 0.3s;
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
    .page-title {
        display: flex;
        align-items: center;
        gap: 0.5rem; /* espace entre l'icône et le texte */
        font-size: 1.5rem; /* taille du texte */
    }

    .page-title .icon-title {
        width: 1.5em;  /* largeur proportionnelle au texte */
        height: 1.5em; /* hauteur proportionnelle au texte */
    }


    .conditional-fields {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-top: 20px;
        padding: 20px;
        background: rgba(76, 175, 80, 0.05);
        border-radius: var(--border-radius);
        border-left: 4px solid var(--success);
        transition: var(--transition);
    }

    .conditional-fields.hidden {
        display: none;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: var(--border-radius);
        margin-bottom: 20px;
        border: 1px solid #f5c6cb;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
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
        100% {
            box-shadow: 0 0 0 0 rgba(76, 175, 80, 1);
        }
    }

    .glow-animation {
        animation: glow 1.5s infinite;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 2rem;
        }

        .form-content {
            padding: 25px;
        }

        .form-actions {
            flex-direction: column;
        }

        .conditional-fields {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    function toggleCustomInput(selectElement, inputId) {
        const input = document.getElementById(inputId);

        if (selectElement.value === "custom") {
            // Masquer le select et afficher l'input
            selectElement.style.display = "none";
            selectElement.name = "";
            input.style.display = "block";
            input.required = true;
            input.name = selectElement.id.replace("_id", "_name");
        }
    }

    function toggleOccupationFields() {
        const typeOccupation = document.getElementById('type_occupation').value;
        const autorisationFields = document.getElementById('autorisation_fields');

        if (typeOccupation === 'Autorisé') {
            autorisationFields.classList.remove('hidden');
            // Rendre les champs optionnels mais visibles
            document.getElementById('reference_autorisation').required = false;
            document.getElementById('date_autorisation').required = false;
            document.getElementById('date_expiration_autorisation').required = false;
        } else {
            autorisationFields.classList.add('hidden');
            // Vider les champs quand cachés
            document.getElementById('reference_autorisation').value = '';
            document.getElementById('date_autorisation').value = '';
            document.getElementById('date_expiration_autorisation').value = '';
        }
    }

    function toggleLitigeFields() {
        const hasLitige = document.getElementById('litige').value === '1';
        const litigeFields = document.getElementById('litige_fields');

        if (hasLitige) {
            litigeFields.classList.remove('hidden');
            document.getElementById('details_litige').required = true;
        } else {
            litigeFields.classList.add('hidden');
            document.getElementById('details_litige').value = '';
            document.getElementById('details_litige').required = false;
        }
    }

    // Initialiser l'état des champs conditionnels au chargement
    document.addEventListener('DOMContentLoaded', function() {
        toggleOccupationFields();
        toggleLitigeFields();

        // Restaurer l'état des champs personnalisés
        @if(old('agent_name'))
            document.getElementById('agent_id').style.display = 'none';
            document.getElementById('agent_input').style.display = 'block';
        @endif

        @if(old('responsable_name'))
            document.getElementById('responsable_id').style.display = 'none';
            document.getElementById('responsable_input').style.display = 'block';
        @endif
    });
</script>
@endsection
