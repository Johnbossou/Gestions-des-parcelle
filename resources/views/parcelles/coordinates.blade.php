@extends('layouts.app')
@section('title', 'Modifier les coordonnées - Parcelle #' . $parcelle->numero)
@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<style>
    .coord-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }
    .coord-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .coord-header {
        background: linear-gradient(135deg, #1A5F23, #2d8a3a);
        color: #fff;
        padding: 1.5rem 2rem;
    }
    .coord-header h1 {
        font-size: 1.5rem;
        margin: 0;
    }
    .coord-header p {
        opacity: 0.85;
        margin: 0.5rem 0 0;
    }
    .coord-body {
        padding: 2rem;
    }
    #map-edit {
        height: 400px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        margin-bottom: 1.5rem;
    }
    .coord-fields {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .coord-field label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    .coord-field input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.2s;
    }
    .coord-field input:focus {
        outline: none;
        border-color: #1A5F23;
        box-shadow: 0 0 0 3px rgba(26,95,35,0.15);
    }
    .coord-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        border: none;
        font-size: 0.95rem;
        transition: all 0.2s;
    }
    .btn-primary {
        background: #1A5F23;
        color: #fff;
    }
    .btn-primary:hover {
        background: #155a1e;
    }
    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
    }
    .btn-secondary:hover {
        background: #e5e7eb;
    }
    .coord-hint {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
</style>

<div class="coord-container">
    <div class="coord-card">
        <div class="coord-header">
            <h1>Modifier les coordonnées</h1>
            <p>Parcelle #{{ $parcelle->numero }} — {{ $parcelle->parcelle ?? '' }}</p>
        </div>
        <div class="coord-body">
            <form method="POST" action="{{ route('parcelles.coordinates.update', $parcelle) }}">
                @csrf
                @method('PUT')

                <div id="map-edit"></div>

                <p class="coord-hint">Cliquez sur la carte pour placer un marqueur, ou saisissez manuellement les coordonnées ci-dessous.</p>

                <div class="coord-fields">
                    <div class="coord-field">
                        <label for="latitude">Latitude</label>
                        <input type="number" step="any" id="latitude" name="latitude"
                               value="{{ old('latitude', $parcelle->latitude) }}" required
                               min="-90" max="90" placeholder="ex: 6.3654">
                    </div>
                    <div class="coord-field">
                        <label for="longitude">Longitude</label>
                        <input type="number" step="any" id="longitude" name="longitude"
                               value="{{ old('longitude', $parcelle->longitude) }}" required
                               min="-180" max="180" placeholder="ex: 2.3826">
                    </div>
                </div>

                @error('latitude')
                    <p style="color:#dc2626;font-size:0.85rem;margin-bottom:1rem;">{{ $message }}</p>
                @enderror
                @error('longitude')
                    <p style="color:#dc2626;font-size:0.85rem;margin-bottom:1rem;">{{ $message }}</p>
                @enderror

                <div class="coord-actions">
                    <a href="{{ route('parcelles.show', $parcelle) }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer les coordonnées</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    const lat = parseFloat(latInput.value) || 6.3654;
    const lng = parseFloat(lngInput.value) || 2.3826;

    const map = L.map('map-edit').setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    let marker = null;
    if (latInput.value && lngInput.value) {
        marker = L.marker([lat, lng]).addTo(map);
    }

    map.on('click', function(e) {
        if (marker) map.removeLayer(marker);
        marker = L.marker(e.latlng).addTo(map);
        latInput.value = e.latlng.lat.toFixed(6);
        lngInput.value = e.latlng.lng.toFixed(6);
    });

    latInput.addEventListener('input', updateMarkerFromInputs);
    lngInput.addEventListener('input', updateMarkerFromInputs);

    function updateMarkerFromInputs() {
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng]).addTo(map);
            map.setView([lat, lng], 15);
        }
    }
</script>

@endsection
