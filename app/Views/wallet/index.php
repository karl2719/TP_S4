<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-content">
<div class="wallet-page">
    <div class="wallet-balance-card" data-aos="fade-up">
        <div class="wallet-label">Solde actuel</div>
        <div class="wallet-amount">
            <span id="solde-local" data-solde="<?= number_format((float) $user['solde_wallet'], 2, '.', '') ?>">0.00</span>
            <span class="wallet-currency">EUR</span>
        </div>
    </div>

    <div class="wallet-form-card" data-aos="fade-up" data-aos-delay="100">
        <h1 style="font-family:var(--font-display);font-size:1.3rem;margin-bottom:1.5rem">Créditer mon wallet</h1>
        <form id="wallet-form">
            <?= csrf_field() ?>
            <div style="margin-bottom:1.5rem">
                <label style="font-size:.85rem;color:var(--text-muted);display:block;margin-bottom:.5rem">Code portefeuille</label>
                <input type="text" name="code" class="coupon-input" id="wallet-code" required autocomplete="off">
            </div>
            <button type="submit" class="btn-primary-cja ripple" style="width:100%" id="wallet-submit">
                <span class="wallet-submit-text">Créditer</span>
            </button>
        </form>
    </div>
</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const soldeLocal = document.getElementById('solde-local');
const soldeNav = document.getElementById('solde-nav');
const codeInput = document.getElementById('wallet-code');
const walletForm = document.getElementById('wallet-form');
const walletSubmit = document.getElementById('wallet-submit');
const walletSubmitText = walletSubmit.querySelector('.wallet-submit-text');

// Initial CountUp
const initSolde = parseFloat(soldeLocal.dataset.solde || '0');
if (window.countUp) {
    new countUp.CountUp(soldeLocal, initSolde, {decimalPlaces:2, duration:1.5}).start();
}

// Auto-uppercase
codeInput.addEventListener('input', () => { codeInput.value = codeInput.value.toUpperCase(); });

walletForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(walletForm);
    fd.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
    walletSubmitText.textContent = 'Traitement...';
    walletSubmit.disabled = true;
    codeInput.classList.remove('shake');

    fetch('<?= base_url('wallet/crediter') ?>', {
        method: 'POST', headers: {'X-Requested-With':'XMLHttpRequest'}, body: fd
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const nv = parseFloat(data.nouveau_solde.replace(',','.')) || initSolde;
            soldeLocal.dataset.solde = nv.toFixed(2);
            if (window.countUp) new countUp.CountUp(soldeLocal, nv, {decimalPlaces:2, duration:1}).start();
            if (soldeNav) soldeNav.textContent = nv.toFixed(2) + ' EUR';
            Toastify({text:data.message||'Portefeuille crédité !',duration:3500,gravity:"bottom",position:"right",style:{background:"linear-gradient(135deg,#2D6A4F,#52B788)",borderRadius:"12px",fontFamily:"'DM Sans',sans-serif"}}).showToast();
            walletForm.reset();
        } else {
            codeInput.classList.add('shake');
            Toastify({text:data.message||'Code invalide.',duration:3500,gravity:"bottom",position:"right",style:{background:"linear-gradient(135deg,#dc2626,#ef4444)",borderRadius:"12px",fontFamily:"'DM Sans',sans-serif"}}).showToast();
        }
    })
    .catch(() => {
        codeInput.classList.add('shake');
        Toastify({text:'Erreur réseau.',duration:3500,gravity:"bottom",position:"right",style:{background:"linear-gradient(135deg,#dc2626,#ef4444)",borderRadius:"12px"}}).showToast();
    })
    .finally(() => { walletSubmitText.textContent = 'Créditer'; walletSubmit.disabled = false; });
});
</script>
<?= $this->endSection() ?>
