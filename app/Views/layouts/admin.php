<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? esc($title) : "Admin — Comme j'adore" ?></title>
    <link rel="stylesheet" href="<?= base_url('css/base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages.css') ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>#nprogress .bar{background:var(--primary-light);height:3px}</style>
</head>
<body class="admin-body">
<?php
$currentPath = service('request')->getUri()->getPath();
$isActive = static function (string $path) use ($currentPath): bool {
    return $currentPath === trim($path, '/') || str_starts_with($currentPath, trim($path, '/') . '/');
};
?>
<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <svg viewBox="0 0 40 40" fill="none" width="24" height="24">
                <path d="M20 4 L20 28 M16 8 L20 4 L24 8" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20 14 C26 10 32 14 30 22 C28 28 22 30 20 28" stroke="white" stroke-width="1.8" stroke-linecap="round" fill="none"/>
            </svg>
            <span class="admin-label">Comme j'adore</span>
        </div>
        <nav class="admin-nav">
            <a class="admin-link <?= $isActive('admin/dashboard') ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
                <span class="admin-icon"><i class="fa-solid fa-chart-line"></i></span>
                <span class="admin-label">Dashboard</span>
            </a>
            <a class="admin-link <?= $isActive('admin/regimes') ? 'active' : '' ?>" href="<?= base_url('admin/regimes') ?>">
                <span class="admin-icon"><i class="fa-solid fa-utensils"></i></span>
                <span class="admin-label">Régimes</span>
            </a>
            <a class="admin-link <?= $isActive('admin/activites') ? 'active' : '' ?>" href="<?= base_url('admin/activites') ?>">
                <span class="admin-icon"><i class="fa-solid fa-person-running"></i></span>
                <span class="admin-label">Activités</span>
            </a>
            <a class="admin-link <?= $isActive('admin/codes') ? 'active' : '' ?>" href="<?= base_url('admin/codes') ?>">
                <span class="admin-icon"><i class="fa-solid fa-ticket"></i></span>
                <span class="admin-label">Codes</span>
            </a>
            <a class="admin-link <?= $isActive('admin/params') ? 'active' : '' ?>" href="<?= base_url('admin/params') ?>">
                <span class="admin-icon"><i class="fa-solid fa-gear"></i></span>
                <span class="admin-label">Paramètres</span>
            </a>
            <a class="admin-link" href="<?= base_url('admin/logout') ?>" style="margin-top:auto">
                <span class="admin-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                <span class="admin-label">Déconnexion</span>
            </a>
        </nav>
    </aside>
    <main class="admin-content">
        <?php if (session()->getFlashdata('success')): ?>
        <div class="admin-alert success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="admin-alert error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?= $this->renderSection('content') ?>
        <footer class="admin-footer">Mange ce que tu aimes, vis comme tu le mérites.</footer>
    </main>
</div>

<nav class="admin-bottom-nav">
    <a class="admin-bottom-link <?= $isActive('admin/dashboard') ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>"><i class="fa-solid fa-chart-line"></i></a>
    <a class="admin-bottom-link <?= $isActive('admin/regimes') ? 'active' : '' ?>" href="<?= base_url('admin/regimes') ?>"><i class="fa-solid fa-utensils"></i></a>
    <a class="admin-bottom-link <?= $isActive('admin/activites') ? 'active' : '' ?>" href="<?= base_url('admin/activites') ?>"><i class="fa-solid fa-person-running"></i></a>
    <a class="admin-bottom-link <?= $isActive('admin/codes') ? 'active' : '' ?>" href="<?= base_url('admin/codes') ?>"><i class="fa-solid fa-ticket"></i></a>
    <a class="admin-bottom-link <?= $isActive('admin/params') ? 'active' : '' ?>" href="<?= base_url('admin/params') ?>"><i class="fa-solid fa-gear"></i></a>
</nav>
<?= $this->renderSection('scripts') ?>
</body>
</html>
