@extends('layouts.app')

@section('title', 'Mes votes')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="fw-bold mb-1" style="color:var(--navy);">
                    <i class="bi bi-clock-history me-2" style="color:var(--gold);"></i>Mes votes
                </h2>
                <p class="text-muted mb-0">{{ $votes->count() }} participation(s)</p>
            </div>
            <a href="{{ route('elections.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-ballot me-1"></i>Élections
            </a>
        </div>

        @if($votes->isEmpty())
            <div class="card border-0 text-center py-5">
                <div class="card-body">
                    <i class="bi bi-inbox fs-1 d-block mb-3" style="color:var(--navy); opacity:.3;"></i>
                    <p class="text-muted mb-3">Vous n'avez pas encore voté.</p>
                    <a href="{{ route('elections.index') }}" class="btn btn-navy fw-semibold">
                        <i class="bi bi-ballot me-2"></i>Voir les élections
                    </a>
                </div>
            </div>
        @else
            <div class="card border-0 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead style="background:#f8f9fa;">
                            <tr>
                                <th class="ps-4 py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing:.4px;">Élection</th>
                                <th class="py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing:.4px;">Candidat</th>
                                <th class="py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing:.4px;">Statut</th>
                                <th class="py-3 text-center text-muted small fw-semibold text-uppercase" style="letter-spacing:.4px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($votes as $vote)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-semibold" style="color:var(--navy);">{{ $vote->election->titre }}</div>
                                        <small class="text-muted">{{ $vote->voted_at ? $vote->voted_at->format('d/m/Y à H:i') : '—' }}</small>
                                    </td>
                                    <td class="py-3">
                                        @if($vote->candidat)
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                                     style="width:32px;height:32px;background:var(--navy);font-size:.75rem;">
                                                    {{ strtoupper(substr($vote->candidat->prenom, 0, 1)) }}
                                                </div>
                                                <span class="fw-semibold small">{{ $vote->candidat->prenom }} {{ $vote->candidat->nom }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted small fst-italic">Candidat supprimé</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if($vote->election->statut === 'active')
                                            <span class="badge fw-semibold" style="background:#e8f5e9; color:var(--green);">
                                                <i class="bi bi-circle-fill me-1" style="font-size:.35rem; vertical-align:middle;"></i>Active
                                            </span>
                                        @elseif($vote->election->statut === 'terminee')
                                            <span class="badge bg-secondary fw-semibold">Terminée</span>
                                        @else
                                            <span class="badge fw-semibold" style="background:#fff3e0; color:#e65100;">En attente</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('elections.resultats', $vote->election) }}"
                                               class="btn btn-sm btn-outline-secondary" title="Résultats">
                                                <i class="bi bi-bar-chart"></i>
                                            </a>
                                            <a href="{{ route('elections.bulletin', $vote->election) }}"
                                               class="btn btn-sm btn-gold-solid" title="Télécharger bulletin">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
