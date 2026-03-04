@extends('layouts.app')

@section('title', 'Tableau de bord — Administration')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-1"><i class="bi bi-speedometer2 text-primary me-2"></i>Tableau de bord</h2>
        <p class="text-muted mb-0">Vue d'ensemble du système de vote</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.etudiants.create') }}" class="btn btn-success">
            <i class="bi bi-person-plus me-2"></i>Nouvel étudiant
        </a>
        <a href="{{ route('admin.elections.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle élection
        </a>
    </div>
</div>

{{-- Cartes de statistiques --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 text-white h-100" style="background: linear-gradient(135deg, #0d6efd, #0a58ca);">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-ballot-fill opacity-75" style="font-size: 2.5rem;"></i>
                <div>
                    <div class="fs-2 fw-bold lh-1">{{ $nbElections }}</div>
                    <div class="opacity-75 mt-1">Total élections</div>
                </div>
            </div>
            <div class="card-footer bg-black bg-opacity-10 border-0 py-2">
                <a href="{{ route('admin.elections.index') }}" class="text-white-50 small text-decoration-none">
                    Voir toutes <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 text-white h-100" style="background: linear-gradient(135deg, #198754, #146c43);">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-check-circle-fill opacity-75" style="font-size: 2.5rem;"></i>
                <div>
                    <div class="fs-2 fw-bold lh-1">{{ $electionsActives }}</div>
                    <div class="opacity-75 mt-1">Élections actives</div>
                </div>
            </div>
            <div class="card-footer bg-black bg-opacity-10 border-0 py-2">
                <small class="text-white-50">En cours de vote</small>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 text-white h-100" style="background: linear-gradient(135deg, #0dcaf0, #0aa2c0);">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-hand-index-fill opacity-75" style="font-size: 2.5rem;"></i>
                <div>
                    <div class="fs-2 fw-bold lh-1">{{ $nbVotes }}</div>
                    <div class="opacity-75 mt-1">Total votes</div>
                </div>
            </div>
            <div class="card-footer bg-black bg-opacity-10 border-0 py-2">
                <small class="text-white-50">Votes enregistrés</small>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #ffc107, #cc9a06);">
            <div class="card-body d-flex align-items-center gap-3 text-dark">
                <i class="bi bi-mortarboard-fill opacity-75" style="font-size: 2.5rem;"></i>
                <div>
                    <div class="fs-2 fw-bold lh-1">{{ $nbEtudiants }}</div>
                    <div class="opacity-75 mt-1">Étudiants inscrits</div>
                </div>
            </div>
            <div class="card-footer bg-black bg-opacity-10 border-0 py-2">
                <a href="{{ route('admin.etudiants.index') }}" class="text-dark opacity-50 small text-decoration-none">
                    Gérer <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 text-white h-100" style="background: linear-gradient(135deg, #6f42c1, #59359a);">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-person-badge-fill opacity-75" style="font-size: 2.5rem;"></i>
                <div>
                    <div class="fs-2 fw-bold lh-1">{{ $nbCandidats }}</div>
                    <div class="opacity-75 mt-1">Candidats</div>
                </div>
            </div>
            <div class="card-footer bg-black bg-opacity-10 border-0 py-2">
                <small class="text-white-50">Toutes élections confondues</small>
            </div>
        </div>
    </div>
</div>

{{-- Dernières élections --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Dernières élections</h5>
        <a href="{{ route('admin.elections.index') }}" class="btn btn-sm btn-outline-primary">
            Voir tout <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Titre</th>
                        <th>Statut</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dernieresElections as $election)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $election->titre }}</td>
                            <td>
                                @if($election->statut === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($election->statut === 'en_attente')
                                    <span class="badge bg-warning text-dark">En attente</span>
                                @else
                                    <span class="badge bg-secondary">Terminée</span>
                                @endif
                            </td>
                            <td>{{ $election->date_debut->format('d/m/Y') }}</td>
                            <td>{{ $election->date_fin->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.elections.edit', $election) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('elections.resultats', $election) }}"
                                   class="btn btn-sm btn-outline-info ms-1">
                                    <i class="bi bi-bar-chart"></i>
                                </a>
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
@endsection
