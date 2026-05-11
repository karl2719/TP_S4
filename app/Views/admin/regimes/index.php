<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
    <h1 class="admin-title">Régimes</h1>
    <a class="btn-primary-cja" href="<?= base_url('admin/regimes/create') ?>"><i class="fa-solid fa-plus"></i> Nouveau</a>
</div>
<div class="admin-panel">
    <div style="overflow-x:auto">
        <table class="admin-table">
            <thead><tr><th>ID</th><th>Nom</th><th>Actif</th><th>Prix</th><th></th></tr></thead>
            <tbody>
                <?php foreach ($regimes as $regime): ?>
                <tr>
                    <td><?= esc($regime['id']) ?></td>
                    <td style="font-weight:500"><?= esc($regime['nom']) ?></td>
                    <td><span style="color:<?= (int)$regime['actif']===1?'var(--primary-light)':'#ef4444' ?>"><?= (int)$regime['actif']===1?'Oui':'Non' ?></span></td>
                    <td><?php foreach ($regime['prix'] as $p): ?><div style="font-size:.8rem"><?= (int)$p['duree_semaines'] ?> sem — <?= number_format((float)$p['prix'],2) ?> €</div><?php endforeach; ?></td>
                    <td style="text-align:right">
                        <a class="btn-icon" href="<?= base_url('admin/regimes/edit/'.$regime['id']) ?>" title="Éditer"><i class="fa-solid fa-pen"></i></a>
                        <button class="btn-icon danger" onclick="deleteConfirm('<?= base_url('admin/regimes/delete/'.$regime['id']) ?>')" title="Supprimer"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function deleteConfirm(url){
    Swal.fire({title:'Supprimer ?',text:'Cette action est irréversible.',icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',cancelButtonText:'Annuler',confirmButtonText:'Supprimer',background:'#0D1F15',color:'#fff'}).then(r=>{if(r.isConfirmed)window.location.href=url});
}
</script>
<?= $this->endSection() ?>
