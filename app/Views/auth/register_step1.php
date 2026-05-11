<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-content auth-page">
<div class="form-card" data-aos="fade-up">
    <h1>Inscription — Étape 1</h1>
    <form method="post" action="<?= base_url('register/step1') ?>">
        <?= csrf_field() ?>
        <div class="form-row" style="margin-bottom:1rem">
            <div>
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" value="<?= old('prenom') ?>" required>
            </div>
            <div>
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" value="<?= old('nom') ?>" required>
            </div>
        </div>
        <div style="margin-bottom:1rem">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
        </div>
        <div class="form-row" style="margin-bottom:1rem">
            <div>
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div>
                <label class="form-label">Confirmer</label>
                <input type="password" name="password_confirm" class="form-control" required>
            </div>
        </div>
        <div style="margin-bottom:1.5rem">
            <label class="form-label">Genre</label>
            <div style="display:flex;gap:1.5rem;margin-top:.3rem">
                <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer">
                    <input type="radio" name="genre" value="M" <?= old('genre') === 'M' ? 'checked' : '' ?> required> Homme
                </label>
                <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer">
                    <input type="radio" name="genre" value="F" <?= old('genre') === 'F' ? 'checked' : '' ?> required> Femme
                </label>
            </div>
        </div>
        <button type="submit" class="btn-primary-cja ripple" style="width:100%">Suivant →</button>
    </form>
    <div style="text-align:center;margin-top:1.2rem">
        <a href="<?= base_url('login') ?>" style="color:var(--text-muted);font-size:.85rem">Déjà inscrit ? Se connecter</a>
    </div>
</div>
</div>
<?= $this->endSection() ?>
