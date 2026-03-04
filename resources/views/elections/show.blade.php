@extends('layouts.app')

@section('title', $election->titre)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('elections.index') }}"><i class="bi bi-ballot me-1"></i>Élections</a>
                </li>
                <li class="breadcrumb-item active">{{ Str::limit($election->titre, 50) }}</li>
            </ol>
        </nav>

        {{-- En-tête de l'élection --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0">
                    <i class="bi bi-ballot me-2"></i>{{ $election->titre }}
                </h4>
            </div>
            <div class="card-body p-4">
                @if($election->description)
                    <p class="text-muted">{{ $election->description }}</p>
                @endif

                <div class="d-flex flex-wrap gap-3 small text-muted border-top pt-3">
                    <span><i class="bi bi-calendar-check text-success me-1"></i>Du {{ $election->date_debut->format('d/m/Y') }}</span>
                    <span><i class="bi bi-calendar-x text-danger me-1"></i>au {{ $election->date_fin->format('d/m/Y') }}</span>
                    <span class="badge bg-success align-self-center">Active</span>
                </div>
            </div>
        </div>

        {{-- Déjà voté --}}
        @if($aDejaVote)
            <div class="alert alert-success d-flex align-items-center shadow-sm">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div>
                    <strong>Vous avez déjà voté</strong> pour cette élection.
                    <a href="{{ route('elections.resultats', $election) }}" class="alert-link ms-2">
                        Voir les résultats <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

        {{-- Formulaire de vote --}}
        @else
            <div class="card shadow">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-people text-primary me-2"></i>Choisissez votre candidat
                    </h5>

                    @error('candidat_id')
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
                        </div>
                    @enderror

                    <form method="POST" action="{{ route('elections.voter', $election) }}">
                        @csrf

                        <div class="row g-3 mb-4">
                            @foreach($election->candidats as $candidat)
                                <div class="col-md-6">
                                    <label for="candidat_{{ $candidat->id }}"
                                           class="card border-2 candidat-card h-100 w-100 text-start"
                                           style="cursor: pointer;">
                                        <div class="card-body">
                                            <div class="form-check d-flex align-items-start">
                                                <input class="form-check-input mt-1 me-3 flex-shrink-0"
                                                       type="radio"
                                                       name="candidat_id"
                                                       id="candidat_{{ $candidat->id }}"
                                                       value="{{ $candidat->id }}"
                                                       required>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center mb-2">
                                                        @if($candidat->photo)
                                                            <img src="{{ asset('storage/' . $candidat->photo) }}"
                                                                 class="rounded-circle me-3"
                                                                 width="56" height="56"
                                                                 style="object-fit:cover; flex-shrink:0;">
                                                        @else
                                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3 fw-bold fs-4"
                                                                 style="width:56px;height:56px;flex-shrink:0;">
                                                                {{ strtoupper(substr($candidat->prenom, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-bold">{{ $candidat->prenom }} {{ $candidat->nom }}</div>
                                                            <small class="text-muted">Candidat(e)</small>
                                                        </div>
                                                    </div>
                                                    @if($candidat->programme)
                                                        <p class="small text-muted mb-0">
                                                            <i class="bi bi-file-text me-1"></i>
                                                            {{ Str::limit($candidat->programme, 130) }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg"
                                    onclick="return confirm('Confirmez-vous votre vote ? Cette action est irréversible.')">
                                <i class="bi bi-hand-thumbs-up me-2"></i>Confirmer mon vote
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- [SÉCURITÉ] Lien résultats provisoires : visible uniquement après avoir voté --}}
        @if($aDejaVote)
            <div class="text-center mt-3">
                <a href="{{ route('elections.resultats', $election) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-bar-chart me-2"></i>Voir les résultats provisoires
                </a>
            </div>
        @endif

    </div>
</div>

@push('styles')
<style>
    .candidat-card { transition: all .15s; border-color: #dee2e6 !important; }
    .candidat-card:hover { border-color: #0d6efd !important; background-color: #f0f7ff; }
    .candidat-card:has(input:checked) { border-color: #0d6efd !important; background-color: #e8f0fe; box-shadow: 0 0 0 3px rgba(13,110,253,.15); }
</style>
@endpush
@endsection
