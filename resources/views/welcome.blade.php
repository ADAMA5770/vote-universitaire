<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vote Universitaire — L3 GL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f8f9fa; }
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d6efd 0%, #6f42c1 100%);
            display: flex;
            align-items: center;
        }
        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

<div class="hero text-white">
    <div class="container py-5">
        <div class="row align-items-center gy-5">

            {{-- Colonne gauche --}}
            <div class="col-lg-6">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <i class="bi bi-ballot-fill" style="font-size: 3rem;"></i>
                    <div>
                        <div class="fw-bold fs-5 opacity-75">Université — L3 Génie Logiciel</div>
                        <h1 class="display-5 fw-bold mb-0">Système de Vote <br>Universitaire</h1>
                    </div>
                </div>

                <p class="lead opacity-90 mb-4">
                    Participez aux élections de votre promotion en toute sécurité.
                    Chaque étudiant dispose d'un compte unique et d'une seule voix par élection.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="btn btn-light btn-lg fw-semibold px-4">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                    </a>
                    @auth
                        <a href="{{ route('elections.index') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-list-ul me-2"></i>Voir les élections
                        </a>
                    @endauth
                </div>

                @auth
                    <div class="mt-3 opacity-75 small">
                        <i class="bi bi-person-check me-1"></i>
                        Connecté en tant que <strong>{{ Auth::user()->name }}</strong>
                    </div>
                @endauth
            </div>

            {{-- Colonne droite — fonctionnalités --}}
            <div class="col-lg-5 offset-lg-1">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="card border-0 bg-white bg-opacity-15 text-white h-100">
                            <div class="card-body p-3">
                                <div class="feature-icon bg-white bg-opacity-25 mb-3">
                                    <i class="bi bi-shield-lock-fill"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Vote sécurisé</h6>
                                <p class="small opacity-75 mb-0">Un seul vote par étudiant, protégé contre les doubles soumissions.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card border-0 bg-white bg-opacity-15 text-white h-100">
                            <div class="card-body p-3">
                                <div class="feature-icon bg-white bg-opacity-25 mb-3">
                                    <i class="bi bi-bar-chart-fill"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Résultats en temps réel</h6>
                                <p class="small opacity-75 mb-0">Consultez les résultats dès votre vote enregistré.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card border-0 bg-white bg-opacity-15 text-white h-100">
                            <div class="card-body p-3">
                                <div class="feature-icon bg-white bg-opacity-25 mb-3">
                                    <i class="bi bi-person-badge-fill"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Comptes gérés</h6>
                                <p class="small opacity-75 mb-0">Les comptes sont créés par l'administrateur — pas d'inscription libre.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card border-0 bg-white bg-opacity-15 text-white h-100">
                            <div class="card-body p-3">
                                <div class="feature-icon bg-white bg-opacity-25 mb-3">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Dédié aux étudiants</h6>
                                <p class="small opacity-75 mb-0">Connectez-vous avec votre numéro étudiant ou votre email.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
