<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-content">
<div class="container-cja section-pad">
    <div style="max-width:800px">
        <div class="card-elevated" data-aos="fade-up">
            <h1 style="font-family:var(--font-display);font-size:1.4rem;margin-bottom:.5rem"><?= esc($regime['nom']) ?></h1>
            <p style="color:var(--text-muted);margin-bottom:1.5rem"><?= esc($regime['description']) ?></p>

            <div style="margin-bottom:1.5rem">
                <div style="font-size:.8rem;text-transform:uppercase;letter-spacing:.05em;color:var(--text-muted);margin-bottom:.8rem">Répartition macros</div>
                <div class="macro-group">
                    <div class="macro-row"><span>Viande</span><div class="macro-bar"><div class="macro-fill macro-viande" style="width:<?= (int) $regime['pct_viande'] ?>%"></div></div><span><?= (int) $regime['pct_viande'] ?>%</span></div>
                    <div class="macro-row"><span>Poisson</span><div class="macro-bar"><div class="macro-fill macro-poisson" style="width:<?= (int) $regime['pct_poisson'] ?>%"></div></div><span><?= (int) $regime['pct_poisson'] ?>%</span></div>
                    <div class="macro-row"><span>Volaille</span><div class="macro-bar"><div class="macro-fill macro-volaille" style="width:<?= (int) $regime['pct_volaille'] ?>%"></div></div><span><?= (int) $regime['pct_volaille'] ?>%</span></div>
                </div>
            </div>

            <h2 style="font-size:1rem;margin-bottom:.8rem">Prix disponibles</h2>
            <?php foreach ($regime['prix'] as $prix):
                $pb = (float) $prix['prix'];
                $pf = $user['option_gold'] ? round($pb * 0.85, 2) : $pb;
            ?>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:.8rem 1rem;background:rgba(0,0,0,.02);border-radius:10px;margin-bottom:.5rem">
                <span><?= (int) $prix['duree_semaines'] ?> semaines</span>
                <span style="font-weight:600;color:<?= $user['option_gold'] ? 'var(--gold)' : 'var(--text)' ?>"><?= number_format($pf, 2) ?> EUR</span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>
