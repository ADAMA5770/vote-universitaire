@extends('layouts.app')

@section('title', 'Tableau de bord — Administration')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color:var(--navy);">
            <i class="bi bi-speedometer2 me-2" style="color:var(--gold);"></i>Tableau de bord
        </h2>
        <p class="text-muted mb-0">Vue d'ensemble du système de vote universitaire</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        {{-- Toggle maintenance --}}
        <form method="POST" action="{{ route('admin.maintenance') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn fw-semibold {{ $maintenance ? 'btn-warning' : 'btn-outline-warning' }}"
                    title="{{ $maintenance ? 'Désactiver la maintenance' : 'Activer la maintenance' }}">
                <i class="bi bi-tools me-1"></i>
                {{ $maintenance ? 'Maintenance ON' : 'Maintenance OFF' }}
            </button>
        </form>
        <a href="{{ route('admin.etudiants.create') }}" class="btn btn-navy fw-semibold">
            <i class="bi bi-person-plus me-2"></i>Nouvel étudiant
        </a>
        <a href="{{ route('admin.elections.create') }}" class="btn btn-gold-solid fw-bold">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle élection
        </a>
    </div>
</div>

{{-- Cartes statistiques ──────────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- Élections --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 h-100" style="border-top:4px solid var(--navy) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase mb-2" style="letter-spacing:.5px;">
                            Total élections
                        </div>
                        <div class="fw-bold" style="font-size:2.4rem; line-height:1; color:var(--navy);">
                            {{ $nbElections }}
                        </div>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:#eef2f7;">
                        <i class="bi bi-ballot-fill fs-3" style="color:var(--navy);"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 bg-transparent py-2 px-4">
                <a href="{{ route('admin.elections.index') }}"
                   class="text-decoration-none small fw-semibold" style="color:var(--navy);">
                    Gérer <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Actives --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 h-100" style="border-top:4px solid var(--green) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase mb-2" style="letter-spacing:.5px;">
                            Élections actives
                        </div>
                        <div class="fw-bold" style="font-size:2.4rem; line-height:1; color:var(--green);">
                            {{ $electionsActives }}
                        </div>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:#e8f5e9;">
                        <i class="bi bi-check-circle-fill fs-3" style="color:var(--green);"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 bg-transparent py-2 px-4">
                <small class="text-muted">En cours de vote</small>
            </div>
        </div>
    </div>

    {{-- Votes --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 h-100" style="border-top:4px solid var(--gold) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase mb-2" style="letter-spacing:.5px;">
                            Total votes
                        </div>
                        <div class="fw-bold" style="font-size:2.4rem; line-height:1; color:var(--gold);">
                            {{ $nbVotes }}
                        </div>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:#fdf8ec;">
                        <i class="bi bi-hand-index-fill fs-3" style="color:var(--gold);"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 bg-transparent py-2 px-4">
                <small class="text-muted">Votes enregistrés</small>
            </div>
        </div>
    </div>

    {{-- Étudiants --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 h-100" style="border-top:4px solid #7b8fa1 !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase mb-2" style="letter-spacing:.5px;">
                            Étudiants
                        </div>
                        <div class="fw-bold" style="font-size:2.4rem; line-height:1; color:#7b8fa1;">
                            {{ $nbEtudiants }}
                        </div>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:#f1f4f6;">
                        <i class="bi bi-mortarboard-fill fs-3" style="color:#7b8fa1;"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 bg-transparent py-2 px-4">
                <a href="{{ route('admin.etudiants.index') }}"
                   class="text-decoration-none small fw-semibold" style="color:#7b8fa1;">
                    Gérer <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Candidats --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 h-100" style="border-top:4px solid var(--red) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase mb-2" style="letter-spacing:.5px;">
                            Candidats
                        </div>
                        <div class="fw-bold" style="font-size:2.4rem; line-height:1; color:var(--red);">
                            {{ $nbCandidats }}
                        </div>
                    </div>
                    <div class="rounded d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:#fff0f0;">
                        <i class="bi bi-person-badge-fill fs-3" style="color:var(--red);"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 bg-transparent py-2 px-4">
                <small class="text-muted">Toutes élections</small>
            </div>
        </div>
    </div>

</div>

{{-- Alerte maintenance ──────────────────────────────────────── --}}
@if($maintenance)
<div class="alert mb-4 d-flex align-items-center gap-3"
     style="background:#fff3e0; border-left:4px solid #e65100; border-radius:8px;">
    <i class="bi bi-tools fs-4" style="color:#e65100;"></i>
    <div>
        <strong style="color:#e65100;">Mode maintenance actif</strong>
        <div class="small text-muted">Les étudiants voient la page de maintenance. Vous seul y avez accès.</div>
    </div>
</div>
@endif

{{-- Chart.js : votes par élection ───────────────────────── --}}
@if($chartData->sum() > 0)
<div class="card border-0 mb-4">
    <div class="card-header bg-white py-3" style="border-bottom:2px solid #f0f2f5;">
        <h6 class="mb-0 fw-bold" style="color:var(--navy);">
            <i class="bi bi-bar-chart-fill me-2" style="color:var(--gold);"></i>Votes par élection
        </h6>
    </div>
    <div class="card-body p-4">
        <canvas id="chartVotes" height="90"></canvas>
    </div>
</div>
@endif

{{-- Dernières élections ───────────────────────────────── --}}
<div class="card border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3"
         style="border-bottom:2px solid #f0f2f5;">
        <h6 class="mb-0 fw-bold" style="color:var(--navy);">
            <i class="bi bi-clock-history me-2" style="color:var(--gold);"></i>Dernières élections
        </h6>
        <a href="{{ route('admin.elections.index') }}"
           class="btn btn-sm btn-navy fw-semibold">
            Voir tout <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead style="background:#f8f9fa;">
                    <tr>
                        <th class="ps-4 py-3 text-muted small fw-semibold text-uppercase"
                            style="letter-spacing:.4px;">Titre</th>
                        <th class="py-3 text-muted small fw-semibold text-uppercase"
                            style="letter-spacing:.4px;">Statut</th>
                        <th class="py-3 text-muted small fw-semibold text-uppercase"
                            style="letter-spacing:.4px;">Début</th>
                        <th class="py-3 text-muted small fw-semibold text-uppercase"
                            style="letter-spacing:.4px;">Fin</th>
                        <th class="py-3 text-muted small fw-semibold text-uppercase"
                            style="letter-spacing:.4px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dernieresElections as $election)
                        <tr>
                            <td class="ps-4 py-3 fw-semibold" style="color:var(--navy);">
                                {{ $election->titre }}
                            </td>
                            <td class="py-3">
                                @if($election->statut === 'active')
                                    <span class="badge fw-semibold"
                                          style="background:#e8f5e9; color:var(--green);">
                                        <i class="bi bi-circle-fill me-1"
                                           style="font-size:.35rem; vertical-align:middle;"></i>Active
                                    </span>
                                @elseif($election->statut === 'en_attente')
                                    <span class="badge fw-semibold"
                                          style="background:#fff3e0; color:#e65100;">En attente</span>
                                @else
                                    <span class="badge bg-secondary fw-semibold">Terminée</span>
                                @endif
                            </td>
                            <td class="py-3 text-muted small">{{ $election->date_debut->format('d/m/Y') }}</td>
                            <td class="py-3 text-muted small">{{ $election->date_fin->format('d/m/Y') }}</td>
                            <td class="py-3">
                                <div class="d-flex gap-1">
                                    @if($election->statut !== 'active')
                                        <a href="{{ route('admin.elections.edit', $election) }}"
                                           class="btn btn-sm btn-navy" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('elections.resultats', $election) }}"
                                       class="btn btn-sm btn-outline-secondary" title="Résultats">
                                        <i class="bi bi-bar-chart"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox me-2"></i>Aucune élection pour le moment
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('chartVotes');
if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Votes',
                data: {!! json_encode($chartData) !!},
                backgroundColor: 'rgba(30,58,95,.75)',
                hoverBackgroundColor: '#C8A951',
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} vote(s)`
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f0f2f5' } },
                x: { grid: { display: false } }
            }
        }
    });
}
</script>
@endpush
@endsection
