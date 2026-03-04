@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">

        <div class="text-center mb-4">
            <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
            <h3 class="mt-2 fw-bold">Créer un compte</h3>
            <p class="text-muted">Inscrivez-vous pour participer aux élections</p>
        </div>

        <div class="card shadow">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold mb-4">
                    <i class="bi bi-person-plus-fill text-primary me-2"></i>Inscription
                </h5>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom complet</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Prénom Nom" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Adresse email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="votremail@exemple.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mot de passe</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Minimum 8 caractères" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation"
                               class="form-control"
                               placeholder="Répéter le mot de passe" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-person-check me-2"></i>S'inscrire
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3 bg-light">
                <span class="text-muted small">Déjà un compte ? </span>
                <a href="{{ route('login') }}" class="fw-semibold small">Se connecter</a>
            </div>
        </div>

    </div>
</div>
@endsection
