<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Système de Vote Universitaire — L3 GL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --navy:  #1E3A5F;
            --gold:  #C8A951;
            --green: #2D6A4F;
            --red:   #C1121F;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #F8F9FA; font-family: 'Segoe UI', system-ui, sans-serif; color: #212529; }

        /* ── Hero ── */
        .hero {
            min-height: 100vh;
            background-color: var(--navy);
            /* Texture subtile : lignes diagonales légères */
            background-image:
                repeating-linear-gradient(
                    -45deg,
                    rgba(255,255,255,.025) 0px,
                    rgba(255,255,255,.025) 1px,
                    transparent 1px,
                    transparent 40px
                );
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar du hero ── */
        .hero-nav {
            padding: 1.25rem 0;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .hero-nav .brand {
            color: #fff;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: .3px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .hero-nav .brand-icon {
            background: var(--gold);
            color: var(--navy);
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        /* ── Hero content ── */
        .hero-content {
            flex: 1;
            display: flex;
            align-items: center;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(200,169,81,.2);
            color: var(--gold);
            border: 1px solid rgba(200,169,81,.35);
            border-radius: 50px;
            padding: .3rem 1rem;
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }
        .hero-title {
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 1.25rem;
        }
        .hero-title span { color: var(--gold); }
        .hero-desc {
            color: rgba(255,255,255,.72);
            font-size: 1.05rem;
            line-height: 1.7;
            margin-bottom: 2rem;
            max-width: 480px;
        }
        .btn-gold {
            background: var(--gold);
            color: var(--navy);
            border: none;
            font-weight: 700;
            padding: .75rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            transition: opacity .2s, transform .2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }
        .btn-gold:hover { opacity: .9; transform: translateY(-1px); color: var(--navy); }
        .btn-outline-white {
            background: transparent;
            color: #fff;
            border: 1.5px solid rgba(255,255,255,.4);
            font-weight: 600;
            padding: .73rem 1.75rem;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color .2s, background .2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }
        .btn-outline-white:hover { border-color: rgba(255,255,255,.8); background: rgba(255,255,255,.08); color: #fff; }

        /* ── Feature cards ── */
        .feature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .feature-card {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 12px;
            padding: 1.25rem;
            transition: background .2s;
        }
        .feature-card:hover { background: rgba(255,255,255,.10); }
        .feature-emoji {
            font-size: 1.8rem;
            margin-bottom: .6rem;
            display: block;
        }
        .feature-card h6 {
            color: #fff;
            font-weight: 700;
            margin-bottom: .35rem;
            font-size: .95rem;
        }
        .feature-card p {
            color: rgba(255,255,255,.6);
            font-size: .82rem;
            line-height: 1.55;
            margin: 0;
        }

        /* ── Divider ── */
        .hero-divider {
            width: 48px; height: 3px;
            background: var(--gold);
            border-radius: 2px;
            margin-bottom: 1.25rem;
        }

        /* ── Stats bar ── */
        .stats-bar {
            background: rgba(0,0,0,.25);
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 1.25rem 0;
        }
        .stat-item { text-align: center; }
        .stat-num  { font-size: 1.5rem; font-weight: 800; color: var(--gold); line-height: 1; }
        .stat-lbl  { font-size: .75rem; color: rgba(255,255,255,.55); margin-top: .2rem; text-transform: uppercase; letter-spacing: .5px; }

        /* ── Footer ── */
        .hero-footer {
            background: rgba(0,0,0,.3);
            border-top: 1px solid rgba(255,255,255,.06);
            padding: 1rem 0;
            text-align: center;
            color: rgba(255,255,255,.4);
            font-size: .8rem;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-1 { animation: fadeUp .5s ease both; }
        .anim-2 { animation: fadeUp .5s .1s ease both; }
        .anim-3 { animation: fadeUp .5s .2s ease both; }

        @media (max-width: 576px) {
            .feature-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="hero">

    {{-- Navbar ─────────────────────────────────── --}}
    <nav class="hero-nav">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="#" class="brand">
                <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
                Vote Universitaire
            </a>
            <div>
                @auth
                    <a href="{{ route('elections.index') }}" class="btn-outline-white" style="font-size:.9rem; padding:.5rem 1.25rem;">
                        <i class="bi bi-list-check"></i> Mes élections
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-gold" style="padding:.55rem 1.5rem; font-size:.9rem;">
                        <i class="bi bi-box-arrow-in-right"></i> Connexion
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero content ─────────────────────────── --}}
    <div class="hero-content">
        <div class="container py-5">
            <div class="row align-items-center gy-5">

                {{-- Gauche : titre + CTA ── --}}
                <div class="col-lg-6 anim-1">
                    <div class="hero-badge">
                        <i class="bi bi-mortarboard me-1"></i>
                        Université — L3 Génie Logiciel
                    </div>
                    <div class="hero-divider"></div>
                    <h1 class="hero-title">
                        Système de<br><span>Vote Universitaire</span>
                    </h1>
                    <p class="hero-desc">
                        Participez aux élections de votre promotion de façon
                        sécurisée et transparente. Un compte, une voix, des
                        résultats en temps réel.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="btn-gold">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Se connecter
                        </a>
                        @auth
                            <a href="{{ route('elections.index') }}" class="btn-outline-white">
                                <i class="bi bi-ballot"></i> Voir les élections
                            </a>
                        @endauth
                    </div>

                    @auth
                        <div class="mt-3" style="color:rgba(255,255,255,.55); font-size:.85rem;">
                            <i class="bi bi-check-circle-fill me-1" style="color:var(--gold);"></i>
                            Connecté en tant que <strong style="color:#fff;">{{ Auth::user()->name }}</strong>
                        </div>
                    @endauth
                </div>

                {{-- Droite : 4 feature cards ── --}}
                <div class="col-lg-5 offset-lg-1 anim-2">
                    <div class="feature-grid">
                        <div class="feature-card">
                            <span class="feature-emoji">🗳️</span>
                            <h6>Vote sécurisé</h6>
                            <p>Un seul vote par étudiant, protégé contre toute double soumission.</p>
                        </div>
                        <div class="feature-card">
                            <span class="feature-emoji">👤</span>
                            <h6>1 étudiant = 1 voix</h6>
                            <p>Chaque compte est unique et lié à un numéro étudiant vérifié.</p>
                        </div>
                        <div class="feature-card">
                            <span class="feature-emoji">📊</span>
                            <h6>Résultats en temps réel</h6>
                            <p>Consultez les résultats provisoires dès votre vote enregistré.</p>
                        </div>
                        <div class="feature-card">
                            <span class="feature-emoji">🔒</span>
                            <h6>Accès contrôlé</h6>
                            <p>Les comptes sont créés par l'administrateur — pas d'inscription libre.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Stats bar ────────────────────────────── --}}
    <div class="stats-bar anim-3">
        <div class="container">
            <div class="row g-3 text-center">
                <div class="col-4 stat-item">
                    <div class="stat-num">100%</div>
                    <div class="stat-lbl">Sécurisé</div>
                </div>
                <div class="col-4 stat-item">
                    <div class="stat-num">1 vote</div>
                    <div class="stat-lbl">Par étudiant</div>
                </div>
                <div class="col-4 stat-item">
                    <div class="stat-num">PDF</div>
                    <div class="stat-lbl">Export résultats</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer ───────────────────────────────── --}}
    <div class="hero-footer">
        <div class="container">
            <i class="bi bi-mortarboard me-1"></i>
            Université — Département Génie Logiciel &nbsp;·&nbsp; &copy; {{ date('Y') }}
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
