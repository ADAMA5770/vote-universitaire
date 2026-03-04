<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Accès interdit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; display: flex; flex-direction: column; min-height: 100vh; }
        .error-icon { font-size: 6rem; color: #dc3545; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="text-center px-4">
        <div class="error-icon mb-3">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <h1 class="display-1 fw-bold text-danger">403</h1>
        <h2 class="mb-3">Accès interdit</h2>
        <p class="text-muted mb-4 lead">
            Vous n'avez pas les permissions nécessaires pour accéder à cette page.<br>
            Cette zone est réservée aux administrateurs.
        </p>
        <div class="d-flex gap-2 justify-content-center flex-wrap">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                        <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
                    </a>
                @else
                    <a href="{{ route('elections.index') }}" class="btn btn-primary">
                        <i class="bi bi-ballot me-2"></i>Retour aux élections
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                </a>
            @endauth
            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Page précédente
            </a>
        </div>
        <p class="text-muted small mt-4">
            <i class="bi bi-mortarboard me-1"></i>Vote Universitaire &mdash; L3 GL
        </p>
    </div>
</body>
</html>
