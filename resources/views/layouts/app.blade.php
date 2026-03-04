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
            --blue:   #2563EB;
            --violet: #7C3AED;
            --green:  #059669;
            --red:    #DC2626;
        }
        body { background: #f1f5f9; min-height: 100vh; display: flex; flex-direction: column; }
        main { flex: 1; }

        /* ── Navbar ── */
        .navbar-app {
            background: linear-gradient(135deg, #1e3a8a 0%, #5b21b6 100%);
            box-shadow: 0 2px 12px rgba(0,0,0,.25);
        }
        .navbar-app .navbar-brand {
            font-weight: 800;
            font-size: 1.15rem;
            letter-spacing: .3px;
            color: #fff !important;
        }
        .navbar-app .nav-link {
            color: rgba(255,255,255,.80) !important;
            font-weight: 500;
            padding: .5rem .9rem !important;
            border-radius: 8px;
            transition: background .2s, color .2s;
        }
        .navbar-app .nav-link:hover,
        .navbar-app .nav-link.active {
            background: rgba(255,255,255,.15);
            color: #fff !important;
        }
        .navbar-app .dropdown-menu {
            border: none;
            box-shadow: 0 8px 30px rgba(0,0,0,.15);
            border-radius: 12px;
        }

        /* ── Cards ── */
        .card {
            border: none;
            box-shadow: 0 1px 6px rgba(0,0,0,.07);
            border-radius: 12px;
        }
        .card-hover {
            transition: transform .2s, box-shadow .2s;
            cursor: pointer;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(37,99,235,.18);
        }

        /* ── Alerts flash ── */
        .alert-flash {
            border: none;
            border-radius: 10px;
            font-weight: 500;
        }

        /* ── Animations ── */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn .35s ease both; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-app">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <div style="background:rgba(255,255,255,.2); border-radius:8px; padding:4px 8px;">
                <i class="bi bi-ballot-fill" style="font-size:1.1rem;"></i>
            </div>
            Vote Universitaire
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto ms-3 gap-1">
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('elections.*') && !request()->routeIs('admin.*') ? 'active' : '' }}"
                           href="{{ route('elections.index') }}">
                            <i class="bi bi-list-check me-1"></i>Élections
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
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                           data-bs-toggle="dropdown">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                 style="width:32px;height:32px;background:rgba(255,255,255,.25);font-size:.8rem;flex-shrink:0;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                            @if(auth()->user()->isAdmin())
                                <span class="badge ms-1" style="background:#fbbf24; color:#1e1b4b; font-size:.65rem;">Admin</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li>
                                <span class="dropdown-item-text small text-muted">
                                    <i class="bi bi-envelope me-1"></i>{{ auth()->user()->email }}
                                </span>
                            </li>
                            @if(auth()->user()->numero_etudiant)
                                <li>
                                    <span class="dropdown-item-text small text-muted">
                                        <i class="bi bi-credit-card-2-front me-1"></i>{{ auth()->user()->numero_etudiant }}
                                    </span>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
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
        <div class="alert alert-success alert-flash alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-flash alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<footer class="text-center py-4 mt-auto" style="background:#fff; border-top:1px solid #e2e8f0;">
    <small class="text-muted">
        <i class="bi bi-mortarboard me-1 text-primary"></i>
        &copy; {{ date('Y') }} Vote Universitaire &mdash; L3 Génie Logiciel
    </small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
