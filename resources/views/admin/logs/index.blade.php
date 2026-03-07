@extends('layouts.app')

@section('title', 'Journal d\'activité')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color:var(--navy);">
            <i class="bi bi-journal-text me-2" style="color:var(--gold);"></i>Journal d'activité
        </h2>
        <p class="text-muted mb-0">{{ $logs->total() }} événement(s) enregistré(s)</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
        <i class="bi bi-speedometer2 me-1"></i>Dashboard
    </a>
</div>

<div class="card border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th class="ps-4 py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing:.4px;">Date</th>
                    <th class="py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing:.4px;">Utilisateur</th>
                    <th class="py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing:.4px;">Action</th>
                    <th class="py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing:.4px;">Détails</th>
                    <th class="py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing:.4px;">IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="ps-4 py-3 text-muted small" style="white-space:nowrap;">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="py-3">
                            @if($log->user)
                                <div class="fw-semibold small" style="color:var(--navy);">{{ $log->user->name }}</div>
                                <small class="text-muted">{{ $log->user->role }}</small>
                            @else
                                <span class="text-muted small fst-italic">Système</span>
                            @endif
                        </td>
                        <td class="py-3">
                            @php
                                $badges = [
                                    'connexion'          => ['bg'=>'#e8f5e9','color'=>'var(--green)','label'=>'Connexion'],
                                    'deconnexion'        => ['bg'=>'#f8f9fa','color'=>'#94a3b8','label'=>'Déconnexion'],
                                    'vote'               => ['bg'=>'#fdf8ec','color'=>'var(--gold)','label'=>'Vote'],
                                    'election_creee'     => ['bg'=>'#eef2f7','color'=>'var(--navy)','label'=>'Élection créée'],
                                    'election_supprimee' => ['bg'=>'#fff0f0','color'=>'var(--red)','label'=>'Élection supprimée'],
                                    'etudiant_cree'      => ['bg'=>'#eef2f7','color'=>'var(--navy)','label'=>'Étudiant créé'],
                                    'etudiant_supprime'  => ['bg'=>'#fff0f0','color'=>'var(--red)','label'=>'Étudiant supprimé'],
                                    'candidat_cree'      => ['bg'=>'#eef2f7','color'=>'var(--navy)','label'=>'Candidat ajouté'],
                                    'maintenance'        => ['bg'=>'#fff3e0','color'=>'#e65100','label'=>'Maintenance'],
                                ];
                                $b = $badges[$log->action] ?? ['bg'=>'#f8f9fa','color'=>'#94a3b8','label'=>$log->action];
                            @endphp
                            <span class="badge fw-semibold" style="background:{{ $b['bg'] }}; color:{{ $b['color'] }}; padding:.35em .75em;">
                                {{ $b['label'] }}
                            </span>
                        </td>
                        <td class="py-3 text-muted small">{{ $log->details ?? '—' }}</td>
                        <td class="py-3 text-muted small">{{ $log->ip ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-journal fs-1 d-block mb-2" style="color:var(--navy); opacity:.3;"></i>
                            <p class="text-muted mb-0">Aucun événement enregistré.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($logs->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $logs->links() }}
    </div>
@endif
@endsection
