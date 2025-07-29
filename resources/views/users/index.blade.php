@extends('layouts.app')
@section('title', 'Gestion des utilisateurs')
@section('content')

<div class="users-management-container">
    <!-- En-tête amélioré avec style Bénin -->
    <div class="page-header">
        <div class="header-background">
            <div class="bg-shape-1"></div>
            <div class="bg-shape-2"></div>
        </div>
        <div class="header-content">
            <h1 class="page-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Gestion des utilisateurs</span>
            </h1>
            <p class="page-description">Liste complète des utilisateurs du système</p>
        </div>
        @can('manage-users')
        <div class="header-actions">
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouvel utilisateur
            </a>
        </div>
        @endcan
    </div>

    <!-- Carte principale -->
    <div class="main-card">
        @if ($users->isEmpty())
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3>Aucun utilisateur trouvé</h3>
            <p>Commencez par créer un nouvel utilisateur</p>
            @can('manage-users')
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un utilisateur
            </a>
            @endcan
        </div>
        @else
        <div class="table-responsive">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôles</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-status {{ $user->active ? 'active' : 'inactive' }}">
                                        {{ $user->active ? 'Actif' : 'Inactif' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="user-email">{{ $user->email }}</td>
                        <td>
                            <div class="roles-list">
                                @foreach($user->getRoleNames() as $role)
                                <span class="role-badge">{{ $role }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                @can('manage-users')
                                <a href="{{ route('users.edit', $user) }}" class="action-btn edit" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-wrapper">
                {{ $users->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Variables CSS alignées avec la charte graphique */
    :root {
        /* Couleurs principales */
        --primary: #1A5F23; /* Vert foncé */
        --secondary: #F9A825; /* Jaune doré */
        --accent: #E30613; /* Rouge béninois */
        --neutral: #F5F5F5; /* Gris clair */
        --black: #333333; /* Noir */
        --white: #FFFFFF; /* Blanc */
        --blue: #0A66C2; /* Bleu institutionnel */
        --success: #4CAF50; /* Vert clair */

        /* Ombres */
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);

        /* Rayons */
        --radius-sm: 0.25rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-full: 9999px;

        /* Transitions */
        --transition-colors: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    /* Styles de base */
    body {
        font-family: 'Roboto', Arial, sans-serif;
        color: var(--black);
        line-height: 1.5;
    }

    /* Conteneur principal */
    .users-management-container {
        max-width: 1800px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
    }

    /* En-tête de page amélioré */
    .page-header {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding: 2rem;
        border-radius: var(--radius-lg);
        overflow: hidden;
        background: linear-gradient(135deg, var(--primary) 0%, var(--success) 100%);
    }

    .header-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    .bg-shape-1 {
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(249, 168, 37, 0.2) 0%, transparent 70%);
    }

    .bg-shape-2 {
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(249, 168, 37, 0.1) 0%, transparent 70%);
    }

    @media (min-width: 768px) {
        .page-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .header-content {
        position: relative;
        z-index: 1;
        flex: 1;
    }

    .page-title {
        font-weight: 700;
        font-size: 2rem;
        color: var(--white);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0 0 0.5rem 0;
    }

    .page-title svg {
        width: 2rem;
        height: 2rem;
        stroke-width: 1.5;
        color: var(--secondary);
    }

    .page-description {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.125rem;
        margin: 0;
    }

    .header-actions {
        position: relative;
        z-index: 1;
        display: flex;
        gap: 1rem;
    }

    /* Boutons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 500;
        font-size: 1rem;
        line-height: 1.5;
        cursor: pointer;
        transition: var(--transition-colors);
        text-decoration: none;
        border: none;
    }

    .btn-primary {
        background: var(--primary);
        color: var(--white);
        box-shadow: var(--shadow-sm);
    }

    .btn-primary:hover {
        background: var(--success);
        box-shadow: var(--shadow-md);
    }

    .btn-primary svg {
        width: 1.25rem;
        height: 1.25rem;
        color: var(--white);
    }

    /* Carte principale */
    .main-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        border: 1px solid var(--neutral);
    }

    /* État vide */
    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-state svg {
        width: 3rem;
        height: 3rem;
        color: var(--black);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        color: var(--black);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--black);
        margin-bottom: 1.5rem;
    }

    /* Tableau */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9375rem;
    }

    .users-table thead {
        background: var(--neutral);
    }

    .users-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--primary);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--neutral);
    }

    .users-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--neutral);
        vertical-align: middle;
    }

    .users-table tr:last-child td {
        border-bottom: none;
    }

    .users-table tr:hover {
        background: var(--neutral);
    }

    .text-right {
        text-align: right;
    }

    /* Informations utilisateur */
    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-avatar {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        flex-shrink: 0;
    }

    .user-details {
        min-width: 0;
    }

    .user-name {
        font-weight: 500;
        color: var(--black);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-status {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 500;
        margin-top: 0.25rem;
    }

    .user-status.active {
        background: var(--secondary);
        color: var(--black);
    }

    .user-status.inactive {
        background: var(--neutral);
        color: var(--black);
    }

    .user-email {
        color: var(--black);
    }

    /* Rôles */
    .roles-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .role-badge {
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-full);
        background: var(--neutral);
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 500;
        white-space: nowrap;
    }

    /* Actions */
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .action-btn {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition-colors);
        cursor: pointer;
        border: none;
        padding: 0;
    }

    .action-btn svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .action-btn.edit {
        background: var(--secondary);
        color: var(--black);
    }

    .action-btn.edit:hover {
        background: #FCD116; /* Jaune clair */
    }

    .action-btn.delete {
        background: var(--accent);
        color: var(--white);
    }

    .action-btn.delete:hover {
        background: #D60515; /* Rouge plus foncé */
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 1.5rem;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
    }

    .pagination li {
        list-style: none;
    }

    .pagination a, .pagination span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: var(--radius-md);
        font-weight: 500;
        text-decoration: none;
    }

    .pagination a {
        color: var(--black);
        background: var(--neutral);
    }

    .pagination a:hover {
        background: #E0E0E0; /* Gris légèrement plus foncé */
    }

    .pagination .active span {
        background: var(--primary);
        color: var(--white);
    }

    .pagination .disabled span {
        color: var(--black);
        background: var(--neutral);
        opacity: 0.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .users-management-container {
            padding: 1.5rem 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.75rem;
        }

        .header-actions {
            width: 100%;
        }

        .btn {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.5rem;
        }

        .user-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .users-table th,
        .users-table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation pour les boutons d'action
        const actionButtons = document.querySelectorAll('.action-btn');

        actionButtons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-2px)';
                button.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            });

            button.addEventListener('mouseleave', () => {
                button.style.transform = '';
                button.style.boxShadow = '';
            });
        });
    });
</script>

@endsection
