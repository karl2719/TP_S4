<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php
$maxHeat = 0;
foreach ($tableau_croise as $row) { $maxHeat = max($maxHeat, (int) $row['total']); }
$heatClass = static function (int $value, int $max): string {
    if ($max === 0) return 'heat-0';
    $r = $value / $max;
    if ($r >= 0.8) return 'heat-4'; if ($r >= 0.6) return 'heat-3';
    if ($r >= 0.4) return 'heat-2'; if ($r >= 0.2) return 'heat-1';
    return 'heat-0';
};
?>

<div class="admin-header">
    <h1 class="admin-title">Dashboard</h1>
    <span class="admin-subtitle">Vue générale des performances</span>
</div>

<div class="admin-kpis">
    <div class="admin-kpi-card">
        <div class="kpi-icon">👥</div>
        <div class="kpi-label">Total utilisateurs</div>
        <div class="kpi-value"><?= (int) $stats['nb_users'] ?></div>
        <div class="kpi-trend">↗ Actif</div>
    </div>
    <div class="admin-kpi-card">
        <div class="kpi-icon">⭐</div>
        <div class="kpi-label">Utilisateurs Gold</div>
        <div class="kpi-value"><?= (int) $stats['nb_gold'] ?></div>
        <div class="kpi-trend">↗ Premium</div>
    </div>
    <div class="admin-kpi-card">
        <div class="kpi-icon">💶</div>
        <div class="kpi-label">Total ventes</div>
        <div class="kpi-value"><?= number_format((float) $stats['total_ventes'], 2) ?> €</div>
        <div class="kpi-trend">↗ Revenue</div>
    </div>
    <div class="admin-kpi-card">
        <div class="kpi-icon">🥗</div>
        <div class="kpi-label">Régimes actifs</div>
        <div class="kpi-value"><?= (int) $stats['nb_regimes'] ?></div>
        <div class="kpi-trend">↗ Programmes</div>
    </div>
</div>

<div class="admin-grid">
    <div class="admin-panel">
        <h2 class="admin-panel-title">Inscrits par mois</h2>
        <div id="chartInscrits"></div>
    </div>
    <div class="admin-panel">
        <h2 class="admin-panel-title">Répartition des objectifs</h2>
        <div id="chartObjectifs"></div>
    </div>
</div>

<div class="admin-grid">
    <div class="admin-panel">
        <h2 class="admin-panel-title">Top régimes</h2>
        <div id="chartTopRegimes"></div>
    </div>
    <div class="admin-panel">
        <h2 class="admin-panel-title">Tableau croisé</h2>
        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead><tr><th>Objectif</th><th>Catégorie IMC</th><th>Total</th></tr></thead>
                <tbody>
                    <?php foreach ($tableau_croise as $row): ?>
                    <tr>
                        <td><?= esc($row['objectif']) ?></td>
                        <td><?= esc($row['categorie_imc']) ?></td>
                        <td class="heat-cell <?= $heatClass((int) $row['total'], $maxHeat) ?>"><?= esc($row['total']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const chartTheme = {chart:{foreColor:'#94a3b8',toolbar:{show:false}},grid:{borderColor:'rgba(255,255,255,0.06)'},tooltip:{theme:'dark'}};

new ApexCharts(document.querySelector('#chartInscrits'), {
    ...chartTheme,
    chart:{...chartTheme.chart,type:'bar',height:280},
    series:[{name:'Inscrits',data:<?= json_encode(array_column($inscrits_mois,'total')) ?>}],
    xaxis:{categories:<?= json_encode(array_column($inscrits_mois,'mois')) ?>},
    colors:['#52B788'],
    plotOptions:{bar:{borderRadius:6,columnWidth:'50%'}}
}).render();

new ApexCharts(document.querySelector('#chartObjectifs'), {
    ...chartTheme,
    chart:{...chartTheme.chart,type:'donut',height:280},
    series:<?= json_encode(array_map('intval',array_column($objectifs_chart,'total'))) ?>,
    labels:<?= json_encode(array_column($objectifs_chart,'libelle')) ?>,
    colors:['#52B788','#F4A261','#D4AF37','#3B82F6']
}).render();

new ApexCharts(document.querySelector('#chartTopRegimes'), {
    ...chartTheme,
    chart:{...chartTheme.chart,type:'bar',height:280},
    series:[{name:'Ventes',data:<?= json_encode(array_column($top_regimes,'ventes')) ?>}],
    xaxis:{categories:<?= json_encode(array_column($top_regimes,'nom')) ?>},
    plotOptions:{bar:{horizontal:true,borderRadius:6,barHeight:'50%'}},
    colors:['#52B788']
}).render();
</script>
<?= $this->endSection() ?>
