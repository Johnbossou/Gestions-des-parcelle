<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="pdfkit-title" content="Liste des Parcelles - Mairie d'Abomey-Calavi">
    <meta name="pdfkit-author" content="Système de Gestion des Parcelles - Mairie d'Abomey-Calavi">
    <meta name="pdfkit-subject" content="Exportation des données des parcelles">
    <title>Exportation des Parcelles - Mairie d'Abomey-Calavi</title>
    <style>
        /* Variables de couleurs et styles */
        :root {
            --primary-color: #1A5F23;
            --primary-light: #E8F5E9;
            --secondary-color: #2D2D2D;
            --accent-color: #008751; /* Vert du Bénin */
            --accent-gold: #FCD116; /* Or du Bénin */
            --accent-red: #E8112D; /* Rouge du Bénin */
            --light-gray: #F5F5F5;
            --border-color: #D1D1D1;
            --text-color: #2D2D2D;
            --text-light: #777777;
            --danger-color: #F44336;
            --success-color: #4CAF50;
            --warning-color: #FFC107;
            --info-color: #2196F3;
        }

        /* Styles généraux */
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 7pt;
            color: var(--text-color);
            margin: 0;
            padding: 0;
            line-height: 1.3;
            background-color: #FFFFFF;
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: 5mm auto;
            padding: 0 5mm;
        }

        /* En-tête avec logo */
        .header {
            text-align: center;
            padding-bottom: 5pt;
            border-bottom: 1pt solid var(--primary-color);
            margin-bottom: 8pt;
            position: relative;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 5pt;
        }

        .logo {
            width: 40px;
            height: 40px;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--accent-gold);
            background: linear-gradient(90deg, var(--accent-red) 33%, var(--accent-gold) 33%, var(--accent-gold) 66%, var(--primary-color) 66%);
            border-radius: 50%;
            font-size: 6pt;
            text-align: center;
        }

        .header h1 {
            font-size: 14pt;
            color: var(--primary-color);
            margin: 0 0 3pt 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
        }

        .header .subtitle {
            font-size: 8pt;
            color: var(--text-light);
            margin: 0 0 5pt 0;
        }

        .header .export-info {
            position: absolute;
            top: 0;
            right: 0;
            text-align: right;
            font-size: 6pt;
            color: var(--text-light);
        }

        .filters-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 4pt;
            font-size: 6.5pt;
            margin-top: 6pt;
            text-align: left;
            background-color: var(--primary-light);
            padding: 6pt;
            border-radius: 3pt;
        }

        .filters-container p {
            margin: 1pt 0;
        }

        .filter-label {
            font-weight: bold;
            color: var(--primary-color);
            display: inline-block;
            min-width: 70px;
        }

        /* Tableau optimisé */
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 8pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6.5pt;
            page-break-inside: auto;
            table-layout: fixed;
        }

        th, td {
            border: 0.5pt solid var(--border-color);
            padding: 4pt 3pt;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        th {
            background-color: var(--primary-color);
            color: #FFFFFF;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 6.5pt;
        }

        tr.group-header {
            background-color: #E0E0E0;
            font-weight: bold;
        }

        tr.group-header td {
            border-bottom: 1pt solid #A0A0A0;
            padding: 2pt 3pt;
            font-size: 7pt;
        }

        tr:nth-child(even):not(.group-header) {
            background-color: var(--light-gray);
        }

        /* Styles conditionnels */
        .text-success {
            color: var(--success-color);
        }

        .text-danger {
            color: var(--danger-color);
        }

        .text-warning {
            color: var(--warning-color);
        }

        .status-badge {
            display: inline-block;
            padding: 1pt 3pt;
            border-radius: 2pt;
            font-size: 6pt;
            font-weight: bold;
            text-align: center;
        }

        .status-attributed {
            background-color: #E8F5E9;
            color: var(--success-color);
        }

        .status-available {
            background-color: #E3F2FD;
            color: var(--info-color);
        }

        .status-pending {
            background-color: #FFF8E1;
            color: var(--warning-color);
        }

        .litige-true {
            background-color: #FFEBEE;
            color: var(--danger-color);
            font-weight: bold;
        }

        /* Gestion des cellules vides */
        td:empty::before {
            content: 'N/A';
            color: var(--text-light);
            font-style: italic;
        }

        /* Styles pour les nombres */
        .number-cell {
            text-align: right;
            font-variant-numeric: tabular-nums;
        }

        /* Colonnes avec largeurs optimisées */
        .col-id { width: 20px; }
        .col-number { width: 35px; }
        .col-arrondissement { width: 45px; }
        .col-secteur { width: 35px; }
        .col-lot { width: 30px; }
        .col-designation { width: 60px; }
        .col-parcelle { width: 45px; }
        .col-superficie { width: 40px; }
        .col-ecart { width: 40px; }
        .col-motif { width: 50px; }
        .col-observations { width: 60px; }
        .col-type { width: 45px; }
        .col-statut { width: 50px; }
        .col-litige { width: 30px; }
        .col-details-litige { width: 60px; }
        .col-structure { width: 50px; }
        .col-date { width: 45px; }
        .col-coords { width: 45px; }
        .col-agent { width: 50px; }
        .col-responsable { width: 40px; }
        .col-updatedby { width: 45px; }
        .col-createdby { width: 45px; }

        /* Pied de page */
        .footer {
            text-align: center;
            font-size: 6pt;
            color: var(--text-light);
            border-top: 0.5pt solid var(--border-color);
            padding: 3pt 0;
            margin-top: 8pt;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            padding: 0 5mm;
        }

        .footer p {
            margin: 0;
        }

        /* Marges pour PDF */
        @page {
            margin: 10mm 5mm 15mm 5mm;
            size: landscape;
        }

        @page :first {
            margin-top: 15mm;
        }

        /* Sauts de page */
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        /* Résumé */
        .summary {
            font-size: 7pt;
            margin: 6pt 0;
            padding: 4pt;
            background-color: var(--light-gray);
            border-radius: 3pt;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 5pt;
        }

        .summary-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .summary-value {
            font-weight: bold;
            font-size: 8pt;
            color: var(--primary-color);
        }

        /* Indicateur de continuation */
        .continued {
            font-style: italic;
            color: var(--text-light);
            text-align: center;
            font-size: 6pt;
            padding: 2pt;
        }

        /* Texte tronqué */
        .truncated {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête avec logo du Bénin -->
        <div class="header">
            <div class="logo-container">
                <div class="logo">République<br>du<br>Bénin</div>
                <div>
                    <h1>Mairie d'Abomey-Calavi</h1>
                    <p class="subtitle">Service du Domaine et du Patrimoine</p>
                </div>
            </div>

            <div class="export-info">
                Exporté le {{ \Carbon\Carbon::now()->format('d/m/Y à H:i') }}<br>
                {{ $parcelles->count() }} parcelle(s)
            </div>

            @if (!empty($filters))
                <div class="filters-container">
                    <p><strong>Filtres appliqués :</strong></p>
                    @if (!empty($filters['arrondissement']))
                        <p><span class="filter-label">Arrondissement :</span> {{ $filters['arrondissement'] }}</p>
                    @endif
                    @if (!empty($filters['type_terrain']))
                        <p><span class="filter-label">Type de Terrain :</span> {{ $filters['type_terrain'] }}</p>
                    @endif
                    @if (!empty($filters['statut_attribution']))
                        <p><span class="filter-label">Statut :</span> <span class="status-badge status-{{ $filters['statut_attribution'] }}">{{ ucfirst($filters['statut_attribution']) }}</span></p>
                    @endif
                    @if (isset($filters['litige']) && $filters['litige'] !== '')
                        <p><span class="filter-label">Litige :</span> {{ $filters['litige'] ? 'Oui' : 'Non' }}</p>
                    @endif
                    @if (!empty($filters['structure']))
                        <p><span class="filter-label">Structure :</span> {{ $filters['structure'] }}</p>
                    @endif
                    @if (!empty($filters['ancienne_superficie_min']) || !empty($filters['ancienne_superficie_max']))
                        <p><span class="filter-label">Superficie :</span>
                            @if (!empty($filters['ancienne_superficie_min']))
                                Min {{ number_format($filters['ancienne_superficie_min'], 2) }} m²
                            @endif
                            @if (!empty($filters['ancienne_superficie_max']))
                                @if (!empty($filters['ancienne_superficie_min'])) - @endif
                                Max {{ number_format($filters['ancienne_superficie_max'], 2) }} m²
                            @endif
                        </p>
                    @endif
                </div>
            @else
                <div class="filters-container">
                    <p><strong>Aucun filtre appliqué</strong></p>
                </div>
            @endif
        </div>

        <!-- Résumé statistique -->
        <div class="summary">
            <div class="summary-item">
                <span>Total parcelles</span>
                <span class="summary-value">{{ $parcelles->count() }}</span>
            </div>
            <div class="summary-item">
                <span>Superficie totale</span>
                <span class="summary-value">{{ number_format($parcelles->sum('ancienne_superficie'), 2) }} m²</span>
            </div>
            <div class="summary-item">
                <span>Avec litige</span>
                <span class="summary-value">{{ $parcelles->where('litige', true)->count() }}</span>
            </div>
            <div class="summary-item">
                <span>Attribuées</span>
                <span class="summary-value">{{ $parcelles->where('statut_attribution', 'attribué')->count() }}</span>
            </div>
            <div class="summary-item">
                <span>Superficie moyenne</span>
                <span class="summary-value">{{ $parcelles->count() > 0 ? number_format($parcelles->avg('ancienne_superficie'), 2) : 0 }} m²</span>
            </div>
        </div>

        <!-- Tableau des parcelles -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="col-id">ID</th>
                        <th class="col-number">N°</th>
                        <th class="col-arrondissement">Arrond.</th>
                        <th class="col-secteur">Sect.</th>
                        <th class="col-lot">Lot</th>
                        <th class="col-designation">Désignation</th>
                        <th class="col-parcelle">Parcelle</th>
                        <th class="col-superficie">Anc. Sup.</th>
                        <th class="col-superficie">Nouv. Sup.</th>
                        <th class="col-ecart">Écart</th>
                        <th class="col-motif">Motif</th>
                        <th class="col-observations">Observ.</th>
                        <th class="col-type">Type</th>
                        <th class="col-statut">Statut</th>
                        <th class="col-litige">Litige</th>
                        <th class="col-details-litige">Dét. Litige</th>
                        <th class="col-structure">Structure</th>
                        <th class="col-date">Mise à jour</th>
                        <th class="col-coords">Latitude</th>
                        <th class="col-coords">Longitude</th>
                        <th class="col-agent">Agent</th>
                        <th class="col-responsable">Resp. ID</th>
                        <th class="col-updatedby">Modifié par</th>
                        <th class="col-createdby">Créé par</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $currentArrondissement = null;
                    @endphp

                    @foreach ($parcelles as $index => $parcelle)
                        @if ($currentArrondissement !== $parcelle->arrondissement)
                            @php
                                $currentArrondissement = $parcelle->arrondissement;
                                $arrondissementCount = $parcelles->where('arrondissement', $currentArrondissement)->count();
                            @endphp
                            <tr class="group-header">
                                <td colspan="24">
                                    Arrondissement: {{ $currentArrondissement ?? 'Non spécifié' }}
                                    ({{ $arrondissementCount }} parcelle{{ $arrondissementCount > 1 ? 's' : '' }})
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td class="col-id">{{ $parcelle->id }}</td>
                            <td class="col-number">{{ $parcelle->numero ?? 'N/A' }}</td>
                            <td class="col-arrondissement">{{ $parcelle->arrondissement ?? 'N/A' }}</td>
                            <td class="col-secteur">{{ $parcelle->secteur ?? 'N/A' }}</td>
                            <td class="col-lot">{{ $parcelle->lot ?? 'N/A' }}</td>
                            <td class="col-designation truncated" title="{{ $parcelle->designation ?? '' }}">{{ $parcelle->designation ? (strlen($parcelle->designation) > 20 ? substr($parcelle->designation, 0, 20) . '...' : $parcelle->designation) : 'N/A' }}</td>
                            <td class="col-parcelle">{{ $parcelle->parcelle ?? 'N/A' }}</td>
                            <td class="col-superficie number-cell">{{ $parcelle->ancienne_superficie ? number_format($parcelle->ancienne_superficie, 2) . ' m²' : 'N/A' }}</td>
                            <td class="col-superficie number-cell">{{ $parcelle->nouvelle_superficie ? number_format($parcelle->nouvelle_superficie, 2) . ' m²' : 'N/A' }}</td>
                            <td class="col-ecart number-cell {{ $parcelle->ecart_superficie > 0 ? 'text-success' : ($parcelle->ecart_superficie < 0 ? 'text-danger' : '') }}">
                                {{ $parcelle->ecart_superficie ? ($parcelle->ecart_superficie > 0 ? '+' : '') . number_format($parcelle->ecart_superficie, 2) . ' m²' : 'N/A' }}
                            </td>
                            <td class="col-motif truncated" title="{{ $parcelle->motif ?? '' }}">{{ $parcelle->motif ? (strlen($parcelle->motif) > 15 ? substr($parcelle->motif, 0, 15) . '...' : $parcelle->motif) : 'N/A' }}</td>
                            <td class="col-observations truncated" title="{{ $parcelle->observations ?? '' }}">{{ $parcelle->observations ? (strlen($parcelle->observations) > 20 ? substr($parcelle->observations, 0, 20) . '...' : $parcelle->observations) : 'N/A' }}</td>
                            <td class="col-type">{{ $parcelle->type_terrain ?? 'N/A' }}</td>
                            <td class="col-statut">
                                @if($parcelle->statut_attribution)
                                    <span class="status-badge status-{{ $parcelle->statut_attribution }}">
                                        {{ strlen($parcelle->statut_attribution) > 10 ? substr(ucfirst($parcelle->statut_attribution), 0, 10) . '...' : ucfirst($parcelle->statut_attribution) }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="col-litige {{ $parcelle->litige ? 'litige-true' : '' }}">
                                {{ $parcelle->litige === null ? 'N/D' : ($parcelle->litige ? 'Oui' : 'Non') }}
                            </td>
                            <td class="col-details-litige truncated" title="{{ $parcelle->details_litige ?? '' }}">{{ $parcelle->details_litige ? (strlen($parcelle->details_litige) > 15 ? substr($parcelle->details_litige, 0, 15) . '...' : $parcelle->details_litige) : 'N/A' }}</td>
                            <td class="col-structure truncated" title="{{ $parcelle->structure ?? '' }}">{{ $parcelle->structure ? (strlen($parcelle->structure) > 15 ? substr($parcelle->structure, 0, 15) . '...' : $parcelle->structure) : 'N/A' }}</td>
                            <td class="col-date">{{ $parcelle->date_mise_a_jour ? \Carbon\Carbon::parse($parcelle->date_mise_a_jour)->format('d/m/Y') : 'N/A' }}</td>
                            <td class="col-coords">{{ $parcelle->latitude ? number_format($parcelle->latitude, 6) : 'N/A' }}</td>
                            <td class="col-coords">{{ $parcelle->longitude ? number_format($parcelle->longitude, 6) : 'N/A' }}</td>
                            <td class="col-agent truncated" title="{{ $parcelle->agent ?? '' }}">{{ $parcelle->agent ? (strlen($parcelle->agent) > 15 ? substr($parcelle->agent, 0, 15) . '...' : $parcelle->agent) : 'N/A' }}</td>
                            <td class="col-responsable">{{ $parcelle->responsable_id ?? 'N/A' }}</td>
                            <td class="col-updatedby">{{ $parcelle->updated_by ?? 'N/A' }}</td>
                            <td class="col-createdby">{{ $parcelle->created_by ?? 'N/A' }}</td>
                        </tr>

                        <!-- Indicateur de continuation pour les longs tableaux -->
                        @if (($index + 1) % 25 == 0)
                            <tr>
                                <td colspan="24" class="continued">Suite du tableau à la page suivante...</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <div class="footer-content">
                <p>Mairie d'Abomey-Calavi - République du Bénin</p>
                <p>Page <span class="pageNumber"></span> sur <span class="totalPages"></span></p>
                <p>Exporté le {{ \Carbon\Carbon::now()->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Script pour la numérotation des pages en PDF -->
    <script>
        // Cette partie sera exécutée par le générateur de PDF
        if (typeof PDFKit !== 'undefined') {
            const pageCount = Math.ceil(document.querySelectorAll('tbody tr').length / 25);
            document.querySelectorAll('.pageNumber').forEach(el => {
                el.textContent = 1; // Serait remplacé dynamiquement par PDFKit
            });
            document.querySelectorAll('.totalPages').forEach(el => {
                el.textContent = pageCount;
            });
        }
    </script>
</body>
</html>
