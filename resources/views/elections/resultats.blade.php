@extends('layouts.app')

@section('title', 'Résultats — ' . $election->titre)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="{{ route('elections.index') }}" class="text-decoration-none fw-semibold"
                       style="color:var(--navy);">
                        <i class="bi bi-ballot me-1"></i>Élections
                    </a>
                </li>
                <li class="breadcrumb-item active text-muted">Résultats</li>
            </ol>
        </nav>

        {{-- En-tête résultats ──────────────────────────── --}}
        <div class="card border-0 mb-4 overflow-hidden">
            <div class="d-flex align-items-stretch">
                <div style="width:8px; background:var(--navy); flex-shrink:0;"></div>
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-4 flex-grow-1">
                    <div>
                        <h4 class="fw-bold mb-1" style="color:var(--navy);">
                            <i class="bi bi-bar-chart-fill me-2" style="color:var(--gold);"></i>
                            {{ $election->titre }}
                        </h4>
                        <div class="d-flex align-items-center gap-2">
                            @if($election->statut === 'active')
                                <span class="badge fw-semibold"
                                      style="background:#e8f5e9; color:var(--green);">
                                    <i class="bi bi-circle-fill me-1" style="font-size:.35rem; vertical-align:middle;"></i>Active
                                </span>
                                <small class="text-muted">Résultats provisoires</small>
                            @elseif($election->statut === 'terminee')
                                <span class="badge bg-secondary fw-semibold">Terminée</span>
                                <small class="text-muted">Résultats définitifs</small>
                            @else
                                <span class="badge" style="background:#fff3e0; color:#e65100;">En attente</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-center rounded p-3" style="background:var(--navy); min-width:90px;">
                        <div class="fs-1 fw-bold lh-1 text-white">{{ $totalVotes }}</div>
                        <div class="small mt-1" style="color:var(--gold);">vote(s)</div>
                    </div>
                </div>
            </div>
        </div>

        @if($totalVotes === 0)
            <div class="card border-0 text-center py-5" style="border-top:4px solid var(--gold) !important;">
                <div class="card-body">
                    <i class="bi bi-hourglass-split fs-1 mb-2" style="color:var(--navy); opacity:.4;"></i>
                    <p class="text-muted mt-2 mb-0">Aucun vote enregistré pour le moment.</p>
                </div>
            </div>
        @else

            {{-- Podium top 3 ─────────────────────────── --}}
            @if($candidats->count() >= 2)
                @php
                    $medals = [
                        ['color'=>'#C8A951','bg'=>'#fdf8ec','icon'=>'bi-trophy-fill'],
                        ['color'=>'#94a3b8','bg'=>'#f8fafc','icon'=>'bi-award-fill'],
                        ['color'=>'#b07d44','bg'=>'#fdf5ec','icon'=>'bi-patch-check-fill'],
                    ];
                    $podiumOrder = ['col-md-5 order-md-2','col-md-4 order-md-1','col-md-3 order-md-3'];
                @endphp
                <div class="row g-3 mb-4 justify-content-center align-items-end">
                    @foreach($candidats->take(3) as $i => $c)
                        @php $m = $medals[$i]; @endphp
                        <div class="{{ $podiumOrder[$i] ?? 'col-md-4' }}">
                            <div class="card border-0 text-center py-3 px-2 h-100"
                                 style="background:{{ $m['bg'] }}; border-bottom:3px solid {{ $m['color'] }} !important;">
                                @if($c['photo'])
                                    <img src="{{ asset('storage/' . $c['photo']) }}"
                                         class="rounded-circle mx-auto mb-2"
                                         width="{{ $i===0 ? 76 : 58 }}" height="{{ $i===0 ? 76 : 58 }}"
                                         style="object-fit:cover; border:3px solid {{ $m['color'] }};">
                                @else
                                    <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center fw-bold text-white"
                                         style="width:{{ $i===0?'76px':'58px' }};height:{{ $i===0?'76px':'58px' }};background:{{ $m['color'] }};font-size:{{ $i===0?'1.9rem':'1.4rem' }};">
                                        {{ strtoupper(substr($c['nom'], 0, 1)) }}
                                    </div>
                                @endif
                                <i class="bi {{ $m['icon'] }} fs-5 mb-1" style="color:{{ $m['color'] }};"></i>
                                <div class="fw-bold small" style="color:var(--navy);">{{ $c['nom'] }}</div>
                                <div class="fw-bold fs-5 mt-1" style="color:{{ $m['color'] }};">{{ $c['pourcentage'] }}%</div>
                                <small class="text-muted">{{ $c['nb_votes'] }} vote(s)</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Barres de progression ─────────────────── --}}
            <div class="card border-0">
                <div class="card-body p-4">
                    @foreach($candidats as $index => $candidat)
                        <div class="mb-4"
                             style="animation:fadeSlideIn .4s ease both; animation-delay:{{ $index * .07 }}s;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    @if($index === 0)
                                        <i class="bi bi-trophy-fill fs-5" style="color:var(--gold);"></i>
                                    @elseif($index === 1)
                                        <i class="bi bi-award-fill fs-5 text-secondary"></i>
                                    @elseif($index === 2)
                                        <i class="bi bi-patch-check-fill fs-5" style="color:#b07d44;"></i>
                                    @else
                                        <span class="badge bg-light text-muted border" style="min-width:26px;">
                                            {{ $index + 1 }}
                                        </span>
                                    @endif
                                    @if($candidat['photo'])
                                        <img src="{{ asset('storage/' . $candidat['photo']) }}"
                                             class="rounded-circle flex-shrink-0"
                                             width="34" height="34" style="object-fit:cover;">
                                    @else
                                        <div class="rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center text-white fw-bold"
                                             style="width:34px;height:34px;font-size:.82rem;background:var(--navy);">
                                            {{ strtoupper(substr($candidat['nom'], 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="fw-semibold" style="color:var(--navy);">{{ $candidat['nom'] }}</span>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold fs-5" style="color:var(--navy);">
                                        {{ $candidat['pourcentage'] }}%
                                    </span>
                                    <span class="text-muted small ms-1">({{ $candidat['nb_votes'] }})</span>
                                </div>
                            </div>
                            <div class="progress" style="height:18px; border-radius:50px; background:#e9ecef;">
                                <div class="progress-bar"
                                     role="progressbar"
                                     data-width="{{ $candidat['pourcentage'] }}"
                                     style="width:0%; border-radius:50px;
                                            background:{{ $index===0 ? 'var(--gold)' : 'var(--navy)' }};
                                            opacity:{{ max(1 - $index * 0.12, 0.45) }};"
                                     aria-valuenow="{{ $candidat['pourcentage'] }}"
                                     aria-valuemin="0" aria-valuemax="100">
                                    @if($candidat['pourcentage'] > 12)
                                        <span class="px-2 small fw-bold" style="color:{{ $index===0 ? 'var(--navy)' : '#fff' }};">
                                            {{ $candidat['pourcentage'] }}%
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Actions ──────────────────────────────────── --}}
        <div class="d-flex flex-wrap gap-2 align-items-center mt-4">
            @if($election->statut === 'active')
                <a href="{{ route('elections.show', $election) }}" class="btn btn-navy">
                    <i class="bi bi-hand-index-thumb me-2"></i>Voter
                </a>
            @endif
            <a href="{{ route('elections.resultats.pdf', $election) }}" class="btn btn-gold-solid fw-bold">
                <i class="bi bi-file-earmark-pdf me-2"></i>Télécharger PDF
            </a>
            <a href="{{ route('elections.index') }}" class="btn btn-outline-secondary ms-auto">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
        </div>

    </div>
</div>

@push('styles')
<style>
    @keyframes fadeSlideIn {
        from { opacity: 0; transform: translateX(-8px); }
        to   { opacity: 1; transform: translateX(0); }
    }
</style>
@endpush
@push('scripts')
<script>
    document.querySelectorAll('.progress-bar[data-width]').forEach(bar => {
        setTimeout(() => {
            bar.style.transition = 'width 1s ease';
            bar.style.width = bar.dataset.width + '%';
        }, 300);
    });
</script>
@endpush
@endsection
