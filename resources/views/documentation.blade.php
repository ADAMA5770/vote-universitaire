<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Guide d'utilisation — Vote Universitaire</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #1a1a1a; background: #fff; }

        .cover { background: #1E3A5F; color: #fff; padding: 80px 60px; text-align: center; min-height: 100%; }
        .cover .uni { font-size: 12px; color: #C8A951; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 30px; }
        .cover h1 { font-size: 32px; font-weight: bold; margin-bottom: 12px; }
        .cover .sub { font-size: 14px; color: #b0bec5; margin-bottom: 50px; }
        .cover .version { font-size: 10px; color: #C8A951; letter-spacing: 2px; }
        .cover-divider { width: 60px; height: 3px; background: #C8A951; margin: 24px auto; }

        .page { padding: 50px 60px; page-break-before: always; }
        .page-title { font-size: 20px; color: #1E3A5F; font-weight: bold; border-bottom: 3px solid #C8A951; padding-bottom: 10px; margin-bottom: 24px; }

        h2 { font-size: 14px; color: #1E3A5F; font-weight: bold; margin: 20px 0 8px; }
        p, li { font-size: 11px; color: #444; line-height: 1.7; }
        ul { padding-left: 18px; margin-bottom: 12px; }
        li { margin-bottom: 4px; }

        .step-box { background: #f8f9fa; border-left: 4px solid #1E3A5F; border-radius: 0 6px 6px 0; padding: 12px 16px; margin-bottom: 10px; }
        .step-num { font-size: 10px; color: #C8A951; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .step-text { font-size: 11px; color: #1E3A5F; font-weight: bold; }

        .note { background: #fdf8ec; border: 1px solid #C8A951; border-radius: 6px; padding: 10px 14px; margin: 12px 0; font-size: 10px; color: #7a6320; }

        .admin-step-box { background: #f8f9fa; border-left: 4px solid #C8A951; border-radius: 0 6px 6px 0; padding: 12px 16px; margin-bottom: 10px; }

        .footer-page { text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e9ecef; padding-top: 14px; margin-top: 40px; }
        .gold { color: #C8A951; }
        .navy { color: #1E3A5F; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; font-size: 10px; }
        th { background: #1E3A5F; color: #fff; padding: 8px 10px; text-align: left; }
        td { border-bottom: 1px solid #e9ecef; padding: 7px 10px; color: #444; }
        tr:nth-child(even) td { background: #f8f9fa; }
    </style>
</head>
<body>

    {{-- PAGE DE COUVERTURE --}}
    <div class="cover">
        <div class="uni">Université — Système de Vote Électronique</div>
        <h1>Guide d'utilisation</h1>
        <div class="cover-divider"></div>
        <div class="sub">Plateforme de vote universitaire en ligne<br>Guide complet : étudiants & administrateurs</div>
        <div class="version">Version 2.0 — {{ date('Y') }}</div>
    </div>

    {{-- PAGE GUIDE ÉTUDIANT --}}
    <div class="page">
        <div class="page-title">Guide Étudiant</div>

        <h2>Connexion à la plateforme</h2>
        <div class="step-box">
            <div class="step-num">Étape 1</div>
            <div class="step-text">Accédez à la page de connexion</div>
        </div>
        <div class="step-box">
            <div class="step-num">Étape 2</div>
            <div class="step-text">Saisissez votre numéro étudiant ou votre email</div>
        </div>
        <div class="step-box">
            <div class="step-num">Étape 3</div>
            <div class="step-text">Entrez votre mot de passe et cliquez sur "Connexion"</div>
        </div>

        <div class="note">
            <strong>Note :</strong> Votre compte est créé par l'administration. Si vous n'avez pas de compte, contactez votre administrateur.
        </div>

        <h2>Participer à une élection</h2>
        <ul>
            <li>Cliquez sur <strong>Élections</strong> dans la barre de navigation</li>
            <li>Sélectionnez une élection active dans la liste</li>
            <li>Lisez les informations sur les candidats</li>
            <li>Sélectionnez votre candidat en cliquant sur sa carte</li>
            <li>Confirmez votre vote en cliquant sur <strong>"Confirmer mon vote"</strong></li>
        </ul>

        <div class="note">
            <strong>Important :</strong> Votre vote est définitif et confidentiel. Vous ne pouvez voter qu'une seule fois par élection.
        </div>

        <h2>Consulter les résultats</h2>
        <ul>
            <li>Après avoir voté, vous êtes automatiquement redirigé vers les résultats provisoires</li>
            <li>Une fois l'élection terminée, les résultats définitifs sont accessibles à tous</li>
            <li>Vous pouvez télécharger les résultats en PDF depuis la page des résultats</li>
        </ul>

        <h2>Mon historique de votes</h2>
        <ul>
            <li>Accédez à <strong>Mes votes</strong> via le menu déroulant en haut à droite</li>
            <li>Consultez toutes vos participations passées</li>
            <li>Téléchargez votre bulletin de vote pour chaque participation</li>
        </ul>

        <h2>Modifier mon mot de passe</h2>
        <div class="step-box">
            <div class="step-num">Étape 1</div>
            <div class="step-text">Cliquez sur votre nom en haut à droite → "Mon profil"</div>
        </div>
        <div class="step-box">
            <div class="step-num">Étape 2</div>
            <div class="step-text">Dans la section "Changer le mot de passe", remplissez les champs</div>
        </div>
        <div class="step-box">
            <div class="step-num">Étape 3</div>
            <div class="step-text">Cliquez sur "Mettre à jour"</div>
        </div>

        <div class="footer-page">
            <span class="gold">Vote Universitaire</span> — Guide d'utilisation — Confidentiel
        </div>
    </div>

    {{-- PAGE GUIDE ADMIN --}}
    <div class="page">
        <div class="page-title">Guide Administrateur</div>

        <h2>Tableau de bord</h2>
        <p>Le tableau de bord affiche les statistiques globales : nombre d'élections, votes, étudiants et candidats. Il affiche également le graphique des votes par élection et les dernières élections créées.</p>

        <h2>Gérer les élections</h2>
        <div class="admin-step-box">
            <div class="step-num">Créer une élection</div>
            <div class="step-text">Dashboard → "Nouvelle élection" → Remplir le formulaire → Enregistrer</div>
        </div>
        <div class="admin-step-box">
            <div class="step-num">Modifier une élection</div>
            <div class="step-text">Élections → icône crayon. Impossible si l'élection est active.</div>
        </div>
        <div class="admin-step-box">
            <div class="step-num">Supprimer une élection</div>
            <div class="step-text">Impossible si des votes ont été enregistrés.</div>
        </div>

        <h2>Statuts des élections</h2>
        <table>
            <tr>
                <th>Statut</th>
                <th>Description</th>
            </tr>
            <tr>
                <td><strong>En attente</strong></td>
                <td>Élection créée, pas encore ouverte aux votes</td>
            </tr>
            <tr>
                <td><strong>Active</strong></td>
                <td>Vote en cours — modification impossible</td>
            </tr>
            <tr>
                <td><strong>Terminée</strong></td>
                <td>Élection clôturée — résultats définitifs accessibles</td>
            </tr>
        </table>
        <p style="font-size:10px; color:#666;">Les statuts sont mis à jour automatiquement toutes les heures selon les dates de début et de fin.</p>

        <h2>Gérer les candidats</h2>
        <ul>
            <li>Allez dans <strong>Élections → Modifier</strong> pour une élection non active</li>
            <li>Remplissez le formulaire d'ajout de candidat (nom, prénom, programme, photo)</li>
            <li>Les photos acceptées : JPEG, PNG, WebP — max 2 Mo</li>
        </ul>

        <h2>Gérer les étudiants</h2>
        <ul>
            <li>Accédez à <strong>Étudiants</strong> dans la navigation</li>
            <li>Créez les comptes avec nom, numéro étudiant, email et mot de passe</li>
            <li>La suppression est définitive — les votes associés sont conservés</li>
        </ul>

        <h2>Mode maintenance</h2>
        <p>Depuis le tableau de bord, utilisez le toggle <strong>Mode maintenance</strong> pour bloquer temporairement l'accès des étudiants. Les administrateurs restent toujours accessibles.</p>

        <h2>Journal d'activité</h2>
        <p>Le journal enregistre toutes les actions importantes : connexions, votes, créations et suppressions. Accessible via <strong>Admin → Journal</strong>.</p>

        <div class="footer-page">
            <span class="gold">Vote Universitaire</span> — Guide Administrateur — Confidentiel
        </div>
    </div>

</body>
</html>
