@extends('layouts.app')

@section('title', 'Gestion des étudiants')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-1"><i class="bi bi-mortarboard text-primary me-2"></i>Gestion des étudiants</h2>
        <p class="text-muted mb-0">{{ $etudiants->count() }} compte(s) étudiant(s) enregistré(s)</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-speedometer2 me-1"></i>Dashboard
        </a>
        <a href="{{ route('admin.etudiants.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-2"></i>Créer un étudiant
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
                        <th>Nom complet</th>
                        <th>N° Étudiant</th>
                        <th>Email</th>
                        <th class="text-center">Votes</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($etudiants as $etudiant)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $etudiant->id }}</td>
                            <td class="fw-semibold">{{ $etudiant->name }}</td>
                            <td>
                                @if($etudiant->numero_etudiant)
                                    <code class="bg-light px-2 py-1 rounded">{{ $etudiant->numero_etudiant }}</code>
                                @else
                                    <span class="text-muted small fst-italic">Non défini</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $etudiant->email }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $etudiant->votes()->count() }}</span>
                            </td>
                            <td class="text-center">
                                <form method="POST"
                                      action="{{ route('admin.etudiants.destroy', $etudiant) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Supprimer le compte de « {{ addslashes($etudiant->name) }} » ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Aucun étudiant enregistré.
                                <a href="{{ route('admin.etudiants.create') }}">Créez le premier compte</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
