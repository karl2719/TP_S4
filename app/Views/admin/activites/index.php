<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
    <h1 class="admin-title">Activités</h1>
    <a class="btn-primary-cja" href="<?= base_url('admin/activites/create') ?>"><i class="fa-solid fa-plus"></i> Nouvelle</a>
</div>
<div class="admin-panel">
    <div style="overflow-x:auto">
        <table class="admin-table">
            <thead><tr><th>ID</th><th>Nom</th><th>Intensité</th><th>Objectif</th><th>Actif</th><th></th></tr></thead>
            <tbody>
                <?php foreach ($activites as $a): ?>
                <tr>
                    <td><?= esc($a['id']) ?></td>
                    <td style="font-weight:500"><?= esc($a['nom']) ?></td>
                    <td><?= esc($a['intensite']) ?></td>
                    <td><?= esc($a['objectif_code'] ?? '—') ?></td>
                    <td><span style="color:<?= (int)$a['actif']===1?'var(--primary-light)':'#ef4444' ?>"><?= (int)$a['actif']===1?'Oui':'Non' ?></span></td>
                    <td style="text-align:right">
                        <a class="btn-icon" href="<?= base_url('admin/activites/edit/'.$a['id']) ?>" title="Éditer"><i class="fa-solid fa-pen"></i></a>
                        <button class="btn-icon danger" onclick="Swal.fire({title:'Supprimer ?',icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',background:'#0D1F15',color:'#fff',confirmButtonText:'Supprimer',cancelButtonText:'Annuler'}).then(r=>{if(r.isConfirmed)window.location.href='<?= base_url('admin/activites/delete/'.$a['id']) ?>'})" title="Supprimer"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
