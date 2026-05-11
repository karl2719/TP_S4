<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h1 class="admin-title" style="margin-bottom:1.5rem">Créer un code</h1>
<form method="post" action="<?= base_url('admin/codes/store') ?>" class="admin-form" style="max-width:500px">
    <?= csrf_field() ?>
    <div style="margin-bottom:1rem"><label class="form-label">Code</label><input type="text" name="code" class="form-control" style="font-family:var(--font-mono);text-transform:uppercase" required></div>
    <div style="margin-bottom:1rem"><label class="form-label">Montant (EUR)</label><input type="number" name="montant" class="form-control" step="0.01" required></div>
    <div style="margin-bottom:1.5rem"><label class="form-label">Actif</label><select name="actif" class="form-select" required><option value="1" selected>Oui</option><option value="0">Non</option></select></div>
    <div style="display:flex;gap:1rem">
        <button type="submit" class="btn-primary-cja">Créer</button>
        <a href="<?= base_url('admin/codes') ?>" class="btn-ghost" style="color:rgba(226,232,240,.6);border-color:rgba(255,255,255,.1)">Annuler</a>
    </div>
</form>
<?= $this->endSection() ?>
