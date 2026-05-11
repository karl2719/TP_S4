<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h1 class="admin-title" style="margin-bottom:1.5rem">Créer une activité</h1>
<form method="post" action="<?= base_url('admin/activites/store') ?>" class="admin-form">
    <?= csrf_field() ?>
    <div style="margin-bottom:1rem"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required></div>
    <div style="margin-bottom:1rem"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"></textarea></div>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;margin-bottom:1rem">
        <div><label class="form-label">Calories / heure</label><input type="number" name="calories_heure" class="form-control" required></div>
        <div><label class="form-label">Intensité</label><select name="intensite" class="form-select" required><option value="faible">Faible</option><option value="moderate" selected>Modérée</option><option value="intense">Intense</option></select></div>
        <div><label class="form-label">Actif</label><select name="actif" class="form-select" required><option value="1" selected>Oui</option><option value="0">Non</option></select></div>
    </div>
    <div style="margin-bottom:1.5rem"><label class="form-label">Objectif (optionnel)</label><select name="objectif_code" class="form-select"><option value="">Tous</option><?php foreach ($objectifs as $obj): ?><option value="<?= esc($obj['code']) ?>"><?= esc($obj['libelle']) ?></option><?php endforeach; ?></select></div>
    <div style="display:flex;gap:1rem">
        <button type="submit" class="btn-primary-cja">Créer</button>
        <a href="<?= base_url('admin/activites') ?>" class="btn-ghost" style="color:rgba(226,232,240,.6);border-color:rgba(255,255,255,.1)">Annuler</a>
    </div>
</form>
<?= $this->endSection() ?>
