<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h1 class="admin-title" style="margin-bottom:1.5rem">Paramètres</h1>
<form method="post" action="<?= base_url('admin/params/update') ?>" class="admin-form">
    <?= csrf_field() ?>
    <div style="overflow-x:auto">
        <table class="admin-table">
            <thead><tr><th>Clé</th><th>Valeur</th><th>Description</th></tr></thead>
            <tbody>
                <?php foreach ($params as $param): ?>
                <tr>
                    <td style="font-family:var(--font-mono);font-size:.85rem"><?= esc($param['cle']) ?></td>
                    <td><input type="text" name="params[<?= esc($param['id']) ?>]" class="form-control" value="<?= esc($param['valeur']) ?>" style="min-width:120px"></td>
                    <td style="color:rgba(226,232,240,.5);font-size:.85rem"><?= esc($param['description']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top:1.5rem">
        <button type="submit" class="btn-primary-cja">Enregistrer</button>
    </div>
</form>
<?= $this->endSection() ?>
