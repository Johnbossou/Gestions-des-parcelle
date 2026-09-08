<?php
require __DIR__.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// EN-TÊTES basés sur votre structure d'export
$headers = [
    'Arrondissement',      // ✅ Requis
    'Secteur',             // ✅ Requis
    'Lot',                 // ✅ Requis
    'Parcelle',            // ✅ Requis
    'Designation',
    'Ancienne_Superficie',
    'Nouvelle_Superficie',
    'Motif',
    'Observations',
    'Type_Occupation',     // ✅ Requis
    'Details_Occupation',
    'Reference_Autorisation',
    'Date_Autorisation',
    'Date_Expiration_Autorisation',
    'Statut_Attribution',  // ✅ Requis
    'Litige',
    'Details_Litige',
    'Structure',
    'Latitude',
    'Longitude',
    'Agent_ID',
    'Responsable_ID'
];

// Ajouter les en-têtes
$sheet->fromArray($headers, null, 'A1');

// DONNÉES D'EXEMPLE basées sur votre export
$sampleData = [
    [
        'Godomey',       // Arrondissement
        'Ouest',         // Secteur
        74,              // Lot
        'PAR-0001',      // Parcelle
        'Parcelle K4VoH', // Designation
        86.3,            // Ancienne_Superficie
        192.4,           // Nouvelle_Superficie
        'Relevés GPS',   // Motif
        'Données incomplètes', // Observations
        'Libre',         // Type_Occupation
        'Parcelle libre sans occupation physique actuelle. Terrain disponible.', // Details_Occupation
        '',              // Reference_Autorisation (vide pour Libre)
        '',              // Date_Autorisation
        '',              // Date_Expiration_Autorisation
        'non attribué',  // Statut_Attribution
        'Non',           // Litige
        '',              // Details_Litige
        'Marché local',  // Structure
        6.3533,          // Latitude
        2.3409,          // Longitude
        6,               // Agent_ID
        5                // Responsable_ID
    ],
    [
        'Akassato',      // Arrondissement
        'Est',           // Secteur
        41,              // Lot
        'PAR-0002',      // Parcelle
        'Parcelle mtOzD', // Designation
        177.3,           // Ancienne_Superficie
        165.0,           // Nouvelle_Superficie
        'Mise à jour cadastrale', // Motif
        'Aucune observation', // Observations
        'Autorisé',      // Type_Occupation
        'Occupation régulière conforme aux normes urbaines. Parcelle légalement enregistrée et conforme au plan d\'urbanisme.', // Details_Occupation
        'AUT-7NfybTe5',  // Reference_Autorisation
        '2025-01-29',    // Date_Autorisation
        '2029-01-29',    // Date_Expiration_Autorisation
        'attribué',      // Statut_Attribution
        'Non',           // Litige
        '',              // Details_Litige
        'Centre de santé', // Structure
        6.3534,          // Latitude
        2.3540,          // Longitude
        1,               // Agent_ID
        5                // Responsable_ID
    ],
    [
        'Godomey',       // Arrondissement
        'Centre',        // Secteur
        89,              // Lot
        'PAR-0003',      // Parcelle
        'Parcelle vcACz', // Designation
        122.7,           // Ancienne_Superficie
        100.6,           // Nouvelle_Superficie
        'Relevés GPS',   // Motif
        'Données incomplètes', // Observations
        'Anarchique',    // Type_Occupation
        'Occupation non conforme aux normes urbaines', // Details_Occupation
        '',              // Reference_Autorisation (vide pour Anarchique)
        '',              // Date_Autorisation
        '',              // Date_Expiration_Autorisation
        'non attribué',  // Statut_Attribution
        'Oui',           // Litige
        'Occupation illégale constatée', // Details_Litige
        'École publique', // Structure
        6.3542,          // Latitude
        2.3588,          // Longitude
        3,               // Agent_ID
        5                // Responsable_ID
    ]
];

// Ajouter les données d'exemple
$sheet->fromArray($sampleData, null, 'A2');

// STYLISATION PROFESSIONNELLE
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
        'size' => 11
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '1A5F23'] // Vert de votre thème
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER
    ]
];

// Appliquer le style aux en-têtes
$sheet->getStyle('A1:V1')->applyFromArray($headerStyle);

// Ajuster la largeur des colonnes automatiquement
foreach (range('A', 'V') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

// Geler la première ligne (en-têtes visibles lors du défilement)
$sheet->freezePane('A2');

// Ajouter une note d'information
$sheet->setCellValue('A' . (count($sampleData) + 3), 'NOTES :');
$sheet->setCellValue('A' . (count($sampleData) + 4), '- Les colonnes en vert sont OBLIGATOIRES');
$sheet->setCellValue('A' . (count($sampleData) + 5), '- Type_Occupation: Autorisé, Anarchique, Libre');
$sheet->setCellValue('A' . (count($sampleData) + 6), '- Statut_Attribution: attribué, non attribué');
$sheet->setCellValue('A' . (count($sampledata) + 7), '- Litige: Oui, Non');

// Créer le dossier templates s'il n'existe pas
$templateDir = __DIR__.'/public/templates';
if (!is_dir($templateDir)) {
    mkdir($templateDir, 0755, true);
}

// Sauvegarder le fichier
$writer = new Xlsx($spreadsheet);
$filePath = $templateDir.'/modele-import-parcelles.xlsx';
$writer->save($filePath);

echo "✅ Template d'importation créé avec succès !\n";
echo "📁 Emplacement : $filePath\n";
echo "📊 Nombre de colonnes : " . count($headers) . "\n";
echo "📝 Lignes d'exemple : " . count($sampleData) . "\n";

// Vérification finale
if (file_exists($filePath)) {
    $fileSize = filesize($filePath);
    echo "🎉 Fichier créé avec succès ! Taille : " . round($fileSize/1024, 2) . " KB\n";
    echo "🚀 Le template est prêt à être utilisé sur la page d'importation !\n";
} else {
    echo "❌ Erreur lors de la création du fichier.\n";
}
?>
