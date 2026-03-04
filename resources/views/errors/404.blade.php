<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Page introuvable</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; display: flex; flex-direction: column; min-height: 100vh; }
        .error-icon { font-size: 6rem; color: #6c757d; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="text-center px-4">
        <div class="error-icon mb-3">
            <i class="bi bi-search"></i>
        </div>
        <h1 class="display-1 fw-bold text-secondary">404</h1>
        <h2 class="mb-3">Page introuvable</h2>
        <p class="text-muted mb-4 lead">
            La page que vous cherchez n'existe pas ou a été déplacée.<br>
            Vérifiez l'URL ou retournez à l'accueil.
        </p>
        <div class="d-flex gap-2 justify-content-center flex-wrap">
            @auth
                <a href="{{ route('elections.index') }}" class="btn btn-primary">
                    <i class="bi bi-ballot me-2"></i>Retour aux élections
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="bi bi-house me-2"></i>Accueil
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
