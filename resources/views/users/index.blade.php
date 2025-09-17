@extends('layouts.app')
@section('title', 'Gestion des utilisateurs')
@section('content')

<div class="users-management-container" role="main">
    <!-- En-tête amélioré -->
    <div class="page-header" aria-labelledby="page-title">
        <div class="header-content">
            <h1 class="page-title" id="page-title">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M极 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 极 4 4 0 018 0z" />
                </svg>
                <span>Gestion des utilisateurs</span>
            </h1>
            <p class="page-description">Gérez facilement vos utilisateurs avec une interface moderne et intuitive</p>
        </div>
        @can('manage-users')
        <div class="header-actions">
            <a href="{{ route('users.create') }}" class="btn btn-primary" aria-label="Créer un nouvel utilisateur">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouvel utilisateur
            </a>
        </div>
        @endcan
    </div>

    <!-- Barre de recherche -->
    <div class="search-container">
        <div class="search-wrapper">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0极" />
            </svg>
            <input type="text" id="user-search" placeholder="Rechercher un utilisateur..." aria-label="Rechercher des utilisateurs par nom ou email">
        </div>
    </div>

    <!-- Carte principale -->
    <div class="main-card">
        @if ($users->isEmpty())
        <div class="empty-state" role="alert">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3>Aucun utilisateur trouvé</h3>
            <p>Commencez par créer un nouvel utilisateur ou ajustez votre recherche</p>
            @can('manage-users')
            <a href="{{ route('users.create') }}" class="btn btn-primary" aria-label="Ajouter un nouvel utilisateur">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un utilisateur
            </a>
            @endcan
        </div>
        @else
        <div class="table-responsive">
            <table class="users-table" role="grid">
                <thead>
                    <tr>
                        <th>
                            <button class="sort-btn" data-sort="name" aria-label="Trier par nom">
                                Nom
                                <svg aria-hidden="true" class="sort-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </button>
                        </th>
                        <th>
                            <button class="sort-btn" data-sort="email" aria-label="Trier par email">
                                Email
                                <svg aria-hidden="true" class="sort-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4极-4 4l-4-4" />
                                </svg>
                            </button>
                        </th>
                        <th>Rôles</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="users-table-body">
                    @foreach ($users as $user)
                    <tr class="user-row" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}">
                        <td>
                            <div class="user-info">
                                <div class="user-avatar" aria-label="Avatar de {{ $user->name }}">
                                    @if ($user->avatar)
                                        <img src="{{ $user->avatar }}" alt="Avatar de {{ $user->name }}" class="avatar-img">
                                    @else
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    @endif
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
                                <a href="{{ route('users.edit', $user) }}" class="action-btn edit" title="Modifier" aria-label="Modifier l'utilisateur {{ $user->name }}">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button class="action-btn delete" data-user-id="{{ $user->id }}" title="Supprimer" aria-label="Supprimer l'utilisateur {{ $user->name }}">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination-container" role="navigation" aria-label="Navigation de la pagination">
                <div class="pagination-wrapper">
                    <ul class="pagination">
                        @if ($users->onFirstPage())
                            <li class="disabled" aria-disabled="true">
                                <span class="pagination-arrow">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                    </svg>
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $users->previousPageUrl() }}" class="pagination-arrow" rel="prev" aria-label="Page précédente">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 极 16">
                                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                    </svg>
                                </a>
                            </li>
                        @endif

                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                <li class="active" aria-current="page">
                                    <span class="pagination-number">{{ $page }}</span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $url }}" class="pagination-number" aria-label="Page {{ $page }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        @if ($users->hasMorePages())
                            <li>
                                <a href="{{ $users->nextPageUrl() }}" class="pagination-arrow" rel="next" aria-label="Page suivante">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </a>
                            </li>
                        @else
                            <li class="disabled" aria-disabled="true">
                                <span class="pagination-arrow">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0极6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Modale de confirmation -->
    <div class="modal" id="delete-modal" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-content">
            <h3 id="modal-title">Confirmer la suppression</h3>
            <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.</p>
            <div class="modal-actions">
                <button class="btn btn-secondary" id="cancel-delete" aria-label="Annuler la suppression">Annuler</button>
                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" aria-label="Confirmer la suppression">Supprimer</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast de notification -->
    <div class="toast" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <span id="toast-message"></span>
        <button class="toast-close" aria-label="Fermer la notification">✕</button>
    </div>
</div>

<style>
    :root {
        /* Couleurs principales (charte graphique Bénin) */
        --primary: #1A5F23;
        --secondary: #F9A825;
        --accent: #E30613;
        --neutral: #F5F5F5;
        --black: #333333;
        --white: #FFFFFF;
        --blue: #0A66C2;
        --success: #4CAF50;

        /* Ombres */
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 8px rgba(0, 0, 0, 极.15);
        --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.2);

        /* Rayons */
        --radius-sm: 0.25rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-full: 9999px;

        /* Transitions */
        --transition-all: all 0.3s ease;
    }

    /* Conteneur principal */
    .users-management-container {
        max-width: 1800px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
        animation: fadeIn 0.5s ease-out;
    }

    /* En-tête amélioré */
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
        box-shadow: var(--shadow-lg);
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
        animation: slideInLeft 0.6s ease-out;
    }

    .page-title {
        font-weight: 700;
        font-size: 2.25rem;
        color: var(--white);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0 0 0.5rem 0;
    }

    .page-title svg {
        width: 2.5rem;
        height: 2.5rem;
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
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 500;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition-all);
        text-decoration: none;
        border: none;
        overflow: hidden;
    }

    .btn::after {
        content: '';
        position: absolute;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: scale(0);
        transition: transform 0.3s ease;
    }

    .btn:active::after {
        transform: scale(1);
        transition: transform 0s;
    }

    .btn-primary {
        background: var(--primary);
        color: var(--white);
        box-shadow: var(--shadow-sm);
    }

    .btn-primary:hover {
        background: var(--success);
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: var(--neutral);
        color: var(--black);
    }

    .btn-secondary:hover {
        background: var(--secondary);
        color: var(--black);
        transform: translateY(-2px);
    }

    .btn-danger {
        background: var(--accent);
        color: var(--white);
    }

    .btn-danger:hover {
        background: #D60515;
        transform: translateY(-2px);
    }

    .btn sv极 {
        width: 1.25rem;
        height: 1.25rem;
    }

    /* Barre de recherche */
    .search-container {
        margin: 1.5rem 0;
        animation: slideInUp 0.6s ease-out;
    }

    .search-wrapper {
        position: relative;
        max-width: 400px;
        display: flex;
        align-items: center;
        background: var(--white);
        border-radius: var(--极-md);
        padding: 0.5rem 1rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-all);
    }

    .search-wrapper:focus-within {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .search-wrapper svg {
        width: 1.5rem;
        height: 1.5rem;
        color: var(--primary);
        margin-right: 0.5rem;
    }

    #user-search {
        border: none;
        outline: none;
        width: 100%;
        font-size: 1rem;
        color: var(--black);
    }

    /* Carte principale */
    .main-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        border: 1px solid var(--neutral);
        animation: slideInUp 0.8s ease-out;
    }

    /* État vide */
    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
        animation: fadeIn 0.5s ease-out;
    }

    .empty-state svg {
        width: 4rem;
        height: 4rem;
        color: var(--primary);
        margin-bottom: 1rem;
        animation: pulse 2s infinite;
    }

    .empty-state h3 {
        font-size: 1.5rem;
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
        transform: scale(1.01);
        transition: var(--transition-all);
    }

    .text-right {
        text-align: right;
    }

    /* Bouton de tri */
    .sort-btn {
        background: none;
        border: none;
        font: inherit;
        color: inherit;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sort-btn:hover .sort-icon {
        transform: scale(1.2);
    }

    .sort-icon {
        width: 1rem;
        height: 1rem;
        transition: var(--transition-all);
    }

    .sort-btn.asc .极-icon {
        transform: rotate(180deg);
    }

    /* Informations utilisateur */
    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-avatar {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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
        padding: 0.25rem 0.75rem;
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
        transition: var(--transition-all);
    }

    .role-badge:hover {
        background: var(--secondary);
        color: var(--black);
    }

    /* Actions */
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .action-btn {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition-all);
        cursor: pointer;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .action-btn::after {
        content: '';
        position: absolute;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: scale(0);
        transition: transform 0.3s ease;
    }

    .action-btn:active::after {
        transform: scale(1);
        transition: transform 0s;
    }

    .action-btn.edit {
        background: var(--secondary);
        color: var(--black);
    }

    .action-btn.edit:hover {
        background: #FCD116;
        transform: translateY(-2px) rotate(5deg);
    }

    .action-btn.delete {
        background: var(--accent);
        color: var(--white);
    }

    .action-btn.delete:hover {
        background: #D60515;
        transform: translateY(-2px) rotate(-5deg);
    }

    .action-btn svg {
        width: 1.5rem;
        height: 1.5rem;
    }

    /* Pagination */
    .pagination-container {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0;
        animation: slideInUp 0.4s ease forwards;
    }

    .pagination-arrow, .pagination-number {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 50%;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition-all);
        color: var(--primary);
        background-color: transparent;
        border: 2px solid transparent;
    }

    .pagination a.pagination-arrow:hover,
    .pagination a.pagination-number:hover {
        background-color: rgba(26, 95, 35, 0.1);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .pagination .active .pagination-number {
        background-color: var(--primary);
        color: var(--white);
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
    }

    .pagination .disabled .pagination-arrow {
        color: #ccc;
        cursor: not-allowed;
    }

    .pagination-arrow svg {
        width: 1rem;
        height: 1rem;
        transition: transform 0.3s ease;
    }

    .pagination a.pagination-arrow:hover svg {
        transform: scale(1.2);
    }

    /* Modale */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .modal-content {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--radius-lg);
        max-width: 500px;
        width: 90%;
        box-shadow: var(--shadow-lg);
        animation: slideInDown 0.3s ease-out;
    }

    .modal h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: var(--black);
    }

    .modal p {
        color: var(--black);
        margin-bottom: 1.5rem;
    }

    .modal-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    /* Toast */
    .toast {
        display: none;
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background: var(--primary);
        color: var(--white);
        padding: 1rem 1.5rem;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideInRight 0.3s ease-out;
    }

    .toast-close {
        background: none;
        border: none;
        color: var(--white);
        font-size: 1rem;
        cursor: pointer;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slide极Down {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
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
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        .pagination-arrow, .pagination-number {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 0.9rem;
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

        .pagination {
            gap: 0.25rem;
        }

        .pagination-arrow, .pagination-number {
            width: 2.25rem;
            height: 2.25rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Recherche en temps réel
        const searchInput = document.getElementById('user-search');
        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase();
            document.querySelectorAll('.user-row').forEach(row => {
                const name = row.dataset.name;
                const email = row.dataset.email;
                row.style.display = (name.includes(query) || email.includes(query)) ? '' : 'none';
            });
        });

        // Tri des colonnes
        const sortButtons = document.querySelectorAll('.sort-btn');
        sortButtons.forEach(button => {
            button.addEventListener('click', () => {
                const sortKey = button.dataset.sort;
                const isAsc = !button.classList.contains('asc');
                button.classList.toggle('asc');

                const rows = Array.from(document.querySelectorAll('.user-row'));
                rows.sort((a, b) => {
                    const aValue = a.dataset[sortKey];
                    const bValue = b.dataset[sortKey];
                    return isAsc ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
                });

                const tbody = document.getElementById('users-table-body');
                rows.forEach(row => tbody.appendChild(row));
            });
        });

        // Modale de suppression
        const deleteButtons = document.querySelectorAll('.action-btn.delete');
        const modal = document.getElementById('delete-modal');
        const cancelButton = document.getElementById('cancel-delete');
        const deleteForm = document.getElementById('delete-form');

        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const userId = button.dataset.userId;
                deleteForm.action = `{{ route('users.destroy', ':id') }}`.replace(':id', userId);
                modal.style.display = 'flex';
            });
        });

        cancelButton.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Toast
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');
        const toastClose = document.querySelector('.toast-close');

        function showToast(message) {
            toastMessage.textContent = message;
            toast.style.display = 'flex';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }

        toastClose.addEventListener('click', () => {
            toast.style.display = 'none';
        });

        // Exemple de toast après soumission du formulaire (à intégrer côté serveur)
        deleteForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Simulation AJAX
            setTimeout(() => {
                showToast('Utilisateur supprimé avec succès');
                modal.style.display = 'none';
                // Recharger la page ou supprimer la ligne via DOM
            }, 500);
        });
    });
</script>

@endsection
