<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="hero-landing">
    <div class="hero-grain"></div>

    <!-- Floating food particles -->
    <div class="food-particles">
        <?php
        $emojis = ['🥗', '🐟', '🥩', '🫒', '🍋', '🥑', '🍊', '🌿'];
        for ($i = 0; $i < 12; $i++):
            $emoji = $emojis[$i % count($emojis)];
            $left = rand(5, 95);
            $delay = rand(0, 80) / 10;
            $duration = rand(80, 140) / 10;
            $size = rand(12, 22) / 10;
        ?>
        <span class="food-particle" style="left:<?= $left ?>%;animation-delay:<?= $delay ?>s;animation-duration:<?= $duration ?>s;font-size:<?= $size ?>rem"><?= $emoji ?></span>
        <?php endfor; ?>
    </div>

    <div class="hero-center">
        <!-- Logo -->
        <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" width="56" height="56" style="margin:0 auto" data-aos="fade-down">
            <path d="M20 4 L20 28 M16 8 L20 4 L24 8" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M20 14 C26 10 32 14 30 22 C28 28 22 30 20 28" stroke="white" stroke-width="1.8" stroke-linecap="round" fill="none"/>
            <circle cx="20" cy="32" r="2" fill="white" opacity="0.6"/>
        </svg>
        <div style="font-family:var(--font-display);color:#fff;font-size:1.6rem;margin-top:.8rem" data-aos="fade-up">Comme j'adore</div>
        <div class="hero-tagline" data-aos="fade-up" data-aos-delay="100">Mange ce que tu aimes, vis comme tu le mérites.</div>

        <!-- Login Card -->
        <div class="hero-login-card" data-aos="fade-up" data-aos-delay="200">
            <h1>Connexion</h1>
            <form method="post" action="<?= base_url('login') ?>">
                <?= csrf_field() ?>
                <div class="float-field">
                    <input type="email" name="email" id="login-email" placeholder=" " required>
                    <label for="login-email">Email</label>
                </div>
                <div class="float-field">
                    <input type="password" name="password" id="login-password" placeholder=" " required>
                    <label for="login-password">Mot de passe</label>
                </div>
                <button type="submit" class="btn-accent-cja ripple" style="width:100%;padding:.85rem;font-size:1rem;margin-top:.5rem">
                    Se connecter
                </button>
            </form>
            <a href="<?= base_url('register/step1') ?>" class="link-register">Pas encore inscrit ? Créer un compte →</a>
            <div style="margin-top:1.5rem;padding-top:1.2rem;border-top:1px solid rgba(255,255,255,.08);text-align:center">
                <a href="<?= base_url('admin') ?>" style="display:inline-flex;align-items:center;gap:.5rem;padding:.55rem 1.2rem;border:1px solid rgba(255,255,255,.12);border-radius:var(--radius-pill);color:rgba(255,255,255,.4);font-size:.8rem;transition:all .3s">
                    <i class="fa-solid fa-shield-halved"></i> Accès Administration
                </a>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
