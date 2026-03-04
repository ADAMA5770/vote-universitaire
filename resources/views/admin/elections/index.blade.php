@extends('layouts.app')

@section('title', 'Gestion des élections')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-1"><i class="bi bi-list-check text-primary me-2"></i>Gestion des élections</h2>
        <p class="text-muted mb-0">{{ $elections->count() }} élection(s) au total</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-speedometer2 me-1"></i>Dashboard
        </a>
        <a href="{{ route('admin.elections.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle élection
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Titre</th>
                        <th>Statut</th>
                        <th class="text-center">Candidats</th>
                        <th class="text-center">Votes</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($elections as $election)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $election->id }}</td>
                            <td class="fw-semibold">{{ $election->titre }}</td>
                            <td>
                                @if($election->statut === 'active')
                                    <span class="badge bg-success">
                                        <i class="bi bi-circle-fill me-1" style="font-size:.4rem;"></i>Active
                                    </span>
                                @elseif($election->statut === 'en_attente')
                                    <span class="badge bg-warning text-dark">En attente</span>
                                @else
                                    <span class="badge bg-secondary">Terminée</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark">{{ $election->candidats()->count() }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $election->votes()->count() }}</span>
                            </td>
                            <td>{{ $election->date_debut->format('d/m/Y') }}</td>
                            <td>{{ $election->date_fin->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('elections.resultats', $election) }}"
                                       class="btn btn-outline-info" title="Résultats">
                                        <i class="bi bi-bar-chart"></i>
                                    </a>
                                    <a href="{{ route('admin.elections.edit', $election) }}"
                                       class="btn btn-outline-primary" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    {{-- [SÉCURITÉ] Suppression interdite si des votes ont déjà été enregistrés --}}
                                    @if($election->votes()->count() > 0)
                                        <button type="button"
                                                class="btn btn-outline-danger"
                                                style="opacity:.4; cursor:not-allowed;"
                                                title="Suppression impossible : {{ $election->votes()->count() }} vote(s) enregistré(s). Clôturez l'élection."
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
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Aucune élection.
                                <a href="{{ route('admin.elections.create') }}">Créez la première !</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script>
    // Activer les tooltips Bootstrap (info sur bouton suppression désactivé)
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });
</script>
@endpush
@endsection
