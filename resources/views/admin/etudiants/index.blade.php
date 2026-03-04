@extends('layouts.app')

@section('title', 'Gestion des étudiants')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-1 fw-bold" style="color:#1e293b;">
            <i class="bi bi-mortarboard me-2" style="color:#2563EB;"></i>Gestion des étudiants
        </h2>
        <p class="text-muted mb-0">{{ $etudiants->count() }} compte(s) enregistré(s)</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-speedometer2 me-1"></i>Dashboard
        </a>
        <a href="{{ route('admin.etudiants.create') }}" class="btn text-white fw-semibold"
           style="background:linear-gradient(90deg,#2563EB,#7C3AED); border:none;">
            <i class="bi bi-person-plus me-2"></i>Nouvel étudiant
        </a>
    </div>
</div>

<div class="card border-0" style="border-radius:16px; overflow:hidden;">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8fafc;">
                <tr>
                    <th class="ps-4 py-3 text-muted fw-semibold small text-uppercase" style="letter-spacing:.5px;">Étudiant</th>
                    <th class="py-3 text-muted fw-semibold small text-uppercase" style="letter-spacing:.5px;">N° Étudiant</th>
                    <th class="py-3 text-muted fw-semibold small text-uppercase" style="letter-spacing:.5px;">Email</th>
                    <th class="py-3 text-center text-muted fw-semibold small text-uppercase" style="letter-spacing:.5px;">Votes</th>
                    <th class="py-3 text-center text-muted fw-semibold small text-uppercase" style="letter-spacing:.5px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($etudiants as $etudiant)
                    @php
                        $colors = ['#2563EB','#7C3AED','#059669','#DC2626','#0891b2','#d97706'];
                        $bg = $colors[$etudiant->id % count($colors)];
                    @endphp
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                     style="width:40px;height:40px;background:{{ $bg }};font-size:.9rem;">
                                    {{ strtoupper(substr($etudiant->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="color:#1e293b;">{{ $etudiant->name }}</div>
                                    <small class="text-muted">#{{ $etudiant->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            @if($etudiant->numero_etudiant)
                                <span class="badge fw-normal px-3 py-2"
                                      style="background:#eff6ff; color:#2563EB; font-family:monospace; font-size:.8rem;">
                                    {{ $etudiant->numero_etudiant }}
                                </span>
                            @else
                                <span class="text-muted small fst-italic">Non défini</span>
                            @endif
                        </td>
                        <td class="py-3 text-muted small">{{ $etudiant->email }}</td>
                        <td class="py-3 text-center">
                            <span class="badge rounded-pill px-3 py-2"
                                  style="background:#eff6ff; color:#2563EB;">
                                {{ $etudiant->votes()->count() }}
                            </span>
                        </td>
                        <td class="py-3 text-center">
                            <form method="POST"
                                  action="{{ route('admin.etudiants.destroy', $etudiant) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Supprimer le compte de « {{ addslashes($etudiant->name) }} » ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm"
                                        style="background:#fef2f2; color:#DC2626; border:none; border-radius:8px;"
                                        title="Supprimer ce compte">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div style="font-size:3rem; opacity:.3;">🎓</div>
                            <p class="text-muted mt-2 mb-1">Aucun étudiant enregistré.</p>
                            <a href="{{ route('admin.etudiants.create') }}" class="btn btn-sm btn-primary mt-2">
                                Créez le premier compte
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
