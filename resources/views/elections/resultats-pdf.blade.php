<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats — {{ $election->titre }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1e293b; background: #fff; padding: 30px; }
        h1 { font-size: 22px; color: #2563EB; margin-bottom: 4px; }
        .subtitle { color: #64748b; font-size: 11px; margin-bottom: 20px; }
        .meta { margin-bottom: 20px; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; background: #f8fafc; }
        .meta p { margin-bottom: 4px; }
        .meta strong { color: #334155; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead th { background: #2563EB; color: #fff; padding: 10px 12px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 10px 12px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        .rank { font-weight: bold; color: #64748b; width: 40px; }
        .rank-1 { color: #ca8a04; font-size: 16px; }
        .rank-2 { color: #94a3b8; font-size: 14px; }
        .rank-3 { color: #b45309; font-size: 13px; }
        .name { font-weight: bold; }
        .bar-wrap { background: #e2e8f0; border-radius: 4px; height: 14px; width: 100%; min-width: 120px; }
        .bar { height: 14px; border-radius: 4px; background: #2563EB; }
        .bar-1 { background: #ca8a04; }
        .bar-2 { background: #94a3b8; }
        .pct { font-weight: bold; color: #2563EB; }
        .pct-1 { color: #ca8a04; }
        .total-box { margin-top: 20px; text-align: right; font-size: 13px; }
        .total-box strong { font-size: 18px; color: #2563EB; }
        .footer { margin-top: 30px; font-size: 10px; color: #94a3b8; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>

    <h1>Résultats — {{ $election->titre }}</h1>
    <p class="subtitle">
        Généré le {{ now()->format('d/m/Y à H:i') }}
        &nbsp;·&nbsp;
        @if($election->statut === 'terminee')
            Résultats définitifs
        @else
            Résultats provisoires
        @endif
    </p>

    <div class="meta">
        <p><strong>Élection :</strong> {{ $election->titre }}</p>
        @if($election->description)
            <p><strong>Description :</strong> {{ $election->description }}</p>
        @endif
        <p><strong>Période :</strong> {{ $election->date_debut->format('d/m/Y') }} → {{ $election->date_fin->format('d/m/Y') }}</p>
        <p><strong>Statut :</strong>
            @if($election->statut === 'active') En cours
            @elseif($election->statut === 'terminee') Terminée
            @else En attente @endif
        </p>
    </div>

    @if($totalVotes === 0)
        <p style="color:#64748b; font-style:italic;">Aucun vote enregistré pour cette élection.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Candidat(e)</th>
                    <th style="width:180px;">Résultat</th>
                    <th style="width:70px; text-align:right;">Votes</th>
                    <th style="width:60px; text-align:right;">%</th>
                </tr>
            </thead>
            <tbody>
                @foreach($candidats as $index => $candidat)
                    <tr>
                        <td class="rank">
                            @if($index === 0) <span class="rank-1">🥇</span>
                            @elseif($index === 1) <span class="rank-2">🥈</span>
                            @elseif($index === 2) <span class="rank-3">🥉</span>
                            @else {{ $index + 1 }} @endif
                        </td>
                        <td class="name">{{ $candidat['nom'] }}</td>
                        <td>
                            <div class="bar-wrap">
                                <div class="bar {{ $index === 0 ? 'bar-1' : ($index === 1 ? 'bar-2' : '') }}"
                                     style="width: {{ $candidat['pourcentage'] }}%;"></div>
                            </div>
                        </td>
                        <td style="text-align:right;">{{ $candidat['nb_votes'] }}</td>
                        <td style="text-align:right;" class="pct {{ $index === 0 ? 'pct-1' : '' }}">
                            {{ $candidat['pourcentage'] }}%
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-box">
            Total : <strong>{{ $totalVotes }}</strong> vote(s) enregistré(s)
        </div>
    @endif

    <div class="footer">
        Système de Vote Universitaire — L3 Génie Logiciel &nbsp;·&nbsp; Document généré automatiquement
    </div>

</body>
</html>
