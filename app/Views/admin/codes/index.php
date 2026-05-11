<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
    <h1 class="admin-title">Codes portefeuille</h1>
    <a class="btn-primary-cja" href="<?= base_url('admin/codes/create') ?>"><i class="fa-solid fa-plus"></i> Nouveau</a>
</div>
<div class="admin-panel">
    <div style="overflow-x:auto">
        <table class="admin-table">
            <thead><tr><th>ID</th><th>Code</th><th>Montant</th><th>Actif</th><th>Utilisateur</th><th>Utilisé le</th><th></th></tr></thead>
            <tbody>
                <?php foreach ($codes as $code): ?>
                <tr>
                    <td><?= esc($code['id']) ?></td>
                    <td style="font-family:var(--font-mono);font-weight:500"><?= esc($code['code']) ?></td>
                    <td><?= number_format((float)$code['montant'],2) ?> €</td>
                    <td><span style="color:<?= (int)$code['actif']===1?'var(--primary-light)':'#ef4444' ?>"><?= (int)$code['actif']===1?'Oui':'Non' ?></span></td>
                    <td><?= esc($code['utilisateur_id'] ?? '—') ?></td>
                    <td><?= esc($code['utilise_le'] ?? '—') ?></td>
                    <td style="text-align:right">
                        <button class="btn-icon danger" onclick="Swal.fire({title:'Supprimer ce code ?',icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',background:'#0D1F15',color:'#fff',confirmButtonText:'Supprimer',cancelButtonText:'Annuler'}).then(r=>{if(r.isConfirmed)window.location.href='<?= base_url('admin/codes/delete/'.$code['id']) ?>'})" title="Supprimer"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
