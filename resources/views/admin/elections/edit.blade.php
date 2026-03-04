@extends('layouts.app')

@section('title', 'Modifier — ' . $election->titre)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.elections.index') }}">Élections</a></li>
                <li class="breadcrumb-item active">Modifier</li>
            </ol>
        </nav>

        {{-- Formulaire modification élection --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-warning text-dark py-3">
                <h4 class="mb-0">
                    <i class="bi bi-pencil-square me-2"></i>Modifier l'élection
                </h4>
            </div>
            <div class="card-body p-4">

                @if($election->votes()->count() > 0)
                    <div class="alert alert-warning d-flex align-items-center mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div>
                            <strong>Attention :</strong> Cette élection a déjà
                            <strong>{{ $election->votes()->count() }}</strong> vote(s) enregistré(s).
                            Modifier le statut peut affecter les résultats.
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.elections.update', $election) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Titre <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="titre"
                               class="form-control @error('titre') is-invalid @enderror"
                               value="{{ old('titre', $election->titre) }}" required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="4">{{ old('description', $election->description) }}</textarea>
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
                                   value="{{ old('date_debut', $election->date_debut->format('Y-m-d\TH:i')) }}"
                                   required>
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
                                   value="{{ old('date_fin', $election->date_fin->format('Y-m-d\TH:i')) }}"
                                   required>
                            @error('date_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Statut <span class="text-danger">*</span>
                        </label>
                        <select name="statut"
                                class="form-select @error('statut') is-invalid @enderror" required>
                            <option value="en_attente" {{ old('statut', $election->statut) === 'en_attente' ? 'selected' : '' }}>
                                ⏳ En attente
                            </option>
                            <option value="active" {{ old('statut', $election->statut) === 'active' ? 'selected' : '' }}>
                                ✅ Active (ouverte aux votes)
                            </option>
                            <option value="terminee" {{ old('statut', $election->statut) === 'terminee' ? 'selected' : '' }}>
                                🔒 Terminée
                            </option>
                        </select>
                        @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle me-2"></i>Enregistrer les modifications
                        </button>
                        <a href="{{ route('admin.elections.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Gestion des candidats --}}
        <div class="card shadow">
            <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-people-fill me-2"></i>Candidats
                    <span class="badge bg-white text-primary ms-2">{{ $election->candidats->count() }}</span>
                </h5>
            </div>

            {{-- Liste des candidats existants --}}
            @if($election->candidats->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($election->candidats as $candidat)
                        <div class="list-group-item d-flex justify-content-between align-items-start py-3">
                            <div>
                                <div class="fw-semibold">{{ $candidat->prenom }} {{ $candidat->nom }}</div>
                                @if($candidat->programme)
                                    <div class="text-muted small mt-1">{{ $candidat->programme }}</div>
                                @else
                                    <div class="text-muted small fst-italic mt-1">Pas de programme défini</div>
                                @endif
                            </div>
                            <form method="POST"
                                  action="{{ route('admin.candidats.destroy', $candidat) }}"
                                  class="ms-3 flex-shrink-0"
                                  onsubmit="return confirm('Supprimer le candidat « {{ addslashes($candidat->prenom . ' ' . $candidat->nom) }} » ?')">
                                @csrf
                                @method('DELETE')
                                @if($election->votes()->count() > 0)
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger disabled"
                                            title="Impossible de supprimer : des votes existent"
                                            data-bs-toggle="tooltip">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card-body text-center text-muted py-4">
                    <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                    Aucun candidat pour le moment.
                </div>
            @endif

            {{-- Formulaire ajout candidat --}}
            @if($election->votes()->count() === 0)
                <div class="card-body border-top bg-light">
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-person-plus me-2 text-primary"></i>Ajouter un candidat
                    </h6>
                    <form method="POST" action="{{ route('admin.candidats.store', $election) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <input type="text" name="prenom"
                                       class="form-control @error('prenom') is-invalid @enderror"
                                       placeholder="Prénom *"
                                       value="{{ old('prenom') }}" required>
                                @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="nom"
                                       class="form-control @error('nom') is-invalid @enderror"
                                       placeholder="Nom *"
                                       value="{{ old('nom') }}" required>
                                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-muted mb-1">
                                    <i class="bi bi-camera me-1"></i>Photo (optionnel — JPG/PNG/WebP, max 2 Mo)
                                </label>
                                <input type="file" name="photo" accept="image/jpeg,image/png,image/webp"
                                       class="form-control @error('photo') is-invalid @enderror">
                                @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <textarea name="programme"
                                          class="form-control @error('programme') is-invalid @enderror"
                                          rows="2"
                                          placeholder="Programme / présentation (optionnel)">{{ old('programme') }}</textarea>
                                @error('programme')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Ajouter le candidat
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="card-body border-top bg-light">
                    <p class="text-muted small mb-0">
                        <i class="bi bi-lock-fill me-1"></i>
                        L'ajout/suppression de candidats est verrouillé car des votes ont déjà été enregistrés.
                    </p>
                </div>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script>
    // Activation des tooltips Bootstrap
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });
</script>
@endpush
@endsection
