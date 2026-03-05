@extends('layouts.app')

@section('title', 'Élections en cours')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color:var(--navy);">
            <i class="bi bi-ballot-fill me-2" style="color:var(--gold);"></i>Élections en cours
        </h2>
        <p class="text-muted mb-0">Participez aux élections universitaires ouvertes au vote</p>
    </div>
</div>

@if($elections->isEmpty())
    <div class="card text-center py-5 border-0" style="border-top:4px solid var(--gold) !important;">
        <div class="card-body py-4">
            <div class="mb-3" style="font-size:3.5rem; opacity:.3;">🗳️</div>
            <h5 class="fw-bold" style="color:var(--navy);">Aucune élection active pour le moment</h5>
            <p class="text-muted mb-0">Revenez plus tard — votre administration ouvrira prochainement une session de vote.</p>
        </div>
    </div>
@else
    <div class="row g-4">
        @foreach($elections as $election)
            <div class="col-md-6 col-xl-4">
                <div class="card card-hover h-100 border-0" style="border-left:4px solid var(--gold) !important;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded"
                                 style="width:46px;height:46px;background:var(--navy);">
                                <i class="bi bi-ballot-fill text-white fs-5"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-1 lh-sm" style="color:var(--navy);">{{ $election->titre }}</h5>
                                <span class="badge fw-semibold"
                                      style="background:#e8f5e9; color:var(--green); font-size:.7rem; padding:.3em .7em;">
                                    <i class="bi bi-circle-fill me-1" style="font-size:.35rem; vertical-align:middle;"></i>
                                    Vote ouvert
                                </span>
                            </div>
                        </div>

                        @if($election->description)
                            <p class="text-muted small mb-3">{{ Str::limit($election->description, 110) }}</p>
                        @endif

                        <div class="d-flex flex-column gap-1 small pt-3 border-top">
                            <div class="text-muted">
                                <i class="bi bi-calendar-check me-2" style="color:var(--green);"></i>
                                Ouvert le <strong class="text-dark">{{ $election->date_debut->format('d/m/Y') }}</strong>
                            </div>
                            <div class="text-muted">
                                <i class="bi bi-calendar-x me-2" style="color:var(--red);"></i>
                                Ferme le <strong class="text-dark">{{ $election->date_fin->format('d/m/Y') }}</strong>
                            </div>
                            <div class="text-muted">
                                <i class="bi bi-people me-2" style="color:var(--navy);"></i>
                                <strong class="text-dark">{{ $election->candidats()->count() }}</strong> candidat(s)
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 px-4 pb-4 pt-0 bg-transparent">
                        <a href="{{ route('elections.show', $election) }}"
                           class="btn btn-navy w-100 fw-semibold" style="border-radius:7px; padding:.65rem;">
                            <i class="bi bi-hand-index-thumb me-2"></i>Voter maintenant
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
