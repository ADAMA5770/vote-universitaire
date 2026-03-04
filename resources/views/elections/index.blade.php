@extends('layouts.app')

@section('title', 'Élections en cours')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1"><i class="bi bi-ballot-fill text-primary me-2"></i>Élections en cours</h2>
        <p class="text-muted mb-0">Participez aux élections universitaires actives</p>
    </div>
</div>

@if($elections->isEmpty())
    <div class="card border-0 text-center py-5">
        <div class="card-body">
            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3 text-muted">Aucune élection active</h4>
            <p class="text-muted">Il n'y a pas d'élection en cours pour le moment. Revenez plus tard !</p>
        </div>
    </div>
@else
    <div class="row g-4">
        @foreach($elections as $election)
            <div class="col-md-6 col-xl-4">
                <div class="card h-100 hover-shadow transition">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title text-primary fw-bold mb-0">{{ $election->titre }}</h5>
                            <span class="badge bg-success ms-2 text-nowrap">
                                <i class="bi bi-circle-fill me-1" style="font-size:.5rem;"></i>Active
                            </span>
                        </div>

                        @if($election->description)
                            <p class="card-text text-muted small">
                                {{ Str::limit($election->description, 110) }}
                            </p>
                        @endif

                        <div class="mt-3 pt-2 border-top small text-muted">
                            <div class="mb-1">
                                <i class="bi bi-calendar-check text-success me-2"></i>
                                Début : <strong>{{ $election->date_debut->format('d/m/Y à H:i') }}</strong>
                            </div>
                            <div class="mb-1">
                                <i class="bi bi-calendar-x text-danger me-2"></i>
                                Fin : <strong>{{ $election->date_fin->format('d/m/Y à H:i') }}</strong>
                            </div>
                            <div>
                                <i class="bi bi-people text-primary me-2"></i>
                                <strong>{{ $election->candidats()->count() }}</strong> candidat(s)
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3 pt-0">
                        {{-- [SÉCURITÉ] Seul le bouton "Voter" est affiché ici.
                             Les résultats sont accessibles APRÈS avoir voté (depuis la page de vote). --}}
                        <div class="d-grid">
                            <a href="{{ route('elections.show', $election) }}" class="btn btn-primary">
                                <i class="bi bi-hand-index-thumb me-2"></i>Voter maintenant
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
