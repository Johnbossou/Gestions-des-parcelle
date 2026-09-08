@extends('layouts.app')
@section('title', 'Détails de l\'utilisateur')
@section('content')
<div class="user-form-container">
    <div class="form-header">
        <h1 class="form-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Détails de l'utilisateur
        </h1>
        <p class="form-description">Informations du compte #{{ $user->id }}</p>
    </div>

    <div class="form-card">
        <div class="profile-avatar">
            <div class="avatar-circle">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <h2 class="profile-name">{{ $user->name }}</h2>
            <p class="profile-email">{{ $user->email }}</p>
        </div>

        <div class="details-grid">
            <div class="detail-item">
                <span class="detail-label">ID</span>
                <span class="detail-value">{{ $user->id }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Nom complet</span>
                <span class="detail-value">{{ $user->name }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Adresse email</span>
                <span class="detail-value">{{ $user->email }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Rôle</span>
                <span class="detail-value">
                    @foreach($user->getRoleNames() as $role)
                        <span class="role-badge">{{ $role }}</span>
                    @endforeach
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Membre depuis</span>
                <span class="detail-value">{{ $user->created_at->format('d/m/Y') }}</span>
            </div>
            @if($user->email_verified_at)
            <div class="detail-item">
                <span class="detail-label">Email vérifié</span>
                <span class="detail-value">Oui</span>
            </div>
            @endif
        </div>

        <div class="form-actions">
            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifier
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour
            </a>
        </div>
    </div>
</div>

<style>
    .user-form-container { max-width: 800px; margin: 0 auto; padding: 2rem; }
    .form-header { margin-bottom: 2rem; }
    .form-title { font-size: 2rem; font-weight: 700; color: #1A5F23; display: flex; align-items: center; gap: 0.75rem; margin: 0 0 0.5rem; }
    .form-title svg { width: 2rem; height: 2rem; color: #F9A825; }
    .form-description { color: #333; font-size: 1.125rem; margin: 0; }
    .form-card { background: #fff; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); padding: 2.5rem; }
    .profile-avatar { text-align: center; margin-bottom: 2rem; }
    .avatar-circle { width: 88px; height: 88px; border-radius: 50%; background: #1A5F23; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; }
    .profile-name { margin: 0 0 0.25rem; color: #1A5F23; }
    .profile-email { margin: 0; color: #666; }
    .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem; }
    .detail-item { background: #F5F5F5; padding: 1rem; border-radius: 0.5rem; }
    .detail-label { display: block; font-size: 0.8125rem; color: #666; margin-bottom: 0.25rem; }
    .detail-value { font-weight: 500; color: #333; }
    .role-badge { display: inline-block; background: #F9A825; color: #333; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.8125rem; }
    .form-actions { display: flex; gap: 1rem; border-top: 1px solid #F5F5F5; padding-top: 2rem; }
    .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 500; text-decoration: none; border: none; cursor: pointer; }
    .btn svg { width: 1.25rem; height: 1.25rem; }
    .btn-primary { background: #1A5F23; color: #fff; }
    .btn-primary:hover { background: #4CAF50; }
    .btn-secondary { background: #F9A825; color: #333; }
    .btn-secondary:hover { background: #FCD116; }
    @media (max-width: 600px) { .details-grid { grid-template-columns: 1fr; } .form-actions { flex-direction: column; } }
</style>
@endsection
