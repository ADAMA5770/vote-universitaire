@extends('layouts.app')

@section('title', 'Résultats — ' . $election->titre)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('elections.index') }}"><i class="bi bi-ballot me-1"></i>Élections</a>
                </li>
                <li class="breadcrumb-item active">Résultats</li>
            </ol>
        </nav>

        <div class="card shadow">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0">
                    <i class="bi bi-bar-chart-fill me-2"></i>Résultats : {{ $election->titre }}
                </h4>
            </div>

            <div class="card-body p-4">

                {{-- Statut et total --}}
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        @if($election->statut === 'active')
                            <span class="badge bg-success me-2">Active</span>
                            <small class="text-muted fst-italic">Résultats provisoires</small>
                        @elseif($election->statut === 'terminee')
                            <span class="badge bg-secondary me-2">Terminée</span>
                            <small class="text-muted">Résultats définitifs</small>
                        @else
                            <span class="badge bg-warning text-dark me-2">En attente</span>
                        @endif
                    </div>
                    <div class="text-end">
                        <div class="fs-3 fw-bold text-primary lh-1">{{ $totalVotes }}</div>
                        <small class="text-muted">vote(s) enregistré(s)</small>
                    </div>
                </div>

                {{-- Résultats --}}
                @if($totalVotes === 0)
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Aucun vote enregistré pour le moment.
                    </div>
                @else
                    @foreach($candidats as $index => $candidat)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    @if($index === 0)
                                        <i class="bi bi-trophy-fill text-warning fs-5"></i>
                                    @elseif($index === 1)
                                        <i class="bi bi-award-fill text-secondary fs-5"></i>
                                    @else
                                        <i class="bi bi-person-fill text-muted fs-5"></i>
                                    @endif
                                    <span class="fw-bold">{{ $candidat['nom'] }}</span>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold text-primary fs-5">{{ $candidat['pourcentage'] }}%</span>
                                    <span class="text-muted small ms-2">({{ $candidat['nb_votes'] }} vote(s))</span>
                                </div>
                            </div>
                            <div class="progress" style="height: 30px; border-radius: 8px;">
                                <div class="progress-bar {{ $index === 0 ? 'bg-warning' : ($index === 1 ? 'bg-primary' : 'bg-secondary') }}"
                                     role="progressbar"
                                     style="width: {{ $candidat['pourcentage'] }}%;"
                                     aria-valuenow="{{ $candidat['pourcentage'] }}"
                                     aria-valuemin="0" aria-valuemax="100">
                                    @if($candidat['pourcentage'] > 8)
                                        {{ $candidat['pourcentage'] }}%
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>

            <div class="card-footer bg-transparent d-flex justify-content-between flex-wrap gap-2">
                @if($election->statut === 'active')
                    <a href="{{ route('elections.show', $election) }}" class="btn btn-primary">
                        <i class="bi bi-hand-index-thumb me-2"></i>Voter
                    </a>
                @endif
                <a href="{{ route('elections.index') }}" class="btn btn-outline-secondary ms-auto">
                    <i class="bi bi-arrow-left me-2"></i>Retour aux élections
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
