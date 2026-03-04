@extends('layouts.app')

@section('title', 'Créer une élection')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.elections.index') }}">Élections</a></li>
                <li class="breadcrumb-item active">Créer</li>
            </ol>
        </nav>

        <div class="card shadow">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0">
                    <i class="bi bi-plus-circle me-2"></i>Créer une nouvelle élection
                </h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.elections.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Titre <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="titre"
                               class="form-control @error('titre') is-invalid @enderror"
                               value="{{ old('titre') }}"
                               placeholder="Ex : Élection du Président des Étudiants 2025"
                               required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Décrivez l'objectif de cette élection...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Date de début <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" name="date_debut"
                                   class="form-control @error('date_debut') is-invalid @enderror"
                                   value="{{ old('date_debut') }}" required>
                            @error('date_debut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Date de fin <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" name="date_fin"
                                   class="form-control @error('date_fin') is-invalid @enderror"
                                   value="{{ old('date_fin') }}" required>
                            @error('date_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Statut initial <span class="text-danger">*</span>
                        </label>
                        <select name="statut"
                                class="form-select @error('statut') is-invalid @enderror" required>
                            <option value="en_attente" {{ old('statut', 'en_attente') === 'en_attente' ? 'selected' : '' }}>
                                ⏳ En attente
                            </option>
                            <option value="active" {{ old('statut') === 'active' ? 'selected' : '' }}>
                                ✅ Active (ouverte aux votes)
                            </option>
                            <option value="terminee" {{ old('statut') === 'terminee' ? 'selected' : '' }}>
                                🔒 Terminée
                            </option>
                        </select>
                        @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Créer l'élection
                        </button>
                        <a href="{{ route('admin.elections.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
