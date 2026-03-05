<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vote Universitaire')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --navy:  #1E3A5F;
            --gold:  #C8A951;
            --green: #2D6A4F;
            --red:   #C1121F;
            --bg:    #F8F9FA;
            --text:  #212529;
        }

        body {
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        main { flex: 1; }

        /* ── Navbar ── */
        .navbar-app {
            background: var(--navy);
            box-shadow: 0 2px 10px rgba(0,0,0,.2);
            padding: .7rem 0;
        }
        .navbar-app .navbar-brand {
            color: #fff !important;
            font-weight: 800;
            font-size: 1.05rem;
            letter-spacing: .2px;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .navbar-app .brand-icon {
            width: 34px; height: 34px;
            background: var(--gold);
            color: var(--navy);
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .navbar-app .nav-link {
            color: rgba(255,255,255,.78) !important;
            font-weight: 500;
            padding: .45rem .85rem !important;
            border-radius: 6px;
            transition: color .2s;
            position: relative;
        }
        .navbar-app .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0; left: .85rem; right: .85rem;
            height: 2px;
            background: var(--gold);
            border-radius: 2px;
            transform: scaleX(0);
            transition: transform .2s ease;
        }
        .navbar-app .nav-link:hover { color: #fff !important; }
        .navbar-app .nav-link:hover::after,
        .navbar-app .nav-link.active::after { transform: scaleX(1); }
        .navbar-app .nav-link.active { color: #fff !important; }

        .navbar-app .dropdown-menu {
            border: none;
            border-top: 3px solid var(--gold);
            box-shadow: 0 8px 30px rgba(0,0,0,.12);
            border-radius: 0 0 10px 10px;
        }
        .badge-admin {
            background: var(--gold);
            color: var(--navy);
            font-size: .62rem;
            font-weight: 700;
            padding: .25em .6em;
            border-radius: 4px;
            letter-spacing: .3px;
        }

        /* ── Cards ── */
        .card {
            border: none;
            box-shadow: 0 1px 6px rgba(0,0,0,.07);
            border-radius: 10px;
        }
        .card-hover { transition: transform .2s, box-shadow .2s; }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(30,58,95,.15);
        }

        /* ── Buttons ── */
        .btn-navy {
            background: var(--navy);
            color: #fff;
            border: none;
            font-weight: 600;
            transition: opacity .2s;
        }
        .btn-navy:hover { opacity: .88; color: #fff; }
        .btn-gold-solid {
            background: var(--gold);
            color: var(--navy);
            border: none;
            font-weight: 700;
            transition: opacity .2s;
        }
        .btn-gold-solid:hover { opacity: .88; color: var(--navy); }

        /* ── Alerts ── */
        .alert { border: none; border-radius: 8px; border-left: 4px solid; }
        .alert-success { border-color: var(--green); }
        .alert-danger  { border-color: var(--red); }

        /* ── Fade-in ── */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn .3s ease both; }

        /* ── Avatar initiale ── */
        .avatar-initial {
            width: 34px; height: 34px;
            background: rgba(255,255,255,.2);
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .82rem; color: #fff;
            flex-shrink: 0;
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-app">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
            Vote Universitaire
        </a>
        <button class="navbar-toggler border-0 text-white" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="bi bi-list fs-4"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto ms-3 gap-1">
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('elections.*') && !request()->routeIs('admin.*') ? 'active' : '' }}"
                           href="{{ route('elections.index') }}">
                            <i class="bi bi-ballot me-1"></i>Élections
                        </a>
                    </li>
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Administration
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                           data-bs-toggle="dropdown">
                            <div class="avatar-initial">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-sm-inline" style="color:rgba(255,255,255,.85);">
                                {{ auth()->user()->name }}
                            </span>
                            @if(auth()->user()->isAdmin())
                                <span class="badge-admin">ADMIN</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text small text-muted py-1">
                                    <i class="bi bi-envelope me-1" style="color:var(--gold);"></i>
                                    {{ auth()->user()->email }}
                                </span>
                            </li>
                            @if(auth()->user()->numero_etudiant)
                                <li>
                                    <span class="dropdown-item-text small text-muted py-1">
                                        <i class="bi bi-credit-card-2-front me-1" style="color:var(--gold);"></i>
                                        {{ auth()->user()->numero_etudiant }}
                                    </span>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-semibold">
                                        <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4 fade-in">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5" style="color:var(--green);"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5" style="color:var(--red);"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<footer class="text-center py-3 mt-auto" style="background:#fff; border-top: 3px solid var(--gold);">
    <small class="text-muted">
        <i class="bi bi-mortarboard me-1" style="color:var(--navy);"></i>
        &copy; {{ date('Y') }} Vote Universitaire — Département Génie Logiciel
    </small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
