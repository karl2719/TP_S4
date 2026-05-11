<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="hero-landing" style="min-height:100vh">
    <div class="hero-grain"></div>
    <div class="hero-center">
        <svg viewBox="0 0 40 40" fill="none" width="48" height="48" style="margin:0 auto">
            <path d="M20 4 L20 28 M16 8 L20 4 L24 8" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M20 14 C26 10 32 14 30 22 C28 28 22 30 20 28" stroke="white" stroke-width="1.8" stroke-linecap="round" fill="none"/>
        </svg>
        <div style="font-family:var(--font-display);color:#fff;font-size:1.4rem;margin-top:.6rem">Administration</div>
        <div class="hero-login-card" style="margin-top:2rem">
            <h1>Login Admin</h1>
            <form method="post" action="<?= base_url('admin/login') ?>">
                <?= csrf_field() ?>
                <div class="float-field">
                    <input type="email" name="email" id="admin-email" placeholder=" " required>
                    <label for="admin-email">Email</label>
                </div>
                <div class="float-field">
                    <input type="password" name="password" id="admin-password" placeholder=" " required>
                    <label for="admin-password">Mot de passe</label>
                </div>
                <button type="submit" class="btn-accent-cja ripple" style="width:100%;padding:.85rem;font-size:1rem">Se connecter</button>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
