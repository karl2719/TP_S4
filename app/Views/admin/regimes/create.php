<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h1 class="admin-title" style="margin-bottom:1.5rem">Créer un régime</h1>
<form method="post" action="<?= base_url('admin/regimes/store') ?>" class="admin-form">
    <?= csrf_field() ?>
    <div style="margin-bottom:1rem"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required></div>
    <div style="margin-bottom:1rem"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"></textarea></div>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;margin-bottom:1rem">
        <div><label class="form-label">% Viande</label><input type="number" name="pct_viande" class="form-control" id="pct_viande" min="0" max="100" oninput="verifierTotal()" required></div>
        <div><label class="form-label">% Poisson</label><input type="number" name="pct_poisson" class="form-control" id="pct_poisson" min="0" max="100" oninput="verifierTotal()" required></div>
        <div><label class="form-label">% Volaille</label><input type="number" name="pct_volaille" class="form-control" id="pct_volaille" min="0" max="100" oninput="verifierTotal()" required></div>
    </div>
    <div style="font-size:.8rem;color:rgba(226,232,240,.5);margin-bottom:1rem">Total: <span id="total-pct">0</span>%</div>
    <div style="margin-bottom:1.5rem"><label class="form-label">Variation poids / semaine</label><input type="number" name="variation_poids" class="form-control" step="0.01" required></div>
    <hr style="border-color:rgba(255,255,255,.06);margin:1.5rem 0">
    <h2 style="font-size:1rem;color:#fff;margin-bottom:1rem">Prix selon durée</h2>
    <div id="prix-container">
        <div class="prix-row" style="display:grid;grid-template-columns:1fr 1fr auto;gap:.8rem;margin-bottom:.8rem">
            <input name="durees[]" type="number" class="form-control" placeholder="Semaines">
            <input name="prix[]" type="number" step="0.01" class="form-control" placeholder="Prix (EUR)">
            <button type="button" class="btn-icon danger" onclick="this.closest('.prix-row').remove()"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <button type="button" style="background:none;border:1px dashed rgba(255,255,255,.15);color:rgba(226,232,240,.6);padding:.5rem 1rem;border-radius:8px;cursor:pointer;font-size:.85rem;margin-bottom:1.5rem" onclick="ajouterLigne()">+ Ajouter une durée</button>
    <div style="display:flex;gap:1rem">
        <button type="submit" class="btn-primary-cja">Créer</button>
        <a href="<?= base_url('admin/regimes') ?>" class="btn-ghost" style="color:rgba(226,232,240,.6);border-color:rgba(255,255,255,.1)">Annuler</a>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function verifierTotal(){const v=parseInt(document.getElementById('pct_viande').value)||0;const p=parseInt(document.getElementById('pct_poisson').value)||0;const vol=parseInt(document.getElementById('pct_volaille').value)||0;document.getElementById('total-pct').textContent=v+p+vol;}
function ajouterLigne(){const c=document.getElementById('prix-container');const d=document.createElement('div');d.className='prix-row';d.style.cssText='display:grid;grid-template-columns:1fr 1fr auto;gap:.8rem;margin-bottom:.8rem';d.innerHTML='<input name="durees[]" type="number" class="form-control" placeholder="Semaines"><input name="prix[]" type="number" step="0.01" class="form-control" placeholder="Prix (EUR)"><button type="button" class="btn-icon danger" onclick="this.closest(\'.prix-row\').remove()"><i class="fa-solid fa-xmark"></i></button>';c.appendChild(d);}
</script>
<?= $this->endSection() ?>
