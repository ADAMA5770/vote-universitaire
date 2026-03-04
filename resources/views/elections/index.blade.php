@extends('layouts.app')

@section('title', 'Élections en cours')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-1 fw-bold" style="color:#1e293b;">
            <i class="bi bi-ballot-fill me-2" style="color:#2563EB;"></i>Élections en cours
        </h2>
        <p class="text-muted mb-0">Participez aux élections universitaires actives</p>
    </div>
</div>

@if($elections->isEmpty())
    <div class="card border-0 text-center py-5" style="background:linear-gradient(135deg,#eff6ff,#f5f3ff); border-radius:16px;">
        <div class="card-body py-5">
            <div class="mb-3" style="font-size:4rem; opacity:.35;">🗳️</div>
            <h4 class="fw-bold" style="color:#1e293b;">Aucune élection active</h4>
            <p class="text-muted">Il n'y a pas d'élection en cours pour le moment. Revenez plus tard !</p>
        </div>
    </div>
@else
    <div class="row g-4">
        @foreach($elections as $election)
            <div class="col-md-6 col-xl-4">
                <div class="card card-hover h-100 border-0 overflow-hidden" style="border-radius:16px;">
                    {{-- Bandeau couleur en haut --}}
                    <div style="height:6px; background:linear-gradient(90deg,#2563EB,#7C3AED);"></div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                 style="width:48px;height:48px;background:linear-gradient(135deg,#2563EB,#7C3AED);">
                                <i class="bi bi-ballot-fill text-white fs-5"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-1" style="color:#1e293b;">{{ $election->titre }}</h5>
                                <span class="badge" style="background:#dcfce7; color:#059669; font-size:.7rem;">
                                    <i class="bi bi-circle-fill me-1" style="font-size:.4rem;"></i>En cours
                                </span>
                            </div>
                        </div>

                        @if($election->description)
                            <p class="text-muted small mb-3">{{ Str::limit($election->description, 100) }}</p>
                        @endif

                        <div class="d-flex flex-column gap-1 small text-muted border-top pt-3">
                            <div>
                                <i class="bi bi-calendar-check me-2" style="color:#059669;"></i>
                                Ouvert le <strong>{{ $election->date_debut->format('d/m/Y') }}</strong>
                            </div>
                            <div>
                                <i class="bi bi-calendar-x me-2" style="color:#DC2626;"></i>
                                Jusqu'au <strong>{{ $election->date_fin->format('d/m/Y') }}</strong>
                            </div>
                            <div>
                                <i class="bi bi-people me-2" style="color:#7C3AED;"></i>
                                <strong>{{ $election->candidats()->count() }}</strong> candidat(s)
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 px-4 pb-4 pt-0" style="background:transparent;">
                        <a href="{{ route('elections.show', $election) }}"
                           class="btn w-100 text-white fw-semibold"
                           style="background:linear-gradient(90deg,#2563EB,#7C3AED); border:none; border-radius:10px;">
                            <i class="bi bi-hand-index-thumb me-2"></i>Voter maintenant
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
