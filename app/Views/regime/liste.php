<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Banner -->
<section class="regime-banner">
    <div class="regime-banner-overlay"></div>
    <div class="regime-banner-content" data-aos="fade-up">
        <h1>Votre programme personnalisé</h1>
        <p>Objectif: <?= esc($objectif['libelle']) ?></p>
    </div>
</section>

<div class="page-content" style="padding-top:0">
<div class="container-cja">
    <div class="regime-grid">
        <?php foreach ($regimes as $regime):
            $variation = (float) $regime['variation_poids_par_semaine'];
            $isPositive = $variation > 0;
            $variationLabel = ($isPositive ? '▲ +' : '▼ ') . number_format(abs($variation), 2) . ' kg/sem';
            $variationClass = $isPositive ? 'variation-up' : 'variation-down';
            $firstPrix = $regime['prix'][0] ?? null;
            $prixBase = $firstPrix ? (float) $firstPrix['prix'] : 0.0;
            $prixFinal = $user['option_gold'] ? round($prixBase * 0.85, 2) : $prixBase;
            $prixId = $firstPrix ? (int) $firstPrix['id'] : 0;
            $dureeDefault = $firstPrix ? (int) $firstPrix['duree_semaines'] : 0;
        ?>
        <div class="regime-card" data-aos="fade-up">
            <div class="regime-card-band"></div>
            <div class="regime-card-body">
                <div class="regime-card-header">
                    <h2><?= esc($regime['nom']) ?></h2>
                    <span class="variation-badge <?= $variationClass ?>"><?= esc($variationLabel) ?></span>
                </div>
                <p style="color:var(--text-muted);font-size:.85rem"><?= esc($regime['description']) ?></p>

                <div class="macro-group">
                    <div class="macro-row">
                        <span>Viande</span>
                        <div class="macro-bar"><div class="macro-fill macro-viande" data-percent="<?= (int) $regime['pct_viande'] ?>"></div></div>
                        <span><?= (int) $regime['pct_viande'] ?>%</span>
                    </div>
                    <div class="macro-row">
                        <span>Poisson</span>
                        <div class="macro-bar"><div class="macro-fill macro-poisson" data-percent="<?= (int) $regime['pct_poisson'] ?>"></div></div>
                        <span><?= (int) $regime['pct_poisson'] ?>%</span>
                    </div>
                    <div class="macro-row">
                        <span>Volaille</span>
                        <div class="macro-bar"><div class="macro-fill macro-volaille" data-percent="<?= (int) $regime['pct_volaille'] ?>"></div></div>
                        <span><?= (int) $regime['pct_volaille'] ?>%</span>
                    </div>
                </div>

                <div class="regime-tabs" data-regime="<?= (int) $regime['id'] ?>">
                    <?php foreach ($regime['prix'] as $index => $prix):
                        $prixBaseTab = (float) $prix['prix'];
                        $prixFinalTab = $user['option_gold'] ? round($prixBaseTab * 0.85, 2) : $prixBaseTab;
                    ?>
                    <button type="button" class="regime-tab <?= $index === 0 ? 'active' : '' ?>"
                        data-regime-prix-id="<?= (int) $prix['id'] ?>"
                        data-duree="<?= (int) $prix['duree_semaines'] ?>"
                        data-prix-base="<?= number_format($prixBaseTab, 2, '.', '') ?>"
                        data-prix-final="<?= number_format($prixFinalTab, 2, '.', '') ?>">
                        <?= (int) $prix['duree_semaines'] ?> sem
                    </button>
                    <?php endforeach; ?>
                </div>

                <div class="regime-price" data-regime="<?= (int) $regime['id'] ?>">
                    <?php if ($user['option_gold']): ?>
                        <span class="price-original"><?= number_format($prixBase, 2) ?> EUR</span>
                    <?php endif; ?>
                    <span class="price-final <?= $user['option_gold'] ? 'gold' : '' ?>"><?= number_format($prixFinal, 2) ?> EUR</span>
                </div>

                <button type="button" class="btn-primary-cja ripple btn-souscrire" style="width:100%"
                    data-regime-prix-id="<?= $prixId ?>"
                    data-regime-nom="<?= esc($regime['nom']) ?>"
                    data-duree="<?= $dureeDefault ?>"
                    data-prix="<?= number_format($prixFinal, 2) ?>">
                    Souscrire
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let userSolde = <?= number_format((float) $user['solde_wallet'], 2, '.', '') ?>;

// Animate macro bars
document.querySelectorAll('.macro-fill[data-percent]').forEach(bar => {
    const pct = parseInt(bar.dataset.percent || '0', 10);
    setTimeout(() => { bar.style.width = Math.min(pct, 100) + '%'; }, 300);
});

// Duration tabs
document.querySelectorAll('.regime-tabs').forEach(tabGroup => {
    tabGroup.addEventListener('click', e => {
        const btn = e.target.closest('.regime-tab');
        if (!btn) return;
        tabGroup.querySelectorAll('.regime-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        const rid = tabGroup.dataset.regime;
        const priceBox = document.querySelector(`.regime-price[data-regime="${rid}"]`);
        if (priceBox) {
            const pf = priceBox.querySelector('.price-final');
            if (pf) pf.textContent = parseFloat(btn.dataset.prixFinal).toFixed(2) + ' EUR';
            const po = priceBox.querySelector('.price-original');
            if (po) po.textContent = parseFloat(btn.dataset.prixBase).toFixed(2) + ' EUR';
        }
        const card = tabGroup.closest('.regime-card');
        const sub = card.querySelector('.btn-souscrire');
        sub.dataset.regimePrixId = btn.dataset.regimePrixId;
        sub.dataset.duree = btn.dataset.duree;
        sub.dataset.prix = parseFloat(btn.dataset.prixFinal).toFixed(2);
    });
});

// Purchase via SweetAlert2
document.querySelectorAll('.btn-souscrire').forEach(btn => {
    btn.addEventListener('click', function() {
        const nom = this.dataset.regimeNom;
        const duree = this.dataset.duree;
        const prix = parseFloat(this.dataset.prix);
        const prixId = this.dataset.regimePrixId;
        const insuffisant = userSolde < prix;

        Swal.fire({
            title: "Confirmer l'achat",
            html: `
                <div style="text-align:left;font-family:'DM Sans',sans-serif;font-size:.9rem">
                    <div style="margin-bottom:.5rem"><strong>Régime:</strong> ${nom}</div>
                    <div style="margin-bottom:.5rem"><strong>Durée:</strong> ${duree} semaines</div>
                    <div style="margin-bottom:.8rem"><strong>Prix:</strong> ${prix.toFixed(2)} EUR</div>
                    <div style="padding:.8rem;border-radius:10px;background:${insuffisant ? 'rgba(239,68,68,.1)' : 'rgba(82,183,136,.1)'}">
                        <span>Solde actuel:</span>
                        <strong style="float:right;color:${insuffisant ? '#ef4444' : '#2f9e44'}">${userSolde.toFixed(2)} EUR</strong>
                    </div>
                    ${insuffisant ? '<div style="color:#ef4444;font-size:.8rem;margin-top:.5rem">⚠ Solde insuffisant</div>' : ''}
                </div>`,
            background: '#0D1F15',
            color: '#fff',
            confirmButtonText: 'Confirmer',
            cancelButtonText: 'Annuler',
            showCancelButton: true,
            confirmButtonColor: '#52B788',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const fd = new FormData();
                fd.append('regime_prix_id', prixId);
                fd.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
                return fetch('<?= base_url('regimes/acheter') ?>', {
                    method: 'POST', headers: {'X-Requested-With':'XMLHttpRequest'}, body: fd
                }).then(r => r.json());
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then(result => {
            if (result.isConfirmed && result.value) {
                const data = result.value;
                if (data.success) {
                    if (window.confetti) confetti({particleCount:150,spread:80,origin:{y:0.6}});
                    const nav = document.getElementById('solde-nav');
                    if (nav) nav.textContent = data.nouveau_solde + ' EUR';
                    userSolde = parseFloat(data.nouveau_solde.replace(',','.')) || userSolde;
                    Swal.fire({title:'Bravo !',text:data.message,icon:'success',background:'#0D1F15',color:'#fff',confirmButtonColor:'#52B788'});
                } else {
                    Swal.fire({title:'Erreur',text:data.message,icon:'error',background:'#0D1F15',color:'#fff',confirmButtonColor:'#F4A261'});
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
