@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">

        <div class="mb-4">
            <h2 class="fw-bold mb-1" style="color:var(--navy);">
                <i class="bi bi-person-circle me-2" style="color:var(--gold);"></i>Mon profil
            </h2>
            <p class="text-muted mb-0">Informations et sécurité du compte</p>
        </div>

        {{-- Infos du compte --}}
        <div class="card border-0 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3" style="color:var(--navy);">
                    <i class="bi bi-info-circle me-2" style="color:var(--gold);"></i>Informations
                </h6>
                <dl class="row mb-0 small">
                    <dt class="col-sm-4 text-muted fw-semibold">Nom</dt>
                    <dd class="col-sm-8">{{ $user->name }}</dd>

                    <dt class="col-sm-4 text-muted fw-semibold">Email</dt>
                    <dd class="col-sm-8">{{ $user->email }}</dd>

                    @if($user->numero_etudiant)
                        <dt class="col-sm-4 text-muted fw-semibold">N° Étudiant</dt>
                        <dd class="col-sm-8">
                            <code class="px-2 py-1 rounded" style="background:#eef2f7; color:var(--navy);">{{ $user->numero_etudiant }}</code>
                        </dd>
                    @endif

                    <dt class="col-sm-4 text-muted fw-semibold">Rôle</dt>
                    <dd class="col-sm-8">
                        @if($user->isAdmin())
                            <span class="badge-admin">Admin</span>
                        @else
                            <span class="badge fw-semibold" style="background:#eef2f7; color:var(--navy);">Étudiant</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        {{-- Changer mot de passe --}}
        <div class="card border-0">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3" style="color:var(--navy);">
                    <i class="bi bi-shield-lock me-2" style="color:var(--gold);"></i>Changer le mot de passe
                </h6>

                @if(session('success'))
                    <div class="alert alert-success mb-3">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('profil.password') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror"
                               placeholder="Votre mot de passe actuel" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Minimum 6 caractères" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-muted">Confirmation</label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Répétez le nouveau mot de passe" required>
                    </div>
                    <button type="submit" class="btn btn-navy fw-semibold w-100">
                        <i class="bi bi-shield-check me-2"></i>Mettre à jour
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
