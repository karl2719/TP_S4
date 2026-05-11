<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
$todayLabel = $formatter->format(new DateTime());
$imcStatus = 'normal';
if ($imc >= 30) { $imcStatus = 'obesite'; }
elseif ($imc >= 25) { $imcStatus = 'surpoids'; }
$dureeLabel = $duree_estimee_semaines ? number_format($duree_estimee_semaines, 1) . ' semaines' : 'Non calculée';
$imcPercent = min(max(($imc - 10) / 30, 0), 1);
$imcColor = $imcStatus === 'normal' ? '#52B788' : ($imcStatus === 'surpoids' ? '#F59E0B' : '#EF4444');
?>

<!-- Greeting Banner -->
<div class="greeting-banner" data-aos="fade-down">
    <div class="container-cja">
        <h1>Bonjour, <?= esc($user['prenom']) ?> 👋</h1>
        <div class="greeting-date"><?= esc($todayLabel) ?></div>
    </div>
    <svg class="wave-svg" viewBox="0 0 1440 80" preserveAspectRatio="none">
        <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z"></path>
    </svg>
</div>

<div class="page-content" style="padding-top:0">
<div class="container-cja" style="margin-top:-1rem">
    <!-- IMC + Stats Row -->
    <div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;margin-bottom:2rem" data-aos="fade-up">
        <!-- IMC Widget -->
        <div class="card-elevated" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem">
            <div class="imc-arc-container">
                <svg viewBox="0 0 200 110">
                    <path d="M20,100 A80,80 0 0,1 180,100" fill="none" stroke="rgba(0,0,0,.08)" stroke-width="14" stroke-linecap="round"/>
                    <path d="M20,100 A80,80 0 0,1 180,100" fill="none" stroke="<?= $imcColor ?>" stroke-width="14" stroke-linecap="round"
                          stroke-dasharray="<?= round($imcPercent * 251, 1) ?> 251" id="imc-arc"/>
                </svg>
            </div>
            <div class="imc-number" id="imc-value" data-target="<?= esc($imc) ?>">0</div>
            <span class="imc-interpret imc-<?= $imcStatus ?>"><?= esc($interpretation) ?></span>
            <div style="color:var(--text-muted);font-size:.8rem;margin-top:.5rem">Poids idéal: <?= number_format((float) $poids_ideal, 1) ?> kg</div>
        </div>

        <!-- Stat Cards -->
        <div>
            <div class="stat-card-grid" style="margin-bottom:1rem">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon"><i data-lucide="target" style="color:var(--primary-light)"></i></div>
                    <div class="stat-label">Objectif</div>
                    <div class="stat-value"><?= esc($objectif['libelle']) ?></div>
                </div>
                <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon"><i data-lucide="wallet" style="color:var(--accent)"></i></div>
                    <div class="stat-label">Solde wallet</div>
                    <div class="stat-value" id="stat-solde" data-target="<?= (float) $user['solde_wallet'] ?>">0 EUR</div>
                </div>
                <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon"><i data-lucide="clock" style="color:var(--gold)"></i></div>
                    <div class="stat-label">Durée estimée</div>
                    <div class="stat-value"><?= esc($dureeLabel) ?></div>
                </div>
            </div>
            <div class="card-elevated" style="background:rgba(244,162,97,.08);border-left:4px solid var(--accent)" data-aos="fade-up" data-aos-delay="400">
                <div style="font-size:.8rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em">Delta poids</div>
                <div style="font-weight:700;font-size:1.3rem;margin-top:.2rem"><?= number_format((float) $delta_poids, 1) ?> kg</div>
            </div>
        </div>
    </div>

    <!-- Active Regimes -->
    <div data-aos="fade-up">
        <h2 style="font-family:var(--font-display);font-size:1.4rem;margin-bottom:1rem">Mes régimes actifs</h2>
        <?php if (empty($regimes_actifs)): ?>
            <div style="color:var(--text-muted);padding:2rem;text-align:center">Aucun régime actif pour le moment.</div>
        <?php else: ?>
            <div class="regimes-scroll">
                <div class="regimes-horiz">
                    <?php foreach ($regimes_actifs as $regime):
                        $dateDebut = new DateTime($regime['date_debut']);
                        $dateFin = new DateTime($regime['date_fin']);
                        $today = new DateTime();
                        $totalDays = max(1, (int) $dateDebut->diff($dateFin)->format('%a'));
                        $capDate = ($today < $dateFin) ? $today : $dateFin;
                        $elapsedDays = (int) $dateDebut->diff($capDate)->format('%a');
                        $progress = min(100, round(($elapsedDays / $totalDays) * 100));
                    ?>
                    <div class="regime-active-card" data-aos="fade-up">
                        <div class="regime-title"><?= esc($regime['regime_nom']) ?></div>
                        <div class="regime-dates">Fin: <?= esc($regime['date_fin']) ?></div>
                        <div class="regime-progress-bar">
                            <div class="regime-progress-fill" style="width:<?= $progress ?>%"></div>
                        </div>
                        <div class="regime-meta"><?= $elapsedDays ?> / <?= $totalDays ?> jours</div>
                        <a class="btn-pdf" href="<?= base_url('export/pdf/' . $regime['id']) ?>" title="Télécharger PDF">
                            <i data-lucide="file-text" style="width:14px;height:14px"></i> PDF
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>

<style>
@media(max-width:768px){
    [style*="grid-template-columns:1fr 2fr"]{grid-template-columns:1fr !important}
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// IMC CountUp
if (window.countUp) {
    const imcEl = document.getElementById('imc-value');
    if (imcEl) {
        const target = parseFloat(imcEl.dataset.target || '0');
        new countUp.CountUp(imcEl, target, {decimalPlaces:1, duration:2}).start();
    }
    const soldeEl = document.getElementById('stat-solde');
    if (soldeEl) {
        const target = parseFloat(soldeEl.dataset.target || '0');
        new countUp.CountUp(soldeEl, target, {decimalPlaces:2, duration:1.5, suffix:' EUR'}).start();
    }
}
if (window.lucide) lucide.createIcons();
</script>
<?= $this->endSection() ?>
