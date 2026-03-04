@extends('layouts.app')

@section('title', 'Créer un compte étudiant')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.etudiants.index') }}">Étudiants</a></li>
                <li class="breadcrumb-item active">Créer</li>
            </ol>
        </nav>

        <div class="card shadow">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0">
                    <i class="bi bi-person-plus-fill me-2"></i>Créer un compte étudiant
                </h4>
            </div>
            <div class="card-body p-4">

                <div class="alert alert-info d-flex align-items-start mb-4">
                    <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                    <div>
                        L'étudiant pourra se connecter avec son <strong>numéro étudiant</strong>
                        ou son <strong>email</strong> + le mot de passe que vous définissez ici.
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.etudiants.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nom complet <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Prénom Nom" required autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Numéro étudiant <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="numero_etudiant"
                               class="form-control @error('numero_etudiant') is-invalid @enderror"
                               value="{{ old('numero_etudiant') }}"
                               placeholder="Ex: 2024-GL-001" required>
                        @error('numero_etudiant')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Identifiant unique — servira à la connexion.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="etudiant@universite.com" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Mot de passe <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Minimum 6 caractères" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">
                            <i class="bi bi-eye me-1"></i>Le mot de passe est affiché en clair pour que vous puissiez le communiquer à l'étudiant.
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Créer le compte
                        </button>
                        <a href="{{ route('admin.etudiants.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Annuler
                        </a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
