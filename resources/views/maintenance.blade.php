<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance — Vote Universitaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --navy:#1E3A5F; --gold:#C8A951; }
        body { background:#f8f9fa; min-height:100vh; display:flex; align-items:center; justify-content:center; }
    </style>
</head>
<body>
    <div class="text-center px-3">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4"
             style="width:90px;height:90px;background:var(--navy);">
            <i class="bi bi-tools text-white" style="font-size:2.2rem;"></i>
        </div>
        <h1 class="fw-bold mb-2" style="color:var(--navy); font-size:2rem;">Maintenance en cours</h1>
        <p class="text-muted mb-4" style="max-width:420px; margin:0 auto;">
            La plateforme est temporairement indisponible pour maintenance.<br>
            Merci de réessayer dans quelques instants.
        </p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="bi bi-house me-2"></i>Accueil
            </a>
            <a href="{{ route('login') }}" class="btn" style="background:var(--navy); color:#fff;">
                <i class="bi bi-shield-lock me-2"></i>Connexion admin
            </a>
        </div>
    </div>
</body>
</html>
