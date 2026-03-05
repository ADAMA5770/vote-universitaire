@extends('layouts.app')

@section('title', 'Gestion des élections')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color:var(--navy);">
            <i class="bi bi-list-check me-2" style="color:var(--gold);"></i>Gestion des élections
        </h2>
        <p class="text-muted mb-0">{{ $elections->count() }} élection(s) au total</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-speedometer2 me-1"></i>Dashboard
        </a>
        <a href="{{ route('admin.elections.create') }}" class="btn btn-gold-solid fw-bold">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle élection
        </a>
    </div>
</div>

<div class="card border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th class="ps-4 py-3 text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px; width:32px;">#</th>
                    <th class="py-3 text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px;">Titre</th>
                    <th class="py-3 text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px;">Statut</th>
                    <th class="py-3 text-center text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px;">Candidats</th>
                    <th class="py-3 text-center text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px;">Votes</th>
                    <th class="py-3 text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px;">Début</th>
                    <th class="py-3 text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px;">Fin</th>
                    <th class="py-3 text-center text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($elections as $election)
                    <tr>
                        <td class="ps-4 py-3 text-muted small">{{ $election->id }}</td>
                        <td class="py-3 fw-semibold" style="color:var(--navy);">{{ $election->titre }}</td>
                        <td class="py-3">
                            @if($election->statut === 'active')
                                <span class="badge fw-semibold"
                                      style="background:#e8f5e9; color:var(--green); padding:.35em .75em;">
                                    <i class="bi bi-circle-fill me-1"
                                       style="font-size:.35rem; vertical-align:middle;"></i>Active
                                </span>
                            @elseif($election->statut === 'en_attente')
                                <span class="badge fw-semibold"
                                      style="background:#fff3e0; color:#e65100; padding:.35em .75em;">
                                    En attente
                                </span>
                            @else
                                <span class="badge bg-secondary fw-semibold" style="padding:.35em .75em;">
                                    Terminée
                                </span>
                            @endif
                        </td>
                        <td class="py-3 text-center">
                            <span class="badge rounded-pill fw-semibold"
                                  style="background:#eef2f7; color:var(--navy); min-width:28px;">
                                {{ $election->candidats()->count() }}
                            </span>
                        </td>
                        <td class="py-3 text-center">
                            <span class="badge rounded-pill fw-semibold"
                                  style="background:#fdf8ec; color:var(--gold); min-width:28px;">
                                {{ $election->votes()->count() }}
                            </span>
                        </td>
                        <td class="py-3 text-muted small">{{ $election->date_debut->format('d/m/Y') }}</td>
                        <td class="py-3 text-muted small">{{ $election->date_fin->format('d/m/Y') }}</td>
                        <td class="py-3 text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                {{-- Résultats --}}
                                <a href="{{ route('elections.resultats', $election) }}"
                                   class="btn btn-sm btn-outline-secondary" title="Résultats">
                                    <i class="bi bi-bar-chart"></i>
                                </a>

                                {{-- Modifier : désactivé si active --}}
                                @if($election->statut === 'active')
                                    <button type="button"
                                            class="btn btn-sm btn-navy disabled"
                                            style="opacity:.35; cursor:not-allowed;"
                                            title="Modification impossible : l'élection est active"
                                            data-bs-toggle="tooltip" data-bs-placement="top">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                @else
                                    <a href="{{ route('admin.elections.edit', $election) }}"
                                       class="btn btn-sm btn-navy" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                @endif

                                {{-- Supprimer : désactivé si votes --}}
                                @if($election->votes()->count() > 0)
                                    <button type="button"
                                            class="btn btn-sm"
                                            style="background:#fff0f0; color:var(--red); opacity:.4; cursor:not-allowed;"
                                            title="Suppression impossible : {{ $election->votes()->count() }} vote(s)"
                                            data-bs-toggle="tooltip" data-bs-placement="left">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @else
                                    <form method="POST"
                                          action="{{ route('admin.elections.destroy', $election) }}"
                                          class="d-inline"
                                          onsubmit="return confirm('Supprimer « {{ addslashes($election->titre) }} » ? Cette action est irréversible.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"
                                                style="background:#fff0f0; color:var(--red); border:none;"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-muted"></i>
                            <p class="text-muted mb-2">Aucune élection.</p>
                            <a href="{{ route('admin.elections.create') }}"
                               class="btn btn-sm btn-gold-solid fw-semibold">
                                Créez la première !
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });
</script>
@endpush
@endsection
