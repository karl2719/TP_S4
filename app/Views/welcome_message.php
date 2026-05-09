<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aliméa — Votre programme minceur personnalisé</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --rose: #E8849A;
    --rose-light: #F7D0DA;
    --rose-pale: #FDF0F3;
    --rose-deep: #C45A74;
    --rose-dark: #8B3A52;
    --cream: #FAF7F4;
    --sand: #F0EAE2;
    --text: #2A1A20;
    --text-mid: #7A5A64;
    --text-light: #B8959F;
    --green: #8BAE7A;
    --green-light: #E8F0E4;
  }

  html { scroll-behavior: smooth; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--text);
    overflow-x: hidden;
  }

  /* ── NAV ── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.2rem 4rem;
    background: rgba(250,247,244,0.85);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid rgba(232,132,154,0.15);
  }

  .nav-logo {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.8rem;
    font-weight: 400;
    color: var(--rose-deep);
    letter-spacing: 0.02em;
    display: flex; align-items: center; gap: 8px;
  }
  .nav-logo .leaf {
    width: 24px; height: 24px;
    background: linear-gradient(135deg, var(--rose-deep), var(--rose));
    border-radius: 0 60% 0 60%;
    transform: rotate(-20deg);
    flex-shrink: 0;
  }

  .nav-links {
    display: flex; align-items: center; gap: 2.5rem;
    list-style: none;
  }
  .nav-links a {
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 400;
    color: var(--text-mid);
    transition: color 0.2s;
    letter-spacing: 0.03em;
  }
  .nav-links a:hover { color: var(--rose-deep); }

  .nav-cta {
    background: var(--rose-deep);
    color: white !important;
    padding: 0.55rem 1.4rem;
    border-radius: 50px;
    font-weight: 500 !important;
    transition: background 0.2s, transform 0.15s !important;
  }
  .nav-cta:hover { background: var(--rose-dark) !important; transform: translateY(-1px); }

  /* ── HERO ── */
  .hero {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    padding: 8rem 4rem 4rem;
    gap: 4rem;
    position: relative;
    overflow: hidden;
  }

  .hero::before {
    content: '';
    position: absolute;
    top: -10%;
    right: -5%;
    width: 60%;
    height: 110%;
    background: radial-gradient(ellipse at 70% 40%, var(--rose-light) 0%, transparent 65%),
                radial-gradient(ellipse at 30% 80%, var(--sand) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
  }

  .hero-text { position: relative; z-index: 1; }

  .hero-tag {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--rose-pale);
    border: 1px solid var(--rose-light);
    color: var(--rose-deep);
    font-size: 0.78rem;
    font-weight: 500;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 1.8rem;
    opacity: 0;
    animation: fadeUp 0.6s 0.1s forwards;
  }
  .hero-tag::before {
    content: '';
    width: 6px; height: 6px;
    background: var(--rose);
    border-radius: 50%;
  }

  .hero h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(3rem, 5vw, 5.2rem);
    font-weight: 300;
    line-height: 1.1;
    color: var(--text);
    margin-bottom: 1.5rem;
    opacity: 0;
    animation: fadeUp 0.7s 0.25s forwards;
  }
  .hero h1 em {
    font-style: italic;
    color: var(--rose-deep);
  }

  .hero-sub {
    font-size: 1.05rem;
    color: var(--text-mid);
    line-height: 1.7;
    max-width: 430px;
    margin-bottom: 2.5rem;
    font-weight: 300;
    opacity: 0;
    animation: fadeUp 0.7s 0.4s forwards;
  }

  .hero-actions {
    display: flex; align-items: center; gap: 1.2rem;
    opacity: 0;
    animation: fadeUp 0.7s 0.55s forwards;
  }

  .btn-primary {
    display: inline-block;
    background: var(--rose-deep);
    color: white;
    padding: 0.85rem 2.2rem;
    border-radius: 50px;
    font-size: 0.95rem;
    font-weight: 500;
    text-decoration: none;
    letter-spacing: 0.02em;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    box-shadow: 0 4px 20px rgba(196,90,116,0.3);
  }
  .btn-primary:hover {
    background: var(--rose-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(196,90,116,0.4);
  }

  .btn-ghost {
    display: inline-flex; align-items: center; gap: 8px;
    color: var(--text-mid);
    font-size: 0.9rem;
    text-decoration: none;
    transition: color 0.2s;
  }
  .btn-ghost:hover { color: var(--rose-deep); }
  .btn-ghost svg { transition: transform 0.2s; }
  .btn-ghost:hover svg { transform: translateX(3px); }

  /* Hero image panel */
  .hero-visual {
    position: relative; z-index: 1;
    display: flex; flex-direction: column; align-items: center;
    opacity: 0;
    animation: fadeIn 0.9s 0.5s forwards;
  }

  .hero-card-main {
    background: white;
    border-radius: 28px;
    padding: 2rem;
    width: 100%;
    max-width: 380px;
    box-shadow: 0 20px 60px rgba(180,80,100,0.12), 0 4px 16px rgba(0,0,0,0.06);
    position: relative;
  }

  .plate-visual {
    width: 200px; height: 200px;
    border-radius: 50%;
    background: conic-gradient(
      var(--green) 0% 30%,
      var(--rose-light) 30% 55%,
      #F5C17A 55% 70%,
      #B8D9A8 70% 85%,
      var(--rose-pale) 85% 100%
    );
    margin: 0 auto 1.2rem;
    position: relative;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
  }
  .plate-visual::after {
    content: '';
    position: absolute;
    inset: 12px;
    background: white;
    border-radius: 50%;
  }
  .plate-icon {
    position: absolute;
    inset: 0;
    display: flex; align-items: center; justify-content: center;
    z-index: 1;
    font-size: 2.5rem;
  }

  .meal-label {
    text-align: center;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.4rem;
    font-weight: 400;
    color: var(--text);
    margin-bottom: 0.3rem;
  }
  .meal-sub {
    text-align: center;
    font-size: 0.8rem;
    color: var(--text-light);
    margin-bottom: 1.4rem;
  }

  .macros {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 8px;
  }
  .macro {
    background: var(--cream);
    border-radius: 12px;
    padding: 0.6rem;
    text-align: center;
  }
  .macro-val {
    font-size: 1rem;
    font-weight: 500;
    color: var(--text);
  }
  .macro-name {
    font-size: 0.7rem;
    color: var(--text-light);
  }

  .hero-badge {
    position: absolute;
    top: -16px; right: -16px;
    background: var(--green-light);
    border: 1px solid var(--green);
    border-radius: 16px;
    padding: 0.5rem 0.8rem;
    display: flex; align-items: center; gap: 6px;
    font-size: 0.75rem;
    color: #4A7A3A;
    font-weight: 500;
    white-space: nowrap;
  }

  .floating-chip {
    position: absolute;
    background: white;
    border-radius: 20px;
    padding: 0.55rem 0.9rem;
    display: flex; align-items: center; gap: 8px;
    font-size: 0.78rem;
    font-weight: 500;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    white-space: nowrap;
  }
  .chip-1 { bottom: -20px; left: -30px; color: var(--text); animation: float 3s ease-in-out infinite; }
  .chip-2 { top: 50%; right: -30px; transform: translateY(-50%); color: var(--text); animation: float 3s ease-in-out 1.5s infinite; }

  @keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
  }
  .chip-2 { transform: translateY(-50%); }
  @keyframes float2 {
    0%, 100% { transform: translateY(-50%); }
    50% { transform: translateY(calc(-50% - 6px)); }
  }
  .chip-2 { animation: float2 3s ease-in-out 1.5s infinite; }

  .chip-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
  }

  /* Stars */
  .hero-stars {
    display: flex; align-items: center; gap: 8px;
    margin-top: 2rem;
    opacity: 0;
    animation: fadeUp 0.7s 0.7s forwards;
  }
  .stars { color: #F5A623; font-size: 0.9rem; letter-spacing: 2px; }
  .stars-text { font-size: 0.82rem; color: var(--text-mid); }

  /* ── SECTION COMMUNE ── */
  section { padding: 6rem 4rem; }

  .section-tag {
    font-size: 0.75rem;
    font-weight: 500;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--rose);
    margin-bottom: 0.8rem;
  }
  .section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2rem, 3.5vw, 3.2rem);
    font-weight: 300;
    line-height: 1.2;
    color: var(--text);
    margin-bottom: 1rem;
  }
  .section-title em { font-style: italic; color: var(--rose-deep); }
  .section-sub {
    font-size: 1rem;
    color: var(--text-mid);
    line-height: 1.7;
    font-weight: 300;
    max-width: 520px;
  }

  /* ── STATS BAND ── */
  .stats-band {
    background: var(--rose-deep);
    padding: 3rem 4rem;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    text-align: center;
    gap: 2rem;
  }
  .stat-item { color: white; }
  .stat-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 3rem;
    font-weight: 300;
    line-height: 1;
    margin-bottom: 0.4rem;
  }
  .stat-label {
    font-size: 0.85rem;
    opacity: 0.75;
    font-weight: 300;
  }

  /* ── HOW IT WORKS ── */
  .how {
    background: white;
  }
  .how-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 5rem;
    align-items: center;
    margin-top: 3.5rem;
  }
  .steps { display: flex; flex-direction: column; gap: 2rem; }

  .step {
    display: flex; gap: 1.2rem; align-items: flex-start;
    padding: 1.5rem;
    border-radius: 16px;
    border: 1.5px solid transparent;
    cursor: default;
    transition: border-color 0.3s, background 0.3s;
  }
  .step:hover {
    border-color: var(--rose-light);
    background: var(--rose-pale);
  }
  .step-num {
    width: 36px; height: 36px;
    background: var(--rose-pale);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.3rem;
    font-weight: 500;
    color: var(--rose-deep);
    flex-shrink: 0;
  }
  .step h3 { font-size: 1rem; font-weight: 500; margin-bottom: 0.3rem; }
  .step p { font-size: 0.875rem; color: var(--text-mid); line-height: 1.6; font-weight: 300; }

  /* Phone mockup */
  .phone-mockup {
    position: relative;
    width: 280px;
    margin: 0 auto;
  }
  .phone-frame {
    background: var(--text);
    border-radius: 44px;
    padding: 14px;
    box-shadow: 0 30px 80px rgba(42,26,32,0.25);
  }
  .phone-screen {
    background: var(--cream);
    border-radius: 32px;
    overflow: hidden;
    min-height: 520px;
  }
  .phone-bar {
    background: white;
    padding: 1rem 1.2rem 0.8rem;
    border-bottom: 1px solid var(--sand);
  }
  .phone-greeting {
    font-size: 0.7rem;
    color: var(--text-light);
    margin-bottom: 2px;
  }
  .phone-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem;
    font-weight: 400;
    color: var(--text);
  }
  .phone-meals {
    padding: 0.8rem 1rem;
    display: flex; flex-direction: column; gap: 8px;
  }
  .phone-meal {
    background: white;
    border-radius: 14px;
    padding: 0.8rem 1rem;
    display: flex; align-items: center; gap: 10px;
  }
  .meal-emoji { font-size: 1.4rem; }
  .meal-info-label { font-size: 0.75rem; font-weight: 500; color: var(--text); }
  .meal-info-cal { font-size: 0.68rem; color: var(--text-light); }
  .phone-progress {
    background: white;
    margin: 0 1rem;
    border-radius: 14px;
    padding: 0.8rem 1rem;
  }
  .progress-label {
    display: flex; justify-content: space-between;
    font-size: 0.7rem; color: var(--text-mid);
    margin-bottom: 6px;
  }
  .progress-bar {
    height: 6px; background: var(--sand); border-radius: 3px;
    overflow: hidden;
  }
  .progress-fill {
    height: 100%; width: 68%;
    background: linear-gradient(90deg, var(--rose), var(--rose-deep));
    border-radius: 3px;
  }

  /* ── FEATURES ── */
  .features { background: var(--cream); }
  .features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-top: 3rem;
  }
  .feature-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid rgba(232,132,154,0.12);
    transition: transform 0.2s, box-shadow 0.2s;
  }
  .feature-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(196,90,116,0.1);
  }
  .feature-icon {
    width: 48px; height: 48px;
    background: var(--rose-pale);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    margin-bottom: 1.2rem;
  }
  .feature-card h3 {
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: var(--text);
  }
  .feature-card p {
    font-size: 0.875rem;
    color: var(--text-mid);
    line-height: 1.65;
    font-weight: 300;
  }
  .feature-card.accent {
    background: var(--rose-deep);
    border-color: transparent;
  }
  .feature-card.accent .feature-icon { background: rgba(255,255,255,0.15); }
  .feature-card.accent h3 { color: white; }
  .feature-card.accent p { color: rgba(255,255,255,0.72); }

  /* ── TÉMOIGNAGES ── */
  .testimonials { background: white; }
  .testi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-top: 3rem;
  }
  .testi-card {
    background: var(--cream);
    border-radius: 20px;
    padding: 1.8rem;
    position: relative;
  }
  .testi-quote {
    font-family: 'Cormorant Garamond', serif;
    font-size: 3rem;
    color: var(--rose-light);
    line-height: 1;
    margin-bottom: 0.5rem;
  }
  .testi-text {
    font-size: 0.9rem;
    color: var(--text-mid);
    line-height: 1.7;
    font-weight: 300;
    margin-bottom: 1.2rem;
    font-style: italic;
  }
  .testi-author { display: flex; align-items: center; gap: 10px; }
  .avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem;
    font-weight: 500;
    color: white;
    flex-shrink: 0;
  }
  .testi-name { font-size: 0.85rem; font-weight: 500; color: var(--text); }
  .testi-loss { font-size: 0.75rem; color: var(--green); font-weight: 500; }
  .testi-stars { font-size: 0.7rem; color: #F5A623; margin-top: 2px; }

  /* ── PLANS ── */
  .plans { background: var(--cream); }
  .plans-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem; }
  .plans-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    align-items: start;
  }
  .plan-card {
    background: white;
    border-radius: 24px;
    padding: 2rem;
    border: 1.5px solid transparent;
    transition: border-color 0.2s;
  }
  .plan-card:hover { border-color: var(--rose-light); }
  .plan-card.featured {
    background: var(--rose-deep);
    border-color: transparent;
    transform: scale(1.03);
    box-shadow: 0 20px 60px rgba(196,90,116,0.3);
  }
  .plan-label {
    font-size: 0.7rem;
    font-weight: 500;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--text-light);
    margin-bottom: 1rem;
  }
  .plan-card.featured .plan-label { color: rgba(255,255,255,0.6); }
  .plan-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.6rem;
    font-weight: 400;
    margin-bottom: 0.5rem;
    color: var(--text);
  }
  .plan-card.featured .plan-name { color: white; }
  .plan-price {
    display: flex; align-items: baseline; gap: 4px;
    margin-bottom: 1.5rem;
  }
  .price-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.8rem;
    font-weight: 300;
    color: var(--text);
  }
  .plan-card.featured .price-num { color: white; }
  .price-period { font-size: 0.85rem; color: var(--text-light); }
  .plan-card.featured .price-period { color: rgba(255,255,255,0.6); }
  .plan-features { list-style: none; margin-bottom: 2rem; display: flex; flex-direction: column; gap: 0.7rem; }
  .plan-features li {
    font-size: 0.875rem;
    color: var(--text-mid);
    display: flex; gap: 8px; align-items: flex-start;
    font-weight: 300;
  }
  .plan-card.featured .plan-features li { color: rgba(255,255,255,0.8); }
  .check { color: var(--green); font-weight: 500; }
  .plan-card.featured .check { color: rgba(255,255,255,0.9); }
  .plan-btn {
    display: block; text-align: center;
    padding: 0.8rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
  }
  .plan-btn-outline {
    border: 1.5px solid var(--rose-light);
    color: var(--rose-deep);
  }
  .plan-btn-outline:hover {
    background: var(--rose-pale);
  }
  .plan-btn-white {
    background: white;
    color: var(--rose-deep);
  }
  .plan-btn-white:hover {
    background: var(--cream);
    transform: translateY(-1px);
  }

  /* ── CTA FINAL ── */
  .cta-section {
    background: var(--rose-deep);
    padding: 7rem 4rem;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  .cta-section::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 30% 50%, rgba(255,255,255,0.08), transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(255,255,255,0.05), transparent 50%);
  }
  .cta-section * { position: relative; z-index: 1; }
  .cta-section h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    font-weight: 300;
    color: white;
    line-height: 1.15;
    margin-bottom: 1.5rem;
  }
  .cta-section h2 em { font-style: italic; opacity: 0.8; }
  .cta-section p {
    color: rgba(255,255,255,0.7);
    font-size: 1.05rem;
    font-weight: 300;
    margin-bottom: 2.5rem;
  }
  .cta-form {
    display: flex; gap: 0;
    max-width: 440px;
    margin: 0 auto;
    border-radius: 50px;
    overflow: hidden;
    background: white;
    box-shadow: 0 8px 40px rgba(0,0,0,0.15);
  }
  .cta-input {
    flex: 1;
    border: none;
    padding: 0.9rem 1.4rem;
    font-size: 0.9rem;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    background: transparent;
    color: var(--text);
  }
  .cta-input::placeholder { color: var(--text-light); }
  .cta-submit {
    background: var(--rose-deep);
    color: white;
    border: none;
    padding: 0.9rem 1.6rem;
    font-size: 0.9rem;
    font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: background 0.2s;
  }
  .cta-submit:hover { background: var(--rose-dark); }

  /* ── FOOTER ── */
  footer {
    background: var(--text);
    padding: 3rem 4rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .footer-logo {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem;
    color: var(--rose-light);
    font-weight: 300;
  }
  .footer-copy {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.3);
  }
  .footer-links {
    display: flex; gap: 1.5rem; list-style: none;
  }
  .footer-links a {
    text-decoration: none;
    font-size: 0.82rem;
    color: rgba(255,255,255,0.4);
    transition: color 0.2s;
  }
  .footer-links a:hover { color: var(--rose-light); }

  /* ── ANIMATIONS ── */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
  }

  /* ── MOBILE ── */
  @media (max-width: 768px) {

    /* Nav */
    nav {
      padding: 1rem 1.4rem;
    }
    .nav-links {
      display: none;
    }
    .nav-mobile-cta {
      display: inline-block;
      background: var(--rose-deep);
      color: white;
      padding: 0.5rem 1.1rem;
      border-radius: 50px;
      font-size: 0.82rem;
      font-weight: 500;
      text-decoration: none;
    }

    /* Hero */
    .hero {
      grid-template-columns: 1fr;
      padding: 6rem 1.4rem 3rem;
      gap: 2.5rem;
      min-height: auto;
    }
    .hero h1 {
      font-size: 2.6rem;
    }
    .hero-sub {
      font-size: 0.95rem;
      max-width: 100%;
    }
    .hero-actions {
      flex-direction: column;
      align-items: flex-start;
      gap: 1rem;
    }
    .btn-primary {
      width: 100%;
      text-align: center;
      padding: 0.9rem 1.4rem;
    }
    .hero-visual {
      order: -1;
    }
    .hero-card-main {
      max-width: 100%;
      padding: 1.4rem;
    }
    .plate-visual {
      width: 140px;
      height: 140px;
    }
    .plate-icon { font-size: 1.8rem; }
    .hero-badge {
      top: -12px;
      right: -8px;
      font-size: 0.68rem;
      padding: 0.4rem 0.6rem;
    }
    .floating-chip {
      display: none;
    }
    .hero-stars { margin-top: 1.2rem; }

    /* Stats band */
    .stats-band {
      grid-template-columns: repeat(2, 1fr);
      padding: 2rem 1.4rem;
      gap: 1.5rem;
    }
    .stat-num { font-size: 2.2rem; }
    .stat-label { font-size: 0.78rem; }

    /* Sections */
    section { padding: 3.5rem 1.4rem; }

    /* How it works */
    .how-grid {
      grid-template-columns: 1fr;
      gap: 2.5rem;
    }
    .phone-mockup {
      width: 230px;
    }
    .phone-screen { min-height: 420px; }
    .step { padding: 1rem; }

    /* Features */
    .features-grid {
      grid-template-columns: 1fr;
      gap: 1rem;
    }
    .feature-card { padding: 1.4rem; }

    /* Témoignages */
    .testi-grid {
      grid-template-columns: 1fr;
      gap: 1rem;
    }

    /* Plans */
    .plans-header {
      flex-direction: column;
      gap: 0.8rem;
      margin-bottom: 2rem;
    }
    .plans-grid {
      grid-template-columns: 1fr;
      gap: 1rem;
    }
    .plan-card.featured {
      transform: none;
    }
    .plan-card { padding: 1.4rem; }

    /* CTA */
    .cta-section { padding: 4rem 1.4rem; }
    .cta-section h2 { font-size: 2.2rem; }
    .cta-section p { font-size: 0.9rem; }
    .cta-form {
      flex-direction: column;
      border-radius: 16px;
      overflow: hidden;
    }
    .cta-input {
      padding: 0.9rem 1.2rem;
      border-bottom: 1px solid var(--sand);
    }
    .cta-submit {
      padding: 0.9rem 1.2rem;
    }

    /* Footer */
    footer {
      flex-direction: column;
      gap: 1.2rem;
      padding: 2rem 1.4rem;
      text-align: center;
    }
    .footer-links {
      flex-wrap: wrap;
      justify-content: center;
      gap: 1rem;
    }

    /* Section title */
    .section-title { font-size: 2rem; }
  }
</style>
</head>
<body>

<!-- NAV -->
<nav>
  <div class="nav-logo">
   <img src="images/icons/logo.png" alt="Alimea" srcset="" style="max-width: 100px">
  </div>
  <ul class="nav-links">
    <li><a href="#how">Comment ça marche</a></li>
    <li><a href="#features">Fonctionnalités</a></li>
    <li><a href="#testi">Témoignages</a></li>
    <li><a href="#plans">Tarifs</a></li>
    <li><a href="#start" class="nav-cta">Commencer</a></li>
  </ul>
  <a href="#start" class="nav-mobile-cta" style="display:none;">Commencer</a>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-text">
    <div class="hero-tag">Programme 100 % personnalisé</div>
    <h1>Votre corps mérite<br><em>la meilleure version</em><br>de lui-même.</h1>
    <p class="hero-sub">Aliméa crée votre programme alimentaire sur mesure — adapté à votre morphologie, vos goûts et votre rythme de vie. Perdez du poids durablement, avec plaisir.</p>
    <!-- TODO: -->
    <div class="hero-actions">
      <a href="#start" class="btn-primary">Commencer l' anenture</a>
      <a href="#how" class="btn-ghost">
        Voir comment ça marche
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
          <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </div>
    <div class="hero-stars">
      <span class="stars">★★★★★</span>
      <span class="stars-text"><strong>4,9/5</strong> — plus de 32 000 femmes satisfaites</span>
    </div>
  </div>

  <div class="hero-visual">
    <div class="hero-card-main">
      <div class="hero-badge">✦ Programme du jour</div>

      <div class="plate-visual">
        <div class="plate-icon">🥗</div>
      </div>

      <p class="meal-label">Déjeuner équilibré</p>
      <p class="meal-sub">Salade niçoise légère · 380 kcal</p>

      <div class="macros">
        <div class="macro">
          <div class="macro-val">32g</div>
          <div class="macro-name">Protéines</div>
        </div>
        <div class="macro">
          <div class="macro-val">28g</div>
          <div class="macro-name">Glucides</div>
        </div>
        <div class="macro">
          <div class="macro-val">14g</div>
          <div class="macro-name">Lipides</div>
        </div>
      </div>

      <div class="floating-chip chip-1">
        <div class="chip-dot" style="background: var(--green);"></div>
        −2,4 kg ce mois-ci 🎉
      </div>
      <div class="floating-chip chip-2">
        🔥 1 250 kcal aujourd'hui
      </div>
    </div>
  </div>
</section>

<!-- STATS -->
<div class="stats-band">
  <div class="stat-item">
    <div class="stat-num">32K+</div>
    <div class="stat-label">femmes accompagnées</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">−5,8 kg</div>
    <div class="stat-label">perte moyenne en 3 mois</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">94%</div>
    <div class="stat-label">de satisfaction client</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">1 200+</div>
    <div class="stat-label">recettes healthy disponibles</div>
  </div>
</div>

<!-- HOW IT WORKS -->
<section class="how" id="how">
  <div style="max-width: 1200px; margin: 0 auto;">
    <div class="section-tag">Comment ça marche</div>
    <div class="section-title">Simple, rapide,<br><em>et tellement efficace.</em></div>
    <div class="how-grid">
      <div class="steps">
        <div class="step">
          <div class="step-num">1</div>
          <div>
            <h3>Votre profil en 3 minutes</h3>
            <p>Répondez à quelques questions sur votre corpulence, votre mode de vie et vos préférences alimentaires. Aucune prise de sang, aucun rendez-vous.</p>
          </div>
        </div>
        <div class="step">
          <div class="step-num">2</div>
          <div>
            <h3>Votre programme sur mesure</h3>
            <p>Notre algorithme génère un plan alimentaire hebdomadaire complet avec des repas que vous adorez, calé sur vos besoins caloriques précis.</p>
          </div>
        </div>
        <div class="step">
          <div class="step-num">3</div>
          <div>
            <h3>Cuisinez et savourez</h3>
            <p>Accédez aux recettes détaillées avec liste de courses auto-générée. Chaque repas est pensé pour être rapide, bon et équilibré.</p>
          </div>
        </div>
        <div class="step">
          <div class="step-num">4</div>
          <div>
            <h3>Suivez vos progrès</h3>
            <p>Notez vos repas, pesez-vous, visualisez votre évolution. Votre programme s'adapte en temps réel à vos résultats.</p>
          </div>
        </div>
      </div>

      <div class="phone-mockup">
        <div class="phone-frame">
          <div class="phone-screen">
            <div class="phone-bar">
              <div class="phone-greeting">Bonjour Sophie 👋</div>
              <div class="phone-name">Votre journée du mardi</div>
            </div>
            <div class="phone-meals">
              <div class="phone-meal">
                <div class="meal-emoji">🥣</div>
                <div>
                  <div class="meal-info-label">Petit-déjeuner</div>
                  <div class="meal-info-cal">Yaourt granola fraises · 280 kcal</div>
                </div>
              </div>
              <div class="phone-meal">
                <div class="meal-emoji">🥗</div>
                <div>
                  <div class="meal-info-label">Déjeuner</div>
                  <div class="meal-info-cal">Salade niçoise légère · 380 kcal</div>
                </div>
              </div>
              <div class="phone-meal">
                <div class="meal-emoji">🍎</div>
                <div>
                  <div class="meal-info-label">Collation</div>
                  <div class="meal-info-cal">Pomme + amandes · 180 kcal</div>
                </div>
              </div>
              <div class="phone-meal">
                <div class="meal-emoji">🐟</div>
                <div>
                  <div class="meal-info-label">Dîner</div>
                  <div class="meal-info-cal">Saumon légumes vapeur · 420 kcal</div>
                </div>
              </div>
            </div>
            <div class="phone-progress">
              <div class="progress-label">
                <span>1 260 kcal consommées</span>
                <span>1 400 kcal objectif</span>
              </div>
              <div class="progress-bar">
                <div class="progress-fill"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="features" id="features">
  <div style="max-width: 1200px; margin: 0 auto;">
    <div class="section-tag">Fonctionnalités</div>
    <div class="section-title">Tout ce dont vous avez besoin<br><em>pour réussir.</em></div>
    <div class="features-grid" style="margin-top:3rem;">
      <div class="feature-card">
        <div class="feature-icon">🎯</div>
        <h3>Programme 100 % personnalisé</h3>
        <p>Chaque plan est calculé selon votre IMC, votre métabolisme, vos allergies et vos préférences. Aucun copier-coller.</p>
      </div>
      <div class="feature-card accent">
        <div class="feature-icon">🌿</div>
        <h3>1 200+ recettes santé</h3>
        <p>Des recettes simples, gourmandes, équilibrées. Notées par notre communauté, filtrées selon vos goûts du jour.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🛒</div>
        <h3>Liste de courses auto</h3>
        <p>Votre liste de courses générée automatiquement pour la semaine. Optimisée, groupée par rayon, sans gaspillage.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">📊</div>
        <h3>Suivi des macros</h3>
        <p>Calories, protéines, glucides, lipides : tout est tracké en temps réel sans que vous ayez à calculer quoi que ce soit.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">💬</div>
        <h3>Coach nutritionnel IA</h3>
        <p>Posez vos questions à votre coach virtuel 24h/24. Conseils, encouragements, adaptation du programme.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">📈</div>
        <h3>Courbe de progression</h3>
        <p>Visualisez votre évolution semaine par semaine. Restez motivée avec des jalons et des célébrations de vos victoires.</p>
      </div>
    </div>
  </div>
</section>

<!-- TÉMOIGNAGES -->
<section class="testimonials" id="testi">
  <div style="max-width: 1200px; margin: 0 auto;">
    <div class="section-tag">Témoignages</div>
    <div class="section-title">Elles ont transformé<br><em>leur rapport à l'alimentation.</em></div>
    <div class="testi-grid">
      <div class="testi-card">
        <div class="testi-quote">"</div>
        <p class="testi-text">Après des années de régimes yo-yo, Aliméa est la première méthode qui me convient vraiment. Je ne me prive pas, je mange mieux.</p>
        <div class="testi-author">
          <div class="avatar" style="background: var(--rose);">ML</div>
          <div>
            <div class="testi-name">Marie-Laure, 38 ans</div>
            <div class="testi-loss">−7 kg en 4 mois</div>
            <div class="testi-stars">★★★★★</div>
          </div>
        </div>
      </div>
      <div class="testi-card">
        <div class="testi-quote">"</div>
        <p class="testi-text">Les recettes sont délicieuses et rapides à faire. Ma famille mange les mêmes plats que moi. Un vrai gain de temps au quotidien.</p>
        <div class="testi-author">
          <div class="avatar" style="background: var(--rose-deep);">SB</div>
          <div>
            <div class="testi-name">Sophie B., 44 ans</div>
            <div class="testi-loss">−5,2 kg en 3 mois</div>
            <div class="testi-stars">★★★★★</div>
          </div>
        </div>
      </div>
      <div class="testi-card">
        <div class="testi-quote">"</div>
        <p class="testi-text">Le suivi de mes macros m'a ouvert les yeux. Je ne compte plus les calories obsessionnellement, je comprends ce que je mange.</p>
        <div class="testi-author">
          <div class="avatar" style="background: var(--green);">CA</div>
          <div>
            <div class="testi-name">Camille A., 29 ans</div>
            <div class="testi-loss">−9 kg en 5 mois</div>
            <div class="testi-stars">★★★★★</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PLANS -->
<section class="plans" id="plans">
  <div style="max-width: 1100px; margin: 0 auto;">
    <div class="plans-header">
      <div>
        <div class="section-tag">Tarifs</div>
        <div class="section-title">Investissez dans<br><em>votre bien-être.</em></div>
      </div>
      <p class="section-sub" style="max-width:300px; font-size:0.9rem;">Pas d'engagement. Annulez à tout moment. Essai gratuit 7 jours sur tous les plans.</p>
    </div>
    <div class="plans-grid">
      <div class="plan-card">
        <div class="plan-label">Démarrage</div>
        <div class="plan-name">Essentiel</div>
        <div class="plan-price">
          <span class="price-num">9€</span>
          <span class="price-period">/ mois</span>
        </div>
        <ul class="plan-features">
          <li><span class="check">✓</span> Programme hebdomadaire personnalisé</li>
          <li><span class="check">✓</span> Accès à 300 recettes</li>
          <li><span class="check">✓</span> Suivi des calories</li>
          <li><span class="check">✓</span> Liste de courses</li>
        </ul>
        <a href="#start" class="plan-btn plan-btn-outline">Essayer gratuitement</a>
      </div>

      <div class="plan-card featured">
        <div class="plan-label">Le plus populaire</div>
        <div class="plan-name">Premium</div>
        <div class="plan-price">
          <span class="price-num" style="color:white;">19€</span>
          <span class="price-period" style="color:rgba(255,255,255,0.6);">/ mois</span>
        </div>
        <ul class="plan-features">
          <li><span class="check">✓</span> Tout Essentiel inclus</li>
          <li><span class="check">✓</span> 1 200+ recettes complètes</li>
          <li><span class="check">✓</span> Suivi des macros détaillé</li>
          <li><span class="check">✓</span> Coach nutritionnel IA</li>
          <li><span class="check">✓</span> Adaptation en temps réel</li>
        </ul>
        <a href="#start" class="plan-btn plan-btn-white">Commencer maintenant</a>
      </div>

      <div class="plan-card">
        <div class="plan-label">Accompagnement total</div>
        <div class="plan-name">Coaching</div>
        <div class="plan-price">
          <span class="price-num">39€</span>
          <span class="price-period">/ mois</span>
        </div>
        <ul class="plan-features">
          <li><span class="check">✓</span> Tout Premium inclus</li>
          <li><span class="check">✓</span> Consultation diététicienne</li>
          <li><span class="check">✓</span> Coaching WhatsApp hebdo</li>
          <li><span class="check">✓</span> Bilan mensuel personnalisé</li>
        </ul>
        <a href="#start" class="plan-btn plan-btn-outline">Essayer gratuitement</a>
      </div>
    </div>
  </div>
</section>

<!-- CTA FINAL -->
<section class="cta-section" id="start">
  <h2>Prête à commencer<br>votre <em>transformation</em> ?</h2>
  <p>Rejoignez 32 000 femmes qui ont repris le contrôle de leur alimentation.<br>7 jours offerts, sans carte bancaire.</p>
  <div class="cta-form">
    <input type="email" class="cta-input" placeholder="Votre adresse e-mail...">
    <button class="cta-submit">Je démarre →</button>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-logo"><img src="/images/icons/logo.png" alt="" srcset=""></div>
  <ul class="footer-links">
    <li><a href="#">Confidentialité</a></li>
    <li><a href="#">CGV</a></li>
    <li><a href="#">Contact</a></li>
    <li><a href="#">Blog</a></li>
  </ul>
  <div class="footer-copy">© 2025 Aliméa — Tous droits réservés</div>
</footer>

<script>
  function checkMobile() {
    var mCta = document.querySelector('.nav-mobile-cta');
    if (mCta) mCta.style.display = window.innerWidth <= 768 ? 'inline-block' : 'none';
  }
  checkMobile();
  window.addEventListener('resize', checkMobile);
</script>
</body>
</html>