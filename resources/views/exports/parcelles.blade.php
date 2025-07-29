<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportation des Parcelles</title>
    <style>
        /* Styles généraux */
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 10pt;
            color: #333333;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }

        /* En-tête */
        .header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid #1A5F23; /* --primary */
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 16pt;
            color: #1A5F23; /* --primary */
            margin: 0;
        }

        .header p {
            font-size: 9pt;
            color: #333333;
            margin: 5px 0;
        }

        .header .filters {
            font-size: 8pt;
            color: #666666;
            margin-top: 10px;
        }

        .header .filters span {
            font-weight: bold;
        }

        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 8pt;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #1A5F23; /* --primary */
            color: #FFFFFF; /* --white */
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #F5F5F5; /* --neutral */
        }

        tr:hover {
            background-color: #FCD116; /* --secondary-light */
        }

        td {
            max-width: 150px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Gestion des cellules vides */
        td:empty::after {
            content: 'N/A';
            color: #666666;
        }

        /* Pied de page */
        .footer {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 8pt;
            color: #666666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        /* Marges pour PDF */
        @page {
            margin: 20mm;
        }

        /* Styles pour les longues chaînes */
        .truncate {
            max-width: 100px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <h1>Liste des Parcelles</h1>
            <p>Gestion des réserves de l'État - Exporté le {{ date('d/m/Y à H:i') }}</p>
            @if (!empty($filters))
                <div class="filters">
                    <p><strong>Filtres appliqués :</strong></p>
                    @if (!empty($filters['arrondissement']))
                        <p><span>Arrondissement :</span> {{ $filters['arrondissement'] }}</p>
                    @endif
                    @if (!empty($filters['type_terrain']))
                        <p><span>Type de Terrain :</span> {{ $filters['type_terrain'] }}</p>
                    @endif
                    @if (!empty($filters['statut_attribution']))
                        <p><span>Statut Attribution :</span> {{ ucfirst($filters['statut_attribution']) }}</p>
                    @endif
                    @if (isset($filters['litige']) && $filters['litige'] !== '')
                        <p><span>Litige :</span> {{ $filters['litige'] ? 'Oui' : 'Non' }}</p>
                    @endif
                    @if (!empty($filters['structure']))
                        <p><span>Structure :</span> {{ $filters['structure'] }}</p>
                    @endif
                    @if (!empty($filters['ancienne_superficie_min']) || !empty($filters['ancienne_superficie_max']))
                        <p><span>Superficie :</span>
                            @if (!empty($filters['ancienne_superficie_min']))
                                Min {{ $filters['ancienne_superficie_min'] }} m²
                            @endif
                            @if (!empty($filters['ancienne_superficie_max']))
                                @if (!empty($filters['ancienne_superficie_min'])) - @endif
                                Max {{ $filters['ancienne_superficie_max'] }} m²
                            @endif
                        </p>
                    @endif
                </div>
            @else
                <div class="filters">
                    <p><strong>Aucun filtre appliqué</strong></p>
                </div>
            @endif
        </div>

        <!-- Tableau des parcelles -->
        <table>
            <thead>
                <tr>
                    @foreach (['ID', 'Numéro', 'Arrondissement', 'Secteur', 'Lot', 'Désignation', 'Parcelle', 'Ancienne Superficie', 'Nouvelle Superficie', 'Écart Superficie', 'Motif', 'Observations', 'Type Terrain', 'Statut Attribution', 'Litige', 'Détails Litige', 'Structure', 'Date Mise à Jour', 'Latitude', 'Longitude', 'Agent', 'Responsable ID', 'Mis à Jour Par', 'Créé Par'] as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($parcelles as $parcelle)
                    <tr>
                        <td>{{ $parcelle->id }}</td>
                        <td>{{ $parcelle->numero ?? 'N/A' }}</td>
                        <td>{{ $parcelle->arrondissement ?? 'N/A' }}</td>
                        <td>{{ $parcelle->secteur ?? 'N/A' }}</td>
                        <td>{{ $parcelle->lot ?? 'N/A' }}</td>
                        <td>{{ $parcelle->designation ?? 'N/A' }}</td>
                        <td>{{ $parcelle->parcelle ?? 'N/A' }}</td>
                        <td>{{ $parcelle->ancienne_superficie ? number_format($parcelle->ancienne_superficie, 2) . ' m²' : 'N/A' }}</td>
                        <td>{{ $parcelle->nouvelle_superficie ? number_format($parcelle->nouvelle_superficie, 2) . ' m²' : 'N/A' }}</td>
                        <td>{{ $parcelle->ecart_superficie ? ($parcelle->ecart_superficie > 0 ? '+' : '') . number_format($parcelle->ecart_superficie, 2) . ' m²' : 'N/A' }}</td>
                        <td class="truncate">{{ $parcelle->motif ?? 'N/A' }}</td>
                        <td class="truncate">{{ $parcelle->observations ?? 'N/A' }}</td>
                        <td>{{ $parcelle->type_terrain ?? 'N/A' }}</td>
                        <td>{{ $parcelle->statut_attribution ? ucfirst($parcelle->statut_attribution) : 'N/A' }}</td>
                        <td>{{ $parcelle->litige === null ? 'Non défini' : ($parcelle->litige ? 'Oui' : 'Non') }}</td>
                        <td class="truncate">{{ $parcelle->details_litige ?? 'N/A' }}</td>
                        <td class="truncate">{{ $parcelle->structure ?? 'N/A' }}</td>
                        <td>{{ $parcelle->date_mise_a_jour ? \Carbon\Carbon::parse($parcelle->date_mise_a_jour)->format('d/m/Y') : 'N/A' }}</td>
                        <td>{{ $parcelle->latitude ? number_format($parcelle->latitude, 6) : 'N/A' }}</td>
                        <td>{{ $parcelle->longitude ? number_format($parcelle->longitude, 6) : 'N/A' }}</td>
                        <td>{{ $parcelle->agent ?? 'N/A' }}</td>
                        <td>{{ $parcelle->responsable_id ?? 'N/A' }}</td>
                        <td>{{ $parcelle->updated_by ?? 'N/A' }}</td>
                        <td>{{ $parcelle->created_by ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pied de page -->
        <div class="footer">
            Page <span class="pageNumber"></span> / <span class="totalPages"></span>
        </div>
    </div>
</body>
</html>
