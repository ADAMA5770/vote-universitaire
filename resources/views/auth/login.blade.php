@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">

        <div class="text-center mb-4">
            <i class="bi bi-ballot-fill text-primary" style="font-size: 3rem;"></i>
            <h3 class="mt-2 fw-bold">Vote Universitaire</h3>
            <p class="text-muted">Connectez-vous pour accéder aux élections</p>
        </div>

        <div class="card shadow">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold mb-4">
                    <i class="bi bi-lock-fill text-primary me-2"></i>Connexion
                </h5>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Numéro étudiant ou Email</label>
                        <input type="text" name="identifiant"
                               class="form-control @error('identifiant') is-invalid @enderror"
                               value="{{ old('identifiant') }}"
                               placeholder="2024-GL-001 ou email@exemple.com"
                               required autofocus>
                        @error('identifiant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mot de passe</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Se souvenir de moi</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3 border-0 bg-light">
            <div class="card-body py-2 px-3 small text-muted">
                <div class="fw-semibold mb-1"><i class="bi bi-info-circle me-1"></i>Comptes de test :</div>
                <div><i class="bi bi-shield-fill text-warning me-1"></i><strong>Admin :</strong> admin@vote.com / admin123</div>
                <div><i class="bi bi-mortarboard text-primary me-1"></i><strong>Étudiant :</strong> etudiant@vote.com / etudiant123</div>
            </div>
        </div>

    </div>
</div>
@endsection
