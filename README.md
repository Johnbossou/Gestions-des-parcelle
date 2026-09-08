# Gestion des Réserves Foncières (gestion-parcelles)

Application Laravel 12 de gestion du registre numérique des parcelles (réserves foncières) d'une mairie : suivi des parcelles, occupations, attributions, litiges, supervision et journalisation.

## Prérequis

- PHP ≥ 8.2 (testé sous PHP 8.2.0 / XAMPP)
- MySQL / MariaDB ≥ 8 (XAMPP : `C:\xampp\mysql\bin\mysqld.exe`)
- Composer 2
- Extensions PHP : `pdo_mysql`, `zip`, `gd` ou `imagick`, `mbstring`, `fileinfo`, `xml`

## Installation

```bash
copy .env.example .env      # puis adaptez DB_DATABASE / DB_USERNAME / DB_PASSWORD / APP_KEY
composer install --no-interaction --no-scripts
php artisan key:generate
php artisan migrate --seed   # crée le schéma + rôles/permissions + utilisateurs de démonstration
php artisan storage:link
```

> Note reproductibilité : `composer.json` + `composer.lock` sont suivis par git ; un `composer install` depuis zéro reproduit exactement les 48 paquets vérouillés. Ne pas lancer `composer update` sans raison.

## Démarrage (Windows/XAMPP sans service MySQL installé)

Script fourni (démarre MySQL si nécessaire puis le serveur Laravel) :

```
start-dev.bat
```

Ou manuellement :

```bash
# 1. MySQL (si le port 3306 est libre)
C:\xampp\mysql\bin\mysqld.exe --defaults-file=C:\xampp\mysql\bin\my.ini

# 2. Serveur
php artisan serve --host=127.0.0.1 --port=8000
```

Puis ouvrir http://127.0.0.1:8000

### Option service Windows (dans une console administrateur)

```bat
C:\xampp\mysql\bin\mysqld.exe --install MariaDB --defaults-file=C:\xampp\mysql\bin\my.ini
net start MariaDB
```

Le service démarre alors MySQL automatiquement au boot. (Le `start-dev.bat` reste utile pour le serveur Laravel.)

## Base de données

- `DB_DATABASE` : `Reserves_fonc` (charset `utf8mb4`, collation `utf8mb4_unicode_ci`)
- Modèle utilisateur : table `utilisateurs` (l'ancienne table `users` de Laravel n'est pas utilisée)
- `migrate:fresh` reconstruit l'intégralité du schéma (toutes les clés étrangères pointent vers `utilisateurs`).

## Rôles et permissions

Installés par `RolesAndPermissionsSeeder` (Spatie Permissions).

Rôles : `chef_service`, `chef_division`, `Directeur`, `dsi`, `secretaire_executif`, `Consultant`.

Permissions :
`create-parcelles`, `edit-parcelles`, `delete-parcelles`, `view-parcels`, `export-parcels`, `import-parcelles`, `filter-sort-parcels`, `edit-coordinates`, `manage-users`, `manage-litiges`, `view-structure`, `create-view-users`.

## Comptes de démonstration (seed)

| Email | Mot de passe | Rôle |
|---|---|---|
| aline.sossou@mairie.bj | password123 | chef_service |
| jean.dupont@mairie.bj | (non défini par le seed — compte pré-existant) | chef_service |
| sophie.gbedji@mairie.bj | password123 | chef_division |
| koffi.mensah@mairie.bj | DirectorPass123! | Directeur |
| paul.dsi@mairie.bj | password123 | dsi |
| marie.koffi@mairie.bj | password123 | Consultant |

## Fonctionnalités clés

- CRUD parcelles (index + cartes, filtres, recherche, tri, pagination).
- Import Excel/CSV et export XLSX/CSV (Maatwebsite Excel).
- Suivi des occupations (Autorisé / Anarchique / Libre) et statuts d'attribution.
- Coordonnées GPS (Leaflet) avec permissions `edit-coordinates`.
- Journal d'audit automatique (`AuditLog`) sur chaque création/modification/suppression.
- Journal de validation : la modification de champs sensibles par un `chef_service` exige le mot de passe du Directeur (middleware `RequireDirectorApproval`).
- Gestion des utilisateurs & rôles (dsi / assignation de rôles Spatie).
- Authentification + réinitialisation de mot de passe (Sanctum).

## Tests

```bash
vendor\bin\phpunit.bat
```

La suite couvre l'authentification, les permissions, le CRUD parcelles, l'import/export et le contrôle directeur (bdd sqlite en mémoire dans `phpunit.xml`).

## Dépannage

- **Erreur 500 en production sans détail** : vérifier `storage/logs/laravel.log` (`.env` : `APP_DEBUG=true` en développement).
- **`SQLSTATE[HY000] [2002] connection refused`** : MySQL n'est pas démarré (voir Démarrage).
- **`composer install` échoue sur avast/antivirus** : ne pas relancer tant que le verrou est actif ; un simple `composer dump-autoload --no-scripts --optimize` suffit le plus souvent (le `vendor` ne doit pas être régénéré à chaud).