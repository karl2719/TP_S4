<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-content auth-page">
<div class="form-card" data-aos="fade-up">
    <h1>Mon profil</h1>
    <form method="post" action="<?= base_url('profil/update') ?>">
        <?= csrf_field() ?>
        <div class="form-row" style="margin-bottom:1rem">
            <div>
                <label class="form-label">Taille (cm)</label>
                <input type="number" step="0.01" name="taille" class="form-control" value="<?= esc($user['taille']) ?>" required>
            </div>
            <div>
                <label class="form-label">Poids (kg)</label>
                <input type="number" step="0.01" name="poids" class="form-control" value="<?= esc($user['poids']) ?>" required>
            </div>
        </div>
        <div style="margin-bottom:1.5rem">
            <label class="form-label">Objectif</label>
            <select class="form-control" name="objectif_id" required style="cursor:pointer">
                <?php foreach ($objectifs as $obj): ?>
                    <option value="<?= esc($obj['id']) ?>" <?= (int) $user['objectif_id'] === (int) $obj['id'] ? 'selected' : '' ?>><?= esc($obj['libelle']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn-primary-cja ripple" style="width:100%">Mettre à jour</button>
    </form>
</div>
</div>
<?= $this->endSection() ?>
