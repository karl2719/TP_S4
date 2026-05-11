<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Comme j'adore — Mange ce que tu aimes, vis comme tu le mérites.">
    <title><?= isset($title) ? esc($title) . " — Comme j'adore" : "Comme j'adore" ?></title>
    <link rel="stylesheet" href="<?= base_url('css/base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages.css') ?>">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
    <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet">
    <style>
        #nprogress .bar{background:var(--accent);height:3px}
        #nprogress .peg{box-shadow:0 0 10px var(--accent),0 0 5px var(--accent)}
        .swal2-popup{border-radius:16px !important;font-family:var(--font-body) !important}
    </style>
</head>
<body>
<?php $isLoggedIn = session()->get('user_id'); ?>
<?php $userData = $user ?? null; ?>

<!-- NAVBAR -->
<nav class="navbar-main <?= $isLoggedIn ? 'navbar-client' : '' ?>" id="navbar">
    <a class="nav-logo" href="<?= base_url('/') ?>">
        <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" width="36" height="36">
            <path d="M20 4 L20 28 M16 8 L20 4 L24 8" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M20 14 C26 10 32 14 30 22 C28 28 22 30 20 28" stroke="white" stroke-width="1.8" stroke-linecap="round" fill="none"/>
            <circle cx="20" cy="32" r="2" fill="white" opacity="0.6"/>
        </svg>
        <span>Comme j'adore</span>
    </a>

    <?php if ($isLoggedIn): ?>
    <ul class="nav-links">
        <li><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li><a href="<?= base_url('regimes') ?>">Régimes</a></li>
        <li><a href="<?= base_url('wallet') ?>">Wallet</a></li>
        <li><a href="<?= base_url('gold') ?>">Gold</a></li>
        <li><a href="<?= base_url('profil') ?>">Profil</a></li>
    </ul>
    <?php endif; ?>

    <div class="nav-right">
        <?php if ($isLoggedIn): ?>
            <span class="wallet-pill"><i class="fa-solid fa-wallet"></i> <span id="solde-nav"><?= $userData ? number_format((float) $userData['solde_wallet'], 2) : '0.00' ?> EUR</span></span>
            <?php if ($userData && (int) $userData['option_gold'] === 1): ?>
                <span class="gold-badge">⭐ GOLD</span>
            <?php endif; ?>
            <span class="avatar-circle"><?= $userData ? strtoupper(substr($userData['prenom'], 0, 1)) : 'U' ?></span>
            <a class="nav-logout" href="<?= base_url('logout') ?>"><i class="fa-solid fa-right-from-bracket"></i></a>
        <?php else: ?>
            <a class="btn-ghost" href="<?= base_url('login') ?>">Se connecter</a>
        <?php endif; ?>
        <button class="hamburger" id="hamburgerBtn" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<!-- MOBILE OVERLAY -->
<div class="mobile-overlay" id="mobileMenu">
    <button class="mobile-close" id="mobileClose">&times;</button>
    <?php if ($isLoggedIn): ?>
        <a href="<?= base_url('dashboard') ?>">Dashboard</a>
        <a href="<?= base_url('regimes') ?>">Régimes</a>
        <a href="<?= base_url('wallet') ?>">Wallet</a>
        <a href="<?= base_url('gold') ?>">Gold</a>
        <a href="<?= base_url('profil') ?>">Profil</a>
        <a href="<?= base_url('logout') ?>" style="color:var(--accent)">Déconnexion</a>
    <?php else: ?>
        <a href="<?= base_url('login') ?>">Se connecter</a>
        <a href="<?= base_url('register/step1') ?>">S'inscrire</a>
    <?php endif; ?>
</div>

<!-- MAIN CONTENT -->
<?= $this->renderSection('content') ?>

<!-- FOOTER -->
<footer class="footer-main">
    <div class="footer-inner">
        <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" width="32" height="32" style="margin:0 auto .5rem">
            <path d="M20 4 L20 28 M16 8 L20 4 L24 8" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M20 14 C26 10 32 14 30 22 C28 28 22 30 20 28" stroke="white" stroke-width="1.8" stroke-linecap="round" fill="none"/>
        </svg>
        <div style="font-family:var(--font-display);font-size:1.1rem">Comme j'adore</div>
        <div class="footer-tagline">Mange ce que tu aimes, vis comme tu le mérites.</div>
        <div class="footer-copy">© <?= date('Y') ?> Comme j'adore. Tous droits réservés.</div>
    </div>
</footer>

<!-- CDN Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.6.2/countUp.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
<script>
// AOS Init
AOS.init({ duration: 800, once: true, offset: 80 });

// NProgress on link clicks
document.querySelectorAll('a[href]:not([target]):not([href^="#"])').forEach(a => {
    a.addEventListener('click', () => NProgress.start());
});
window.addEventListener('load', () => NProgress.done());

// Navbar scroll
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 60);
});

// Mobile menu
const hamburger = document.getElementById('hamburgerBtn');
const mobileMenu = document.getElementById('mobileMenu');
const mobileClose = document.getElementById('mobileClose');
if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => mobileMenu.classList.add('open'));
    mobileClose.addEventListener('click', () => mobileMenu.classList.remove('open'));
}

// Lucide icons
if (window.lucide) lucide.createIcons();

// Ripple effect
document.querySelectorAll('.ripple').forEach(btn => {
    btn.addEventListener('click', function(e) {
        const rect = this.getBoundingClientRect();
        this.style.setProperty('--x', (e.clientX - rect.left) + 'px');
        this.style.setProperty('--y', (e.clientY - rect.top) + 'px');
    });
});
</script>

<?php
// Flash messages via Toastify
$flashSuccess = session()->getFlashdata('success');
$flashError = session()->getFlashdata('error');
$flashInfo = session()->getFlashdata('info');
$flashErrors = session()->getFlashdata('errors');
?>
<?php if ($flashSuccess): ?>
<script>
Toastify({text:"<?= esc($flashSuccess) ?>",duration:3500,gravity:"bottom",position:"right",style:{background:"linear-gradient(135deg,#2D6A4F,#52B788)",borderRadius:"12px",fontFamily:"'DM Sans',sans-serif"}}).showToast();
</script>
<?php endif; ?>
<?php if ($flashError): ?>
<script>
Toastify({text:"<?= esc($flashError) ?>",duration:4000,gravity:"bottom",position:"right",style:{background:"linear-gradient(135deg,#dc2626,#ef4444)",borderRadius:"12px",fontFamily:"'DM Sans',sans-serif"}}).showToast();
</script>
<?php endif; ?>
<?php if ($flashInfo): ?>
<script>
Toastify({text:"<?= esc($flashInfo) ?>",duration:3000,gravity:"bottom",position:"right",style:{background:"linear-gradient(135deg,#1B4332,#2D6A4F)",borderRadius:"12px",fontFamily:"'DM Sans',sans-serif"}}).showToast();
</script>
<?php endif; ?>
<?php if (!empty($flashErrors) && is_array($flashErrors)): ?>
<script>
<?php foreach ($flashErrors as $err): ?>
Toastify({text:"<?= esc($err) ?>",duration:4000,gravity:"bottom",position:"right",style:{background:"linear-gradient(135deg,#dc2626,#ef4444)",borderRadius:"12px",fontFamily:"'DM Sans',sans-serif"}}).showToast();
<?php endforeach; ?>
</script>
<?php endif; ?>

<?= $this->renderSection('scripts') ?>
</body>
</html>
