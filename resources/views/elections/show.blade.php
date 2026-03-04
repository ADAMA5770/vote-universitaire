@extends('layouts.app')

@section('title', $election->titre)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('elections.index') }}" class="text-decoration-none">
                        <i class="bi bi-ballot me-1"></i>Élections
                    </a>
                </li>
                <li class="breadcrumb-item active">{{ Str::limit($election->titre, 50) }}</li>
            </ol>
        </nav>

        {{-- En-tête de l'élection --}}
        <div class="card border-0 mb-4 overflow-hidden" style="border-radius:16px;">
            <div style="height:6px; background:linear-gradient(90deg,#2563EB,#7C3AED);"></div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:52px;height:52px;background:linear-gradient(135deg,#2563EB,#7C3AED);">
                        <i class="bi bi-ballot-fill text-white fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1" style="color:#1e293b;">{{ $election->titre }}</h4>
                        <span class="badge" style="background:#dcfce7; color:#059669;">
                            <i class="bi bi-circle-fill me-1" style="font-size:.4rem;"></i>Active
                        </span>
                    </div>
                </div>

                @if($election->description)
                    <p class="text-muted mb-3">{{ $election->description }}</p>
                @endif

                <div class="d-flex flex-wrap gap-3 small text-muted pt-3 border-top">
                    <span><i class="bi bi-calendar-check me-1" style="color:#059669;"></i>Du {{ $election->date_debut->format('d/m/Y') }}</span>
                    <span><i class="bi bi-calendar-x me-1" style="color:#DC2626;"></i>au {{ $election->date_fin->format('d/m/Y') }}</span>
                    <span><i class="bi bi-people me-1" style="color:#7C3AED;"></i>{{ $election->candidats->count() }} candidat(s)</span>
                </div>
            </div>
        </div>

        {{-- Déjà voté --}}
        @if($aDejaVote)
            <div class="alert border-0 d-flex align-items-center gap-3 shadow-sm mb-4"
                 style="background:#f0fdf4; border-radius:12px;">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:44px;height:44px;background:#dcfce7;">
                    <i class="bi bi-check-circle-fill fs-4" style="color:#059669;"></i>
                </div>
                <div>
                    <div class="fw-semibold" style="color:#059669;">Vote enregistré</div>
                    <div class="small text-muted">
                        Vous avez déjà voté pour cette élection.
                        <a href="{{ route('elections.resultats', $election) }}" class="fw-semibold ms-1"
                           style="color:#2563EB;">
                            Voir les résultats <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

        {{-- Formulaire de vote --}}
        @else
            <div class="card border-0" style="border-radius:16px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color:#1e293b;">
                        <i class="bi bi-people me-2" style="color:#7C3AED;"></i>Choisissez votre candidat
                    </h5>

                    @error('candidat_id')
                        <div class="alert alert-danger border-0 mb-4" style="border-radius:10px;">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
                        </div>
                    @enderror

                    <form method="POST" action="{{ route('elections.voter', $election) }}">
                        @csrf

                        <div class="row g-3 mb-4">
                            @foreach($election->candidats as $candidat)
                                <div class="col-md-6">
                                    <label for="candidat_{{ $candidat->id }}"
                                           class="candidat-card d-block h-100 p-3 w-100"
                                           style="cursor:pointer; border:2px solid #e2e8f0; border-radius:14px; transition:all .2s; background:#fff;">
                                        <input class="d-none candidat-radio"
                                               type="radio"
                                               name="candidat_id"
                                               id="candidat_{{ $candidat->id }}"
                                               value="{{ $candidat->id }}"
                                               required>
                                        <div class="d-flex align-items-center gap-3">
                                            @if($candidat->photo)
                                                <img src="{{ asset('storage/' . $candidat->photo) }}"
                                                     class="rounded-circle flex-shrink-0"
                                                     width="64" height="64"
                                                     style="object-fit:cover; border:3px solid #e2e8f0;">
                                            @else
                                                <div class="rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center fw-bold text-white fs-4"
                                                     style="width:64px;height:64px;background:linear-gradient(135deg,#2563EB,#7C3AED);">
                                                    {{ strtoupper(substr($candidat->prenom, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="flex-grow-1 min-w-0">
                                                <div class="fw-bold" style="color:#1e293b;">
                                                    {{ $candidat->prenom }} {{ $candidat->nom }}
                                                </div>
                                                <small class="text-muted">Candidat(e)</small>
                                                @if($candidat->programme)
                                                    <p class="small text-muted mt-1 mb-0">
                                                        {{ Str::limit($candidat->programme, 100) }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="check-indicator flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width:24px;height:24px;border:2px solid #cbd5e1;transition:all .2s;">
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-grid">
                            <button type="submit"
                                    class="btn btn-lg fw-semibold text-white"
                                    style="background:linear-gradient(90deg,#2563EB,#7C3AED); border:none; border-radius:12px; padding:.85rem;"
                                    onclick="return confirm('Confirmez-vous votre vote ? Cette action est irréversible.')">
                                <i class="bi bi-hand-thumbs-up me-2"></i>Confirmer mon vote
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

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
    .candidat-card:has(.candidat-radio:checked) {
        border-color: #2563EB !important;
        background: #eff6ff !important;
        box-shadow: 0 0 0 4px rgba(37,99,235,.12);
    }
    .candidat-card:has(.candidat-radio:checked) .check-indicator {
        background: #2563EB;
        border-color: #2563EB;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3'%3E%3Cpolyline points='20 6 9 17 4 12'/%3E%3C/svg%3E");
        background-size: 14px;
        background-repeat: no-repeat;
        background-position: center;
    }
    .candidat-card:hover:not(:has(.candidat-radio:checked)) {
        border-color: #a5b4fc !important;
        background: #f8faff !important;
    }
    .candidat-card:has(.candidat-radio:checked) img {
        border-color: #2563EB !important;
    }
</style>
@endpush
@endsection
