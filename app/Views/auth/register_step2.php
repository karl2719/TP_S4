<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-content auth-page">
<div class="form-card" data-aos="fade-up">
    <h1>Inscription — Étape 2</h1>
    <form method="post" action="<?= base_url('register/step2') ?>">
        <?= csrf_field() ?>
        <div class="form-row" style="margin-bottom:1rem">
            <div>
                <label class="form-label">Taille (cm)</label>
                <input type="number" step="0.01" name="taille" id="taille" class="form-control" value="<?= old('taille') ?>" required>
            </div>
            <div>
                <label class="form-label">Poids (kg)</label>
                <input type="number" step="0.01" name="poids" id="poids" class="form-control" value="<?= old('poids') ?>" required>
            </div>
        </div>
        <div style="margin-bottom:1.5rem">
            <label class="form-label">Objectif</label>
            <select class="form-control" name="objectif_id" required style="cursor:pointer">
                <option value="">Choisir...</option>
                <?php foreach ($objectifs as $obj): ?>
                    <option value="<?= esc($obj['id']) ?>" <?= old('objectif_id') == $obj['id'] ? 'selected' : '' ?>><?= esc($obj['libelle']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="padding:1rem;background:rgba(82,183,136,.06);border-radius:10px;margin-bottom:1.5rem;text-align:center">
            IMC estimé: <strong id="imc-preview" style="color:var(--primary);font-size:1.2rem">—</strong>
        </div>
        <button type="submit" class="btn-primary-cja ripple" style="width:100%">Créer mon compte</button>
    </form>
</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function calculerIMC() {
    const t = parseFloat(document.getElementById('taille').value) / 100;
    const p = parseFloat(document.getElementById('poids').value);
    if (t > 0 && p > 0) document.getElementById('imc-preview').textContent = (p / (t * t)).toFixed(1);
}
document.getElementById('taille')?.addEventListener('input', calculerIMC);
document.getElementById('poids')?.addEventListener('input', calculerIMC);
</script>
<?= $this->endSection() ?>
