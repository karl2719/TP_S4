<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { color: #2e7d32; border-bottom: 2px solid #2e7d32; }
        .section { margin: 16px 0; padding: 10px; border-left: 4px solid #2e7d32; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #e8f5e9; }
    </style>
</head>
<body>
    <h1>Mon plan alimentaire — Comme j'adore</h1>

    <div class="section">
        <h2>Mes informations</h2>
        <table>
            <tr><th>Nom</th><td><?= esc($user['prenom'] . ' ' . $user['nom']) ?></td></tr>
            <tr><th>Taille</th><td><?= esc($user['taille']) ?> cm</td></tr>
            <tr><th>Poids actuel</th><td><?= esc($user['poids']) ?> kg</td></tr>
            <tr><th>IMC</th><td><?= esc($imc) ?></td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Mon regime: <?= esc($ur['regime_nom']) ?></h2>
        <p><?= esc($ur['description']) ?></p>
        <table>
            <tr><th>% Viande</th><td><?= esc($ur['pct_viande']) ?>%</td></tr>
            <tr><th>% Poisson</th><td><?= esc($ur['pct_poisson']) ?>%</td></tr>
            <tr><th>% Volaille</th><td><?= esc($ur['pct_volaille']) ?>%</td></tr>
            <tr><th>Duree</th><td><?= esc($ur['duree_semaines']) ?> semaines</td></tr>
            <tr><th>Du</th><td><?= esc($ur['date_debut']) ?></td></tr>
            <tr><th>Au</th><td><?= esc($ur['date_fin']) ?></td></tr>
            <tr><th>Prix paye</th><td><?= number_format((float) $ur['prix_paye'], 2) ?> EUR</td></tr>
        </table>
    </div>

    <div class="section">
        <em>Mange ce que tu aimes, vis comme tu le mérites.</em><br>
        <em>Document genere le <?= date('d/m/Y H:i') ?></em>
    </div>
</body>
</html>
