@extends('layouts.app')
@section('title', 'Importer des parcelles')
@section('content')
<div class="import-container">
    <div class="import-header">
        <div class="import-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11.47 1.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1-1.06 1.06l-1.72-1.72V7.5h-1.5V4.06L9.53 5.78a.75.75 0 0 1-1.06-1.06l3-3ZM11.25 7.5V15a.75.75 0 0 0 1.5 0V7.5h3.75a3 3 0 0 1 3 3v9a3 3 0 0 1-3 3h-9a3 3 0 0 1-3-3v-9a3 3 0 0 1 3-3h3.75Z" />
            </svg>
        </div>
        <h1>Importer des parcelles</h1>
        <p>Téléchargez un fichier Excel (.xlsx ou .csv) pour ajouter ou mettre à jour des parcelles en masse.</p>
    </div>

    <div class="import-card">
        <form action="{{ route('parcelles.import') }}" method="POST" enctype="multipart/form-data" class="import-form">
            @csrf

            <div class="file-upload-container">
                <div class="file-upload-area" id="dropZone">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.03 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v4.94a.75.75 0 0 0 1.5 0v-4.94l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd" />
                    </svg>
                    <h3>Glissez-déposez votre fichier ici</h3>
                    <p>ou</p>
                    <label for="file" class="file-browse-btn">Parcourir les fichiers</label>
                    <input type="file" id="file" name="file" accept=".xlsx,.csv" required>
                    <div class="file-details" id="fileDetails"></div>
                </div>
                @error('file')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            @if ($errors->any())
                <div class="error-summary">
                    <h4>Erreurs à corriger :</h4>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3.478 2.405a.75.75 0 0 0-.926.94l2.432 7.905H13.5a.75.75 0 0 1 0 1.5h4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.405Z" />
                    </svg>
                    Importer
                </button>
                <a href="{{ route('parcelles.index') }}" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <div class="import-help">
        <h3>Instructions d'importation</h3>
        <div class="help-content">
            <div class="help-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.676l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 1.5Z" clip-rule="evenodd" />
                </svg>
                <div>
                    <h4>Format requis</h4>
                    <p>Le fichier doit être au format Excel (.xlsx) ou CSV avec une ligne d'en-tête.</p>
                </div>
            </div>
            <div class="help-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 0 2.25 0 1.125 1.125 0 0 0-2.25 0Z"
                    />
                </svg>
                <div>
                    <h4>Colonnes obligatoires</h4>
                    <p>parcelle, arrondissement, secteur, lot, type_occupation, statut_attribution</p>
                </div>
            </div>
            <div class="help-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                    <path
                        d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25
                        a1.5 1.5 0 0 1-1.5 1.5H5.25
                        a1.5 1.5 0 0 1-1.5-1.5V8.25
                        a1.5 1.5 0 0 1 1.5-1.5h5.25
                        a.75.75 0 0 0 0-1.5H5.25Z"
                    />
                </svg>
                <div>
                    <h4>Nouveaux champs d'occupation</h4>
                    <p><strong>type_occupation</strong>: "Autorisé" ou "Anarchique"<br>
                       <strong>details_occupation</strong>: Détails selon le type<br>
                       <strong>reference_autorisation</strong>: N° d'autorisation (pour "Autorisé")<br>
                       <strong>date_autorisation</strong>: Date d'obtention<br>
                       <strong>date_expiration_autorisation</strong>: Date d'expiration</p>
                </div>
            </div>
            <div class="help-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918z" clip-rule="evenodd" />
                </svg>
                <div>
                    <h4>Rétrocompatibilité</h4>
                    <p>Les anciens fichiers avec <strong>type_terrain</strong> sont toujours acceptés :<br>
                       - "Résidentiel", "Commercial", "Institutionnel", "Agricole" → "Autorisé"<br>
                       - "Autre" → "Anarchique"</p>
                </div>
            </div>
        </div>

        <div class="download-template">
            <h4>Télécharger le modèle</h4>
            <p>Utilisez notre modèle Excel pré-formaté pour garantir un import sans erreur :</p>
            <a href="{{ asset('templates/modele-import-parcelles.xlsx') }}" class="btn btn-secondary" download>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75z" clip-rule="evenodd" />
                </svg>
                Télécharger le modèle
            </a>
        </div>
    </div>
</div>

<style>
    /* Variables CSS */
    :root {
        --primary: #1A5F23;
        --primary-light: rgba(26, 95, 35, 0.1);
        --secondary: #F9A825;
        --accent: #E30613;
        --accent-light: rgba(227, 6, 19, 0.1);
        --neutral: #F5F5F5;
        --neutral-dark: #E0E0E0;
        --text: #333333;
        --text-light: #666666;
        --white: #FFFFFF;
        --success: #4CAF50;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        --shadow-hover: 0 8px 24px rgba(0, 0, 0, 0.15);
        --radius: 12px;
        --transition: all 0.3s ease;
    }

    /* Conteneur principal */
    .import-container {
        max-width: 1000px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    /* En-tête */
    .import-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .import-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 1rem;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .import-icon svg {
        width: 32px;
        height: 32px;
        color: var(--primary);
    }

    .import-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 0.5rem;
    }

    .import-header p {
        font-size: 1.1rem;
        color: var(--text-light);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.5;
    }

    /* Carte d'importation */
    .import-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 2rem;
        margin-bottom: 2rem;
        transition: var(--transition);
    }

    .import-card:hover {
        box-shadow: var(--shadow-hover);
    }

    /* Zone de dépôt de fichier */
    .file-upload-container {
        margin-bottom: 1.5rem;
    }

    .file-upload-area {
        border: 2px dashed var(--neutral-dark);
        border-radius: var(--radius);
        padding: 2.5rem 2rem;
        text-align: center;
        transition: var(--transition);
        position: relative;
    }

    .file-upload-area:hover, .file-upload-area.dragover {
        border-color: var(--primary);
        background: var(--primary-light);
    }

    .file-upload-area svg {
        width: 48px;
        height: 48px;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .file-upload-area h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 0.5rem;
    }

    .file-upload-area p {
        color: var(--text-light);
        margin: 0.5rem 0;
    }

    .file-browse-btn {
        display: inline-block;
        background: var(--primary);
        color: var(--white);
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        margin: 0.5rem 0;
    }

    .file-browse-btn:hover {
        background: #14521c;
    }

    .file-upload-area input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .file-details {
        margin-top: 1rem;
        padding: 1rem;
        background: var(--neutral);
        border-radius: 8px;
        display: none;
    }

    .file-details.active {
        display: block;
    }

    /* Actions du formulaire */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.875rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn svg {
        width: 20px;
        height: 20px;
    }

    .btn-primary {
        background: var(--primary);
        color: var(--white);
    }

    .btn-primary:hover {
        background: #14521c;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: var(--neutral);
        color: var(--text);
    }

    .btn-secondary:hover {
        background: var(--neutral-dark);
    }

    /* Messages d'erreur */
    .error-message {
        color: var(--accent);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .error-summary {
        background: var(--accent-light);
        border-left: 4px solid var(--accent);
        padding: 1.25rem;
        border-radius: 4px;
        margin: 1.5rem 0;
    }

    .error-summary h4 {
        color: var(--accent);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .error-summary ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .error-summary li {
        padding: 0.25rem 0;
        color: var(--accent);
    }

    /* Aide à l'importation */
    .import-help {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 2rem;
    }

    .import-help h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .help-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .help-item {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }

    .help-item svg {
        width: 24px;
        height: 24px;
        color: var(--primary);
        flex-shrink: 0;
        margin-top: 0.25rem;
    }

    .help-item h4 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 0.5rem;
    }

    .help-item p {
        color: var(--text-light);
        line-height: 1.5;
        margin: 0;
    }

    .help-item strong {
        color: var(--primary);
        font-weight: 600;
    }

    /* Template download */
    .download-template {
        text-align: center;
        padding: 2rem;
        background: var(--primary-light);
        border-radius: var(--radius);
        border: 2px dashed var(--primary);
    }

    .download-template h4 {
        font-size: 1.25rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .download-template p {
        color: var(--text-light);
        margin-bottom: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .import-container {
            padding: 0 0.5rem;
        }

        .import-card {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .help-content {
            grid-template-columns: 1fr;
        }

        .help-item {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('file');
        const fileDetails = document.getElementById('fileDetails');

        // Gestion du glisser-déposer
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropZone.classList.add('dragover');
        }

        function unhighlight() {
            dropZone.classList.remove('dragover');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            handleFiles(files);
        }

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                fileDetails.innerHTML = `
                    <strong>Fichier sélectionné :</strong> ${file.name}<br>
                    <strong>Taille :</strong> ${formatFileSize(file.size)}<br>
                    <strong>Type :</strong> ${file.type || 'Inconnu'}
                `;
                fileDetails.classList.add('active');
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    });
</script>
@endsection
