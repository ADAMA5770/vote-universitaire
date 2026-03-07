<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin de vote</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #1a1a1a; background: #fff; padding: 40px; }

        .header { text-align: center; border-bottom: 3px solid #1E3A5F; padding-bottom: 20px; margin-bottom: 30px; }
        .header .uni-name { font-size: 13px; color: #666; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .header h1 { font-size: 22px; color: #1E3A5F; font-weight: bold; }
        .header .subtitle { font-size: 11px; color: #C8A951; text-transform: uppercase; letter-spacing: 2px; margin-top: 4px; }

        .section-title { font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; margin-bottom: 6px; }

        .info-box { border: 1px solid #e9ecef; border-radius: 8px; padding: 16px 20px; margin-bottom: 16px; }
        .info-row { display: table; width: 100%; margin-bottom: 6px; }
        .info-label { display: table-cell; width: 160px; color: #666; font-size: 11px; }
        .info-value { display: table-cell; color: #1E3A5F; font-size: 11px; font-weight: bold; }

        .candidat-box { background: #eef2f7; border-left: 5px solid #C8A951; border-radius: 8px; padding: 20px; margin-bottom: 24px; text-align: center; }
        .candidat-box .candidat-label { font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .candidat-box .candidat-name { font-size: 20px; color: #1E3A5F; font-weight: bold; margin-top: 6px; }

        .cachet-wrapper { text-align: center; margin: 28px 0; }
        .cachet { display: inline-block; border: 4px solid #2D6A4F; border-radius: 12px; padding: 14px 36px; }
        .cachet .cachet-text { font-size: 18px; color: #2D6A4F; font-weight: bold; letter-spacing: 3px; }
        .cachet .cachet-check { font-size: 26px; color: #2D6A4F; margin-bottom: 4px; }

        .hash-box { border: 1px dashed #cbd5e1; border-radius: 6px; padding: 12px 16px; text-align: center; margin-bottom: 24px; }
        .hash-label { font-size: 9px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .hash-value { font-family: monospace; font-size: 13px; color: #475569; letter-spacing: 2px; }

        .footer { text-align: center; border-top: 1px solid #e9ecef; padding-top: 16px; font-size: 9px; color: #94a3b8; }
        .gold { color: #C8A951; }
    </style>
</head>
<body>

    <div class="header">
        <div class="uni-name">Université — Système de Vote Électronique</div>
        <h1>Bulletin de Vote</h1>
        <div class="subtitle">Document officiel — Confidentiel</div>
    </div>

    <div class="section-title">Élection</div>
    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Titre de l'élection</span>
            <span class="info-value">{{ $election->titre }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Période</span>
            <span class="info-value">{{ $election->date_debut->format('d/m/Y') }} → {{ $election->date_fin->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Statut</span>
            <span class="info-value">{{ ucfirst(str_replace('_', ' ', $election->statut)) }}</span>
        </div>
    </div>

    <div class="section-title">Votant</div>
    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Nom complet</span>
            <span class="info-value">{{ $vote->user->name }}</span>
        </div>
        @if($vote->user->numero_etudiant)
        <div class="info-row">
            <span class="info-label">N° Étudiant</span>
            <span class="info-value">{{ $vote->user->numero_etudiant }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="info-label">Date du vote</span>
            <span class="info-value">{{ $vote->voted_at ? $vote->voted_at->format('d/m/Y à H:i') : '—' }}</span>
        </div>
    </div>

    <div class="section-title">Candidat choisi</div>
    <div class="candidat-box">
        <div class="candidat-label">Votre choix</div>
        @if($vote->candidat)
            <div class="candidat-name">{{ $vote->candidat->prenom }} {{ $vote->candidat->nom }}</div>
        @else
            <div class="candidat-name" style="color:#94a3b8; font-style:italic;">Candidat non disponible</div>
        @endif
    </div>

    <div class="cachet-wrapper">
        <div class="cachet">
            <div class="cachet-check">✓</div>
            <div class="cachet-text">VOTE ENREGISTRÉ</div>
        </div>
    </div>

    <div class="hash-box">
        <div class="hash-label">Code de confirmation</div>
        <div class="hash-value">{{ strtoupper($hash) }}</div>
    </div>

    <div class="footer">
        Ce bulletin est généré automatiquement. Il atteste de votre participation mais ne révèle pas votre choix à des tiers.<br>
        <span class="gold">Système de Vote Universitaire</span> — Confidentiel
    </div>

</body>
</html>
