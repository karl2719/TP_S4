<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="gold-page">
    <!-- Gold particles -->
    <div class="gold-particles">
        <?php for ($i = 0; $i < 20; $i++):
            $left = rand(5, 95); $delay = rand(0, 100) / 10; $dur = rand(60, 120) / 10; $size = rand(2, 6);
        ?>
        <span class="gold-particle" style="left:<?= $left ?>%;animation-delay:<?= $delay ?>s;animation-duration:<?= $dur ?>s;width:<?= $size ?>px;height:<?= $size ?>px"></span>
        <?php endfor; ?>
    </div>

    <div class="container-cja" style="position:relative;z-index:2;padding-top:2rem;padding-bottom:4rem">
        <h1 class="gold-title" data-aos="fade-up">⭐ Comme j'adore Gold</h1>
        <p class="gold-subtitle" data-aos="fade-up" data-aos-delay="100">Économisez 15% sur tous vos programmes</p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-top:3rem;max-width:900px;margin-left:auto;margin-right:auto">
            <!-- Benefits -->
            <div class="gold-benefits-card" data-aos="fade-right">
                <h2 style="color:#fff;font-family:var(--font-display);font-size:1.2rem;margin-bottom:1.2rem">Bénéfices Gold</h2>
                <ul class="gold-list">
                    <li><span class="gold-check">✓</span> 15% de réduction sur tous les régimes</li>
                    <li><span class="gold-check">✓</span> Accès prioritaire aux nouveaux programmes</li>
                    <li><span class="gold-check">✓</span> Badge exclusif ⭐ sur votre profil</li>
                    <li><span class="gold-check">✓</span> Export PDF illimité</li>
                </ul>
            </div>

            <!-- Price / Congrats -->
            <div data-aos="fade-left">
                <?php if ((int) $user['option_gold'] === 1): ?>
                <div class="gold-congrats">
                    <span class="gold-badge" style="font-size:1.1rem">⭐ GOLD</span>
                    <h3>Félicitations !</h3>
                    <p>Vous profitez déjà de tous les avantages Gold.</p>
                </div>
                <?php else: ?>
                <div class="gold-price-card">
                    <span class="gold-badge" style="font-size:1rem">⭐ GOLD</span>
                    <div class="gold-price"><?= number_format((float) $prix_gold, 2) ?> EUR</div>
                    <p style="color:rgba(255,255,255,.5);font-size:.85rem;margin-bottom:1.5rem">Paiement unique pour activer l'option Gold.</p>
                    <form method="post" action="<?= base_url('gold/activer') ?>">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-gold-cja ripple" style="width:100%">Activer maintenant</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
@media(max-width:768px){
    .gold-page [style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr !important}
}
</style>
<?= $this->endSection() ?>
