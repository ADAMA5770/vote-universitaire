@extends('layouts.app')

@section('title', 'Gestion des étudiants')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color:var(--navy);">
            <i class="bi bi-mortarboard me-2" style="color:var(--gold);"></i>Gestion des étudiants
        </h2>
        <p class="text-muted mb-0">{{ $etudiants->count() }} compte(s) enregistré(s)</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-speedometer2 me-1"></i>Dashboard
        </a>
        <a href="{{ route('admin.etudiants.create') }}" class="btn btn-navy fw-semibold">
            <i class="bi bi-person-plus me-2"></i>Nouvel étudiant
        </a>
    </div>
</div>

{{-- Barre de recherche --}}
<div class="card border-0 mb-3 px-3 py-3" style="background:#f8f9fa;">
    <div class="row g-2 align-items-center">
        <div class="col-sm-8">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" id="searchEtudiant" class="form-control border-start-0"
                       placeholder="Rechercher par nom ou numéro étudiant…">
            </div>
        </div>
        <div class="col-sm-4 text-end">
            <small class="text-muted" id="countEtudiants"></small>
        </div>
    </div>
</div>

<div class="card border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th class="ps-4 py-3 text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px;">Étudiant</th>
                    <th class="py-3 text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px;">N° Étudiant</th>
                    <th class="py-3 text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px;">Email</th>
                    <th class="py-3 text-center text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px;">Votes</th>
                    <th class="py-3 text-center text-muted small fw-semibold text-uppercase"
                        style="letter-spacing:.4px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($etudiants as $etudiant)
                    @php
                        $avatarColors = [
                            '#1E3A5F','#2D6A4F','#b07d44','#7b8fa1','#C1121F','#4a6fa5'
                        ];
                        $avatarBg = $avatarColors[$etudiant->id % count($avatarColors)];
                    @endphp
                    <tr data-nom="{{ strtolower($etudiant->name) }}"
                        data-numero="{{ strtolower($etudiant->numero_etudiant ?? '') }}">
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                     style="width:40px;height:40px;background:{{ $avatarBg }};font-size:.9rem;">
                                    {{ strtoupper(substr($etudiant->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="color:var(--navy);">{{ $etudiant->name }}</div>
                                    <small class="text-muted">Compte #{{ $etudiant->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            @if($etudiant->numero_etudiant)
                                <code class="px-2 py-1 rounded small"
                                      style="background:#eef2f7; color:var(--navy); font-size:.82rem;">
                                    {{ $etudiant->numero_etudiant }}
                                </code>
                            @else
                                <span class="text-muted small fst-italic">Non défini</span>
                            @endif
                        </td>
                        <td class="py-3 text-muted small">{{ $etudiant->email }}</td>
                        <td class="py-3 text-center">
                            @php $nbVotes = $etudiant->votes()->count(); @endphp
                            <span class="badge rounded-pill fw-semibold"
                                  style="background:{{ $nbVotes > 0 ? '#e8f5e9' : '#f8f9fa' }};
                                         color:{{ $nbVotes > 0 ? 'var(--green)' : '#94a3b8' }};
                                         min-width:30px;">
                                {{ $nbVotes }}
                            </span>
                        </td>
                        <td class="py-3 text-center">
                            <form method="POST"
                                  action="{{ route('admin.etudiants.destroy', $etudiant) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Supprimer le compte de « {{ addslashes($etudiant->name) }} » ? Cette action est irréversible.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm"
                                        style="background:#fff0f0; color:var(--red); border:none; border-radius:7px;"
                                        title="Supprimer ce compte">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-mortarboard fs-1 d-block mb-2" style="color:var(--navy); opacity:.3;"></i>
                            <p class="text-muted mb-2">Aucun étudiant enregistré.</p>
                            <a href="{{ route('admin.etudiants.create') }}"
                               class="btn btn-sm btn-navy fw-semibold">
                                Créer le premier compte
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
    const input = document.getElementById('searchEtudiant');
    const countEl = document.getElementById('countEtudiants');
    input.addEventListener('input', function () {
        const q    = this.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr[data-nom]');
        let visible = 0;
        rows.forEach(row => {
            const match = row.dataset.nom.includes(q) || row.dataset.numero.includes(q);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        countEl.textContent = visible + ' résultat(s)';
    });
</script>
@endpush
@endsection
