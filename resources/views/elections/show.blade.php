@extends('layouts.app')

@section('title', $election->titre)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="{{ route('elections.index') }}" class="text-decoration-none fw-semibold"
                       style="color:var(--navy);">
                        <i class="bi bi-ballot me-1"></i>Élections
                    </a>
                </li>
                <li class="breadcrumb-item active text-muted">{{ Str::limit($election->titre, 50) }}</li>
            </ol>
        </nav>

        {{-- En-tête ────────────────────────────────────── --}}
        <div class="card border-0 mb-4" style="border-left:5px solid var(--gold) !important;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded"
                         style="width:50px;height:50px;background:var(--navy);">
                        <i class="bi bi-ballot-fill text-white fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1" style="color:var(--navy);">{{ $election->titre }}</h4>
                        <span class="badge fw-semibold"
                              style="background:#e8f5e9; color:var(--green); padding:.35em .8em;">
                            <i class="bi bi-circle-fill me-1" style="font-size:.35rem; vertical-align:middle;"></i>
                            Vote ouvert
                        </span>
                    </div>
                </div>
                @if($election->description)
                    <p class="text-muted mb-3">{{ $election->description }}</p>
                @endif
                <div class="d-flex flex-wrap gap-3 small pt-3 border-top">
                    <span class="text-muted">
                        <i class="bi bi-calendar-check me-1" style="color:var(--green);"></i>
                        Du {{ $election->date_debut->format('d/m/Y') }}
                    </span>
                    <span class="text-muted">
                        <i class="bi bi-calendar-x me-1" style="color:var(--red);"></i>
                        au {{ $election->date_fin->format('d/m/Y') }}
                    </span>
                    <span class="text-muted">
                        <i class="bi bi-people me-1" style="color:var(--navy);"></i>
                        {{ $election->candidats->count() }} candidat(s)
                    </span>
                </div>
            </div>
        </div>

        {{-- Déjà voté ─────────────────────────────────── --}}
        @if($aDejaVote)
            <div class="card border-0 mb-4" style="border-left:5px solid var(--green) !important; background:#f6faf7;">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-circle"
                         style="width:46px;height:46px;background:var(--green);">
                        <i class="bi bi-check-lg text-white fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold mb-1" style="color:var(--green);">Vote enregistré avec succès</div>
                        <div class="small text-muted">
                            Vous avez déjà participé à cette élection.
                            <a href="{{ route('elections.resultats', $election) }}"
                               class="fw-semibold ms-1" style="color:var(--navy);">
                                Voir les résultats <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        {{-- Formulaire de vote ──────────────────────────── --}}
        @else
            <div class="card border-0">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-1" style="color:var(--navy);">
                        <i class="bi bi-people-fill me-2" style="color:var(--gold);"></i>
                        Choisissez votre candidat
                    </h5>
                    <p class="text-muted small mb-4">
                        Votre choix est définitif et confidentiel. Vous ne pourrez pas le modifier.
                    </p>

                    @error('candidat_id')
                        <div class="alert alert-danger mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
                        </div>
                    @enderror

                    <form method="POST" action="{{ route('elections.voter', $election) }}">
                        @csrf
                        <div class="row g-3 mb-4">
                            @foreach($election->candidats as $candidat)
                                <div class="col-md-6">
                                    <label for="c_{{ $candidat->id }}" class="candidat-card d-block h-100 w-100">
                                        <input class="d-none cand-radio"
                                               type="radio"
                                               name="candidat_id"
                                               id="c_{{ $candidat->id }}"
                                               value="{{ $candidat->id }}"
                                               required>
                                        <div class="d-flex align-items-center gap-3">
                                            @if($candidat->photo)
                                                <img src="{{ asset('storage/' . $candidat->photo) }}"
                                                     class="rounded-circle cand-photo flex-shrink-0"
                                                     width="64" height="64"
                                                     style="object-fit:cover; border:3px solid #dee2e6; transition:border-color .2s;">
                                            @else
                                                <div class="rounded-circle cand-avatar flex-shrink-0 d-flex align-items-center justify-content-center fw-bold text-white fs-4"
                                                     style="width:64px;height:64px;background:var(--navy);transition:background .2s;">
                                                    {{ strtoupper(substr($candidat->prenom, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="flex-grow-1 min-w-0">
                                                <div class="fw-bold" style="color:var(--navy);">
                                                    {{ $candidat->prenom }} {{ $candidat->nom }}
                                                </div>
                                                <small class="text-muted">Candidat(e)</small>
                                                @if($candidat->programme)
                                                    <p class="small text-muted mt-1 mb-0">
                                                        {{ Str::limit($candidat->programme, 100) }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="check-dot flex-shrink-0 rounded-circle"
                                                 style="width:22px;height:22px;border:2px solid #ced4da;transition:all .2s;"></div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-grid">
                            <button type="submit"
                                    class="btn btn-navy btn-lg fw-bold"
                                    style="border-radius:8px; padding:1rem; font-size:1.05rem;"
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
                    <i class="bi bi-bar-chart me-2"></i>Résultats provisoires
                </a>
            </div>
        @endif

    </div>
</div>

@push('styles')
<style>
    .candidat-card {
        cursor: pointer;
        border: 2px solid #dee2e6;
        border-radius: 10px;
        padding: 1rem;
        background: #fff;
        transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .candidat-card:hover { border-color: #b0bec5; background: #fafafa; }
    .candidat-card:has(.cand-radio:checked) {
        border-color: var(--navy) !important;
        background: #eef2f7 !important;
        box-shadow: 0 0 0 3px rgba(30,58,95,.12);
    }
    .candidat-card:has(.cand-radio:checked) .check-dot {
        background: var(--navy);
        border-color: var(--navy);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3'%3E%3Cpolyline points='20 6 9 17 4 12'/%3E%3C/svg%3E");
        background-size: 12px;
        background-repeat: no-repeat;
        background-position: center;
    }
    .candidat-card:has(.cand-radio:checked) .cand-photo { border-color: var(--navy) !important; }
    .candidat-card:has(.cand-radio:checked) .cand-avatar { background: var(--gold) !important; }
</style>
@endpush
@endsection
