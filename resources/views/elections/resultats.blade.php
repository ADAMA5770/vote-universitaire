@extends('layouts.app')

@section('title', 'Résultats — ' . $election->titre)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('elections.index') }}"><i class="bi bi-ballot me-1"></i>Élections</a>
                </li>
                <li class="breadcrumb-item active">Résultats</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0" style="border-radius:16px; overflow:hidden;">
            <div class="card-header text-white py-4 px-4"
                 style="background: linear-gradient(135deg, #2563EB 0%, #7C3AED 100%);">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <h4 class="mb-1 fw-bold">
                            <i class="bi bi-bar-chart-fill me-2"></i>{{ $election->titre }}
                        </h4>
                        <div class="d-flex align-items-center gap-2 opacity-90">
                            @if($election->statut === 'active')
                                <span class="badge bg-white text-success fw-semibold">
                                    <i class="bi bi-circle-fill me-1" style="font-size:.5rem;"></i>Active
                                </span>
                                <small>Résultats provisoires</small>
                            @elseif($election->statut === 'terminee')
                                <span class="badge bg-white text-secondary fw-semibold">Terminée</span>
                                <small>Résultats définitifs</small>
                            @else
                                <span class="badge bg-white text-warning fw-semibold">En attente</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fs-1 fw-bold lh-1">{{ $totalVotes }}</div>
                        <small class="opacity-75">vote(s)</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">

                @if($totalVotes === 0)
                    <div class="alert alert-info text-center border-0" style="background:#eff6ff;">
                        <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                        Aucun vote enregistré pour le moment.
                    </div>
                @else
                    {{-- Podium top 3 --}}
                    @if($candidats->count() >= 2)
                        @php
                            $podiumColors = ['#ca8a04','#64748b','#b45309'];
                            $podiumBgs    = ['#fefce8','#f8fafc','#fff7ed'];
                            $podiumIcons  = ['bi-trophy-fill','bi-award-fill','bi-patch-check-fill'];
                            $podiumOrder  = ['col-md-5 order-md-2','col-md-4 order-md-1','col-md-3 order-md-3'];
                        @endphp
                        <div class="row g-3 mb-4 justify-content-center align-items-end">
                            @foreach($candidats->take(3) as $i => $c)
                                <div class="{{ $podiumOrder[$i] ?? 'col-md-4' }}">
                                    <div class="card border-0 text-center py-3 px-2 h-100"
                                         style="background:{{ $podiumBgs[$i] }}; border-radius:12px; border-bottom: 3px solid {{ $podiumColors[$i] }} !important;">
                                        @if($c['photo'])
                                            <img src="{{ asset('storage/' . $c['photo']) }}"
                                                 class="rounded-circle mx-auto mb-2"
                                                 width="{{ $i === 0 ? 72 : 56 }}" height="{{ $i === 0 ? 72 : 56 }}"
                                                 style="object-fit:cover; border:3px solid {{ $podiumColors[$i] }};">
                                        @else
                                            <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center fw-bold text-white"
                                                 style="width:{{ $i === 0 ? '72px' : '56px' }};height:{{ $i === 0 ? '72px' : '56px' }};background:{{ $podiumColors[$i] }};font-size:{{ $i === 0 ? '1.8rem' : '1.3rem' }};">
                                                {{ strtoupper(substr($c['nom'], 0, 1)) }}
                                            </div>
                                        @endif
                                        <i class="bi {{ $podiumIcons[$i] }} fs-5 mb-1" style="color:{{ $podiumColors[$i] }};"></i>
                                        <div class="fw-bold small">{{ $c['nom'] }}</div>
                                        <div class="fw-bold fs-5 mt-1" style="color:{{ $podiumColors[$i] }};">{{ $c['pourcentage'] }}%</div>
                                        <small class="text-muted">{{ $c['nb_votes'] }} vote(s)</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Barres de progression animées --}}
                    @php $barColors = ['linear-gradient(90deg,#2563EB,#3b82f6)','linear-gradient(90deg,#7C3AED,#a855f7)','linear-gradient(90deg,#059669,#10b981)','linear-gradient(90deg,#DC2626,#ef4444)','linear-gradient(90deg,#0891b2,#06b6d4)']; @endphp
                    @foreach($candidats as $index => $candidat)
                        <div class="mb-4" style="animation: fadeSlideUp .4s ease both; animation-delay: {{ $index * 0.08 }}s;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    @if($index === 0)
                                        <i class="bi bi-trophy-fill text-warning fs-5"></i>
                                    @elseif($index === 1)
                                        <i class="bi bi-award-fill text-secondary fs-5"></i>
                                    @elseif($index === 2)
                                        <i class="bi bi-patch-check-fill fs-5" style="color:#b45309;"></i>
                                    @else
                                        <span class="badge bg-light text-muted border fw-normal px-2">{{ $index + 1 }}</span>
                                    @endif
                                    @if($candidat['photo'])
                                        <img src="{{ asset('storage/' . $candidat['photo']) }}"
                                             class="rounded-circle" width="32" height="32"
                                             style="object-fit:cover;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                             style="width:32px;height:32px;font-size:.8rem;background:{{ ['#2563EB','#7C3AED','#059669','#DC2626','#0891b2'][$index % 5] }};">
                                            {{ strtoupper(substr($candidat['nom'], 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="fw-semibold">{{ $candidat['nom'] }}</span>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold fs-5" style="color:{{ ['#2563EB','#7C3AED','#059669','#DC2626','#0891b2'][$index % 5] }};">
                                        {{ $candidat['pourcentage'] }}%
                                    </span>
                                    <span class="text-muted small ms-1">({{ $candidat['nb_votes'] }})</span>
                                </div>
                            </div>
                            <div class="progress" style="height:22px; border-radius:50px; background:#f1f5f9;">
                                <div class="progress-bar"
                                     role="progressbar"
                                     data-width="{{ $candidat['pourcentage'] }}"
                                     style="width:0%; border-radius:50px; background:{{ $barColors[$index % 5] }};"
                                     aria-valuenow="{{ $candidat['pourcentage'] }}"
                                     aria-valuemin="0" aria-valuemax="100">
                                    @if($candidat['pourcentage'] > 10)
                                        <span class="px-2">{{ $candidat['pourcentage'] }}%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>

            <div class="card-footer bg-transparent px-4 py-3 d-flex flex-wrap gap-2 align-items-center">
                @if($election->statut === 'active')
                    <a href="{{ route('elections.show', $election) }}" class="btn btn-primary">
                        <i class="bi bi-hand-index-thumb me-2"></i>Voter
                    </a>
                @endif
                <a href="{{ route('elections.resultats.pdf', $election) }}" class="btn btn-outline-danger">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Télécharger PDF
                </a>
                <a href="{{ route('elections.index') }}" class="btn btn-outline-secondary ms-auto">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@push('scripts')
<script>
    document.querySelectorAll('.progress-bar[data-width]').forEach(bar => {
        setTimeout(() => {
            bar.style.transition = 'width .9s ease';
            bar.style.width = bar.dataset.width + '%';
        }, 300);
    });
</script>
@endpush
@endsection
