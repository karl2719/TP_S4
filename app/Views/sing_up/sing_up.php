<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- ============================================================
       TITRE DE L'ONGLET — modifier ici
  ============================================================ -->
  <title>Aliméa — Créer mon compte</title>

  <!-- ============================================================
       POLICES — chargées depuis Google Fonts
       Cormorant Garamond : titres élégants
       DM Sans           : texte courant
  ============================================================ -->
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />

  <style>
    /* ============================================================
       VARIABLES GLOBALES — palette de couleurs et rayons
       Modifier ici pour changer les couleurs sur tout le site
    ============================================================ */
    :root {
      --rose:        #E8849A;   /* rose principal */
      --rose-light:  #F7D0DA;   /* rose clair (bordures, fonds légers) */
      --rose-pale:   #FDF0F3;   /* rose très pâle (fonds de champs actifs) */
      --rose-deep:   #C45A74;   /* rose foncé (boutons, accents) */
      --rose-dark:   #8B3A52;   /* rose très foncé (hover boutons) */
      --cream:       #FAF7F4;   /* fond général crème */
      --sand:        #F0EAE2;   /* séparateurs, fonds secondaires */
      --text:        #2A1A20;   /* texte principal */
      --text-mid:    #7A5A64;   /* texte secondaire / labels */
      --text-light:  #B8959F;   /* placeholders, textes discrets */
      --green:       #8BAE7A;   /* succès / validation */
      --green-light: #E8F0E4;   /* fond badge succès */
      --error:       #D94F5A;   /* rouge erreur */
      --error-light: #FDECEA;   /* fond erreur */
      --radius-sm:   10px;
      --radius-md:   16px;
      --radius-lg:   24px;
      --radius-xl:   32px;
    }

    /* ============================================================
       RESET & BASE
    ============================================================ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--cream);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ============================================================
       BARRE DE NAVIGATION (haut de page)
       - Logo : modifier le texte "Aliméa" pour changer le nom
       - Lien retour : modifier href="#" vers l'URL de la landing page
    ============================================================ */
    nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1.1rem 2rem;
      background: rgba(250, 247, 244, 0.9);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid rgba(232, 132, 154, 0.15);
      position: sticky;
      top: 0;
      z-index: 50;
    }

    /* Logo Aliméa ── modifier le texte ici */
    .nav-logo {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.7rem;
      font-weight: 400;
      color: var(--rose-deep);
      letter-spacing: 0.02em;
      display: flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
    }
    .nav-logo .leaf {
      width: 20px; height: 20px;
      background: linear-gradient(135deg, var(--rose-deep), var(--rose));
      border-radius: 0 60% 0 60%;
      transform: rotate(-20deg);
      flex-shrink: 0;
    }

    /* Lien "Retour" ── modifier href vers votre page d'accueil */
    .nav-back {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 0.85rem;
      color: var(--text-mid);
      text-decoration: none;
      transition: color 0.2s;
    }
    .nav-back:hover { color: var(--rose-deep); }


    /* ============================================================
       ZONE PRINCIPALE (centrage du formulaire)
    ============================================================ */
    main {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2.5rem 1.2rem 4rem;
    }


    /* ============================================================
       EN-TÊTE DE LA PAGE (titre + sous-titre)
       - Modifier le texte h1 et p pour changer le message d'accueil
    ============================================================ */
    .page-header {
      text-align: center;
      margin-bottom: 2rem;
      max-width: 480px;
    }
    .page-header h1 {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(1.9rem, 4vw, 2.8rem);
      font-weight: 300;
      line-height: 1.2;
      color: var(--text);
      margin-bottom: 0.5rem;
    }
    .page-header h1 em {
      font-style: italic;
      color: var(--rose-deep);
    }
    .page-header p {
      font-size: 0.95rem;
      color: var(--text-mid);
      font-weight: 300;
      line-height: 1.6;
    }


    /* ============================================================
       INDICATEUR DE PROGRESSION (étape 1 / étape 2)
       Les cercles et textes sont mis à jour automatiquement par JS
    ============================================================ */
    .stepper {
      display: flex;
      align-items: center;
      gap: 0;
      margin-bottom: 2rem;
      width: 100%;
      max-width: 420px;
    }

    .step-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
      flex: 1;
      position: relative;
    }

    /* Ligne de connexion entre les deux étapes */
    .step-item:not(:last-child)::after {
      content: '';
      position: absolute;
      top: 18px;
      left: calc(50% + 18px);
      width: calc(100% - 36px);
      height: 2px;
      background: var(--rose-light);
      transition: background 0.4s;
      z-index: 0;
    }
    /* La ligne devient rose foncé quand l'étape 2 est active */
    .step-item.done::after { background: var(--rose-deep); }

    .step-circle {
      width: 36px; height: 36px;
      border-radius: 50%;
      border: 2px solid var(--rose-light);
      background: white;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.85rem;
      font-weight: 500;
      color: var(--text-light);
      z-index: 1;
      position: relative;
      transition: all 0.3s;
    }
    .step-item.active  .step-circle { border-color: var(--rose-deep); background: var(--rose-deep); color: white; }
    .step-item.done    .step-circle { border-color: var(--green); background: var(--green); color: white; }

    .step-label {
      font-size: 0.75rem;
      font-weight: 400;
      color: var(--text-light);
      text-align: center;
      transition: color 0.3s;
    }
    .step-item.active .step-label { color: var(--rose-deep); font-weight: 500; }
    .step-item.done   .step-label { color: var(--green); }


    /* ============================================================
       CARTE FORMULAIRE (conteneur blanc arrondi)
    ============================================================ */
    .form-card {
      background: white;
      border-radius: var(--radius-xl);
      box-shadow: 0 12px 48px rgba(180, 80, 100, 0.1), 0 2px 10px rgba(0,0,0,0.05);
      width: 100%;
      max-width: 480px;
      overflow: hidden;
    }

    /* Bandeau coloré en haut de la carte */
    .form-card-header {
      background: linear-gradient(135deg, var(--rose-pale), #fff8f0);
      padding: 1.6rem 2rem 1.4rem;
      border-bottom: 1px solid var(--rose-light);
    }
    .form-card-header .badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 0.72rem;
      font-weight: 500;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--rose-deep);
      background: var(--rose-pale);
      border: 1px solid var(--rose-light);
      padding: 0.3rem 0.8rem;
      border-radius: 50px;
      margin-bottom: 0.7rem;
    }
    .form-card-header h2 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.5rem;
      font-weight: 400;
      color: var(--text);
      margin-bottom: 0.2rem;
    }
    .form-card-header p {
      font-size: 0.82rem;
      color: var(--text-mid);
      font-weight: 300;
    }

    /* Corps du formulaire */
    .form-body {
      padding: 1.8rem 2rem 2rem;
    }


    /* ============================================================
       CHAMPS DE FORMULAIRE
       Structure commune : .field-group > label + input (ou select)
       Ajouter un nouveau champ : copier un .field-group et ajuster
    ============================================================ */
    .field-group {
      margin-bottom: 1.1rem;
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    /* Disposition côte-à-côte (ex : nom + prénom) */
    .field-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.8rem;
      margin-bottom: 1.1rem;
    }
    .field-row .field-group { margin-bottom: 0; }

    /* Label */
    label {
      font-size: 0.8rem;
      font-weight: 500;
      color: var(--text-mid);
      letter-spacing: 0.02em;
    }
    /* Astérisque rouge pour les champs obligatoires */
    label .req { color: var(--rose-deep); margin-left: 2px; }
    /* Texte "(optionnel)" discret */
    label .opt { color: var(--text-light); font-weight: 300; font-size: 0.75rem; margin-left: 4px; }

    /* Inputs & Selects */
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="date"],
    input[type="number"],
    select {
      width: 100%;
      padding: 0.7rem 0.95rem;
      border: 1.5px solid var(--rose-light);
      border-radius: var(--radius-sm);
      font-size: 0.9rem;
      font-family: 'DM Sans', sans-serif;
      color: var(--text);
      background: white;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
      appearance: none;
      -webkit-appearance: none;
    }
    input::placeholder { color: var(--text-light); font-weight: 300; }

    /* État focus */
    input:focus, select:focus {
      border-color: var(--rose-deep);
      background: var(--rose-pale);
      box-shadow: 0 0 0 3px rgba(196, 90, 116, 0.1);
    }

    /* État erreur (classe ajoutée par JS) */
    input.error, select.error {
      border-color: var(--error);
      background: var(--error-light);
    }
    .field-error {
      font-size: 0.75rem;
      color: var(--error);
      display: none; /* affiché par JS si erreur */
    }
    .field-error.visible { display: block; }

    /* Wrapper pour le select (flèche custom) */
    .select-wrapper {
      position: relative;
    }
    .select-wrapper select { padding-right: 2.2rem; cursor: pointer; }
    .select-wrapper::after {
      content: '▾';
      position: absolute;
      right: 0.85rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-light);
      pointer-events: none;
      font-size: 0.9rem;
    }

    /* Icône dans les inputs (ex: œil mot de passe) */
    .input-wrapper {
      position: relative;
    }
    .input-wrapper input { padding-right: 2.6rem; }
    .input-icon-btn {
      position: absolute;
      right: 0.7rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: var(--text-light);
      padding: 2px;
      line-height: 1;
      font-size: 1rem;
    }
    .input-icon-btn:hover { color: var(--rose-deep); }

    /* Barre de force du mot de passe */
    .pwd-strength {
      margin-top: 5px;
      display: flex;
      gap: 4px;
    }
    .pwd-bar {
      flex: 1;
      height: 3px;
      border-radius: 2px;
      background: var(--rose-light);
      transition: background 0.3s;
    }
    .pwd-bar.weak   { background: var(--error); }
    .pwd-bar.medium { background: #F5A623; }
    .pwd-bar.strong { background: var(--green); }

    /* Info-bulle sous un champ */
    .field-hint {
      font-size: 0.73rem;
      color: var(--text-light);
      line-height: 1.4;
    }


    /* ============================================================
       BOUTONS DE GENRE (radio stylés)
       Ajouter une option : copier un <label class="genre-option"> et
       changer la value et le texte emoji+label
    ============================================================ */
    .genre-group {
      display: flex;
      gap: 0.6rem;
    }
    .genre-option {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 0.6rem 0.5rem;
      border: 1.5px solid var(--rose-light);
      border-radius: var(--radius-sm);
      cursor: pointer;
      font-size: 0.82rem;
      font-weight: 400;
      color: var(--text-mid);
      transition: all 0.2s;
      user-select: none;
    }
    .genre-option:hover { border-color: var(--rose); background: var(--rose-pale); }
    .genre-option input[type="radio"] { display: none; } /* le vrai radio est caché */
    .genre-option.selected {
      border-color: var(--rose-deep);
      background: var(--rose-pale);
      color: var(--rose-deep);
      font-weight: 500;
    }


    /* ============================================================
       OBJECTIFS (radio stylés, étape 2)
       Ajouter une option : copier un .objectif-option et changer
       la value, l'emoji et les textes titre/sous-titre
    ============================================================ */
    .objectif-group {
      display: flex;
      flex-direction: column;
      gap: 0.7rem;
    }
    .objectif-option {
      display: flex;
      align-items: center;
      gap: 0.9rem;
      padding: 0.85rem 1rem;
      border: 1.5px solid var(--rose-light);
      border-radius: var(--radius-md);
      cursor: pointer;
      transition: all 0.2s;
    }
    .objectif-option:hover { border-color: var(--rose); background: var(--rose-pale); }
    .objectif-option input[type="radio"] { display: none; }
    .objectif-option.selected {
      border-color: var(--rose-deep);
      background: var(--rose-pale);
    }
    .objectif-emoji {
      font-size: 1.5rem;
      flex-shrink: 0;
      width: 40px;
      height: 40px;
      background: white;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.07);
    }
    .objectif-text { flex: 1; }
    .objectif-title { font-size: 0.88rem; font-weight: 500; color: var(--text); }
    .objectif-sub   { font-size: 0.75rem; color: var(--text-mid); font-weight: 300; }
    .objectif-check {
      width: 20px; height: 20px;
      border-radius: 50%;
      border: 2px solid var(--rose-light);
      flex-shrink: 0;
      display: flex; align-items: center; justify-content: center;
      transition: all 0.2s;
    }
    .objectif-option.selected .objectif-check {
      background: var(--rose-deep);
      border-color: var(--rose-deep);
    }
    .objectif-option.selected .objectif-check::after {
      content: '✓';
      font-size: 0.65rem;
      color: white;
    }


    /* ============================================================
       ENCADRÉ "OPTIONNEL" (étape 2)
    ============================================================ */
    .optional-banner {
      background: var(--green-light);
      border: 1px solid #b8d9a8;
      border-radius: var(--radius-md);
      padding: 0.85rem 1rem;
      display: flex;
      align-items: flex-start;
      gap: 0.7rem;
      margin-bottom: 1.4rem;
    }
    .optional-banner .icon { font-size: 1.2rem; flex-shrink: 0; }
    .optional-banner p { font-size: 0.8rem; color: #3a6428; line-height: 1.5; font-weight: 300; }
    .optional-banner strong { font-weight: 500; }


    /* ============================================================
       SÉPARATEUR ENTRE SECTIONS DU FORMULAIRE
    ============================================================ */
    .form-divider {
      border: none;
      border-top: 1px solid var(--sand);
      margin: 1.4rem 0;
    }
    .form-section-label {
      font-size: 0.72rem;
      font-weight: 500;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--text-light);
      margin-bottom: 0.9rem;
    }


    /* ============================================================
       CHECKBOXES (CGV, newsletter, etc.)
       Ajouter une case : copier un .checkbox-row et modifier le texte
    ============================================================ */
    .checkbox-row {
      display: flex;
      align-items: flex-start;
      gap: 0.7rem;
      margin-bottom: 0.8rem;
    }
    .checkbox-row input[type="checkbox"] {
      width: 18px; height: 18px;
      min-width: 18px;
      border: 1.5px solid var(--rose-light);
      border-radius: 5px;
      cursor: pointer;
      appearance: none;
      -webkit-appearance: none;
      background: white;
      margin-top: 1px;
      transition: all 0.2s;
    }
    .checkbox-row input[type="checkbox"]:checked {
      background: var(--rose-deep);
      border-color: var(--rose-deep);
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M3 8l3.5 3.5L13 4.5' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
      background-size: 12px;
      background-repeat: no-repeat;
      background-position: center;
    }
    .checkbox-label {
      font-size: 0.82rem;
      color: var(--text-mid);
      line-height: 1.5;
      font-weight: 300;
    }
    /* Liens dans les checkboxes ── modifier href vers vos pages légales */
    .checkbox-label a {
      color: var(--rose-deep);
      text-decoration: underline;
    }


    /* ============================================================
       BOUTONS D'ACTION
       - .btn-primary  : bouton principal (soumettre / continuer)
       - .btn-secondary: bouton secondaire (retour)
    ============================================================ */
    .form-actions {
      display: flex;
      flex-direction: column;
      gap: 0.7rem;
      margin-top: 1.6rem;
    }

    .btn-primary {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      padding: 0.9rem 1.6rem;
      background: var(--rose-deep);
      color: white;
      border: none;
      border-radius: 50px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.95rem;
      font-weight: 500;
      cursor: pointer;
      letter-spacing: 0.02em;
      box-shadow: 0 4px 18px rgba(196, 90, 116, 0.35);
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    }
    .btn-primary:hover {
      background: var(--rose-dark);
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(196, 90, 116, 0.4);
    }
    .btn-primary:active { transform: translateY(0); }

    .btn-secondary {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      width: 100%;
      padding: 0.75rem 1.6rem;
      background: transparent;
      color: var(--text-mid);
      border: 1.5px solid var(--rose-light);
      border-radius: 50px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.9rem;
      font-weight: 400;
      cursor: pointer;
      transition: all 0.2s;
    }
    .btn-secondary:hover { border-color: var(--rose); color: var(--rose-deep); background: var(--rose-pale); }

    /* Lien "passer cette étape" sous les boutons */
    .skip-link {
      text-align: center;
      font-size: 0.8rem;
      color: var(--text-light);
    }
    /* Modifier href vers la page de destination après inscription */
    .skip-link a {
      color: var(--text-mid);
      text-decoration: underline;
      cursor: pointer;
    }
    .skip-link a:hover { color: var(--rose-deep); }


    /* ============================================================
       FOOTER FORMULAIRE (lien connexion)
       - Modifier href vers votre page de connexion
    ============================================================ */
    .form-footer-note {
      margin-top: 1.4rem;
      text-align: center;
      font-size: 0.82rem;
      color: var(--text-mid);
    }
    .form-footer-note a {
      color: var(--rose-deep);
      font-weight: 500;
      text-decoration: none;
    }
    .form-footer-note a:hover { text-decoration: underline; }


    /* ============================================================
       PAGE DE SUCCÈS (affichée après l'étape 2)
    ============================================================ */
    .success-card {
      background: white;
      border-radius: var(--radius-xl);
      box-shadow: 0 12px 48px rgba(180, 80, 100, 0.1);
      width: 100%;
      max-width: 480px;
      padding: 3rem 2rem;
      text-align: center;
      display: none; /* affiché par JS */
      animation: fadeUp 0.5s ease forwards;
    }
    .success-icon {
      width: 72px; height: 72px;
      background: var(--green-light);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 2rem;
      margin: 0 auto 1.4rem;
    }
    .success-card h2 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2rem;
      font-weight: 300;
      color: var(--text);
      margin-bottom: 0.6rem;
    }
    .success-card h2 em { font-style: italic; color: var(--rose-deep); }
    .success-card p {
      font-size: 0.9rem;
      color: var(--text-mid);
      font-weight: 300;
      line-height: 1.6;
      margin-bottom: 2rem;
    }

    /* ============================================================
       ANIMATIONS
    ============================================================ */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to   { opacity: 1; }
    }
    .animate-in { animation: fadeUp 0.35s ease forwards; }


    /* ============================================================
       RESPONSIVE MOBILE (≤ 520px)
    ============================================================ */
    @media (max-width: 520px) {
      nav { padding: 0.9rem 1.2rem; }
      main { padding: 1.8rem 0.8rem 3rem; }

      .form-card-header { padding: 1.3rem 1.3rem 1.1rem; }
      .form-body        { padding: 1.4rem 1.3rem 1.6rem; }

      /* Nom + prénom passent en colonne sur très petit écran */
      .field-row { grid-template-columns: 1fr; }

      .page-header h1 { font-size: 1.8rem; }
    }
  </style>
</head>
<body>

  <!-- ============================================================
       NAVIGATION (logo + lien retour)
       ↳ Modifier href du .nav-back vers votre landing page
  ============================================================ -->
  <nav>
    <a href="alimea-landing.html" class="nav-logo">
      <div class="leaf"></div>
      Aliméa
    </a>
    <!-- LIEN RETOUR ── modifier href vers votre page d'accueil -->
    <a href="alimea-landing.html" class="nav-back">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
        <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      Retour à l'accueil
    </a>
  </nav>


  <!-- ============================================================
       CONTENU PRINCIPAL
  ============================================================ -->
  <main>

    <!-- EN-TÊTE PAGE ── modifier le titre et sous-titre ici -->
    <div class="page-header">
      <h1>Rejoignez <em>Aliméa</em></h1>
      <p>Créez votre compte gratuit et commencez votre transformation dès aujourd'hui.</p>
    </div>

    <!-- INDICATEUR D'ÉTAPES -->
    <div class="stepper" id="stepper">

      <!-- Étape 1 ── modifier le label si besoin -->
      <div class="step-item active" id="step-indicator-1">
        <div class="step-circle">1</div>
        <span class="step-label">Mon compte</span>
      </div>

      <!-- Étape 2 ── modifier le label si besoin -->
      <div class="step-item" id="step-indicator-2">
        <div class="step-circle">2</div>
        <span class="step-label">Mon profil</span>
      </div>

    </div>


    <!-- ============================================================
         ██████████████████████████████████████████████████████████
         ÉTAPE 1 — CRÉATION DE COMPTE (champs obligatoires)
         Correspond à la table SQL : id, nom, prenom, email,
                                     password, genre, date_naissance
         ██████████████████████████████████████████████████████████
         Pour ajouter un champ : copier un .field-group et ajuster
         Pour changer l'action du formulaire : modifier action=""
         et method="" sur la balise <form>
    ============================================================ -->
    <div class="form-card animate-in" id="form-step-1">

      <!-- En-tête carte étape 1 ── modifier badge, titre, sous-titre -->
      <div class="form-card-header">
        <div class="badge">✦ Étape 1 sur 2</div>
        <h2>Créer mon compte</h2>
        <p>Informations nécessaires à la création de votre espace personnel.</p>
      </div>

      <div class="form-body">

        <!--
          ACTION DU FORMULAIRE (étape 1)
          ↳ Si vous soumettez via AJAX : gardez action="" et gérez en JS
          ↳ Si vous soumettez vers un serveur PHP/autre :
              modifier action="votre-script.php" method="POST"
        -->
        <form id="formulaire-etape-1" action="" method="POST" novalidate>

          <!-- ── NOM & PRÉNOM (côte à côte) ─────────────────────
               Colonne DB : nom VARCHAR(80), prenom VARCHAR(80)
               Modifier maxlength si votre DB a une autre limite
          ────────────────────────────────────────────────────── -->
          <div class="field-row">

            <div class="field-group">
              <label for="prenom">Prénom <span class="req">*</span></label>
              <!-- name= doit correspondre au nom de colonne DB -->
              <!-- limite VARCHAR(80) -->
              <input
                type="text"
                id="prenom"
                name="prenom"
                placeholder="Sophie"
                maxlength="80"
                autocomplete="given-name"
                required
              />
              <!-- Message d'erreur ── modifier le texte si besoin -->
              <span class="field-error" id="err-prenom">Veuillez saisir votre prénom.</span>
            </div>

            <div class="field-group">
              <label for="nom">Nom <span class="req">*</span></label>
              <input
                type="text"
                id="nom"
                name="nom"
                placeholder="Dupont"
                maxlength="80"
                autocomplete="family-name"
                required
              />
              <span class="field-error" id="err-nom">Veuillez saisir votre nom.</span>
            </div>

          </div>
          <!-- FIN nom & prénom -->


          <!-- ── EMAIL ──────────────────────────────────────────
               Colonne DB : email VARCHAR(150) UNIQUE
          ────────────────────────────────────────────────────── -->
          <div class="field-group">
            <label for="email">Adresse e-mail <span class="req">*</span></label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="sophie.dupont@email.com"
              maxlength="150"
              autocomplete="email"
              required
            />
            <span class="field-error" id="err-email">Veuillez saisir un e-mail valide.</span>
          </div>
          <!-- FIN email -->


          <!-- ── MOT DE PASSE ────────────────────────────────────
               Colonne DB : password VARCHAR(255) (stocké hashé)
               La valeur saisie doit être hashée côté serveur (bcrypt)
               avant d'être insérée en base de données.
          ────────────────────────────────────────────────────── -->
          <div class="field-group">
            <label for="password">Mot de passe <span class="req">*</span></label>
            <div class="input-wrapper">
              <input
                type="password"
                id="password"
                name="password"
                placeholder="Votre mot de passe"
                autocomplete="new-password"
                required
              />
              <!-- Bouton œil pour afficher/masquer le mot de passe -->
              <button type="button" class="input-icon-btn" id="toggle-pwd" aria-label="Afficher le mot de passe">
                👁
              </button>
            </div>
            <span class="field-error" id="err-password">Veuillez saisir un mot de passe.</span>
          </div>
          <!-- FIN mot de passe -->


          <hr class="form-divider" />


          <!-- ── GENRE ───────────────────────────────────────────
               Colonne DB : genre ENUM('homme','femme','autre')
               Pour ajouter une option : copier un .genre-option
               et changer value et le texte
          ────────────────────────────────────────────────────── -->
          <div class="field-group">
            <label>Genre <span class="req">*</span></label>
            <div class="genre-group" id="genre-group">

              <!-- Option Femme ── modifier value et texte si besoin -->
              <label class="genre-option" data-value="femme">
                <input type="radio" name="genre" value="femme" required />
                👩 Femme
              </label>

              <!-- Option Homme -->
              <label class="genre-option" data-value="homme">
                <input type="radio" name="genre" value="homme" />
                👨 Homme
              </label>

              <!-- Option Autre -->
              <label class="genre-option" data-value="autre">
                <input type="radio" name="genre" value="autre" />
                ✦ Autre
              </label>

            </div>
            <span class="field-error" id="err-genre">Veuillez sélectionner votre genre.</span>
          </div>
          <!-- FIN genre -->


          <!-- ── DATE DE NAISSANCE ───────────────────────────────
               Colonne DB : date_naissance DATE NULL
               Retirez "required" pour le rendre facultatif
               Ajustez min/max selon l'âge minimal de votre service
          ────────────────────────────────────────────────────── -->
          <div class="field-group">
            <label for="date_naissance">
              Date de naissance <span class="req">*</span>
            </label>
            <!-- âge maximum accepté -->
            <!-- âge minimum : 14 ans environ ── modifier selon votre politique -->
            <input
              type="date"
              id="date_naissance"
              name="date_naissance"
              min="1920-01-01"
              max="2010-01-01"
              required
            />
            <span class="field-error" id="err-dob">Veuillez saisir votre date de naissance.</span>
          </div>
          <!-- FIN date de naissance -->


          <hr class="form-divider" />


          <!-- ── CASES À COCHER LÉGALES ─────────────────────────
               Ajouter une case : copier un .checkbox-row
               Modifier les href vers vos pages CGV / confidentialité
          ────────────────────────────────────────────────────── -->

          <!-- CGV + Politique de confidentialité (obligatoire) -->
          <div class="checkbox-row">
            <input type="checkbox" id="cgv" name="cgv" required />
            <span class="checkbox-label">
              J'accepte les
              <!-- ↓ modifier href vers votre page CGV -->
              <a href="/cgv" target="_blank">Conditions Générales</a>
              et la
              <!-- ↓ modifier href vers votre politique de confidentialité -->
              <a href="/confidentialite" target="_blank">Politique de confidentialité</a>.
              <span class="req">*</span>
            </span>
          </div>
          <span class="field-error" id="err-cgv" style="margin-top:-0.5rem; margin-bottom:0.5rem;">Vous devez accepter les conditions.</span>

          <!-- Newsletter (facultatif) ── supprimer si inutile -->
          <div class="checkbox-row">
            <input type="checkbox" id="newsletter" name="newsletter" value="1" />
            <span class="checkbox-label">
              Je souhaite recevoir les conseils nutritionnels et offres d'Aliméa par e-mail.
              <span class="opt">(facultatif)</span>
            </span>
          </div>

          <!-- ── BOUTON CONTINUER (étape 1 → 2) ────────────────
               Ce bouton déclenche la validation JS et affiche l'étape 2
               Pour soumettre directement à un serveur : changer type="submit"
               et ajouter l'action sur le <form>
          ────────────────────────────────────────────────────── -->
          <div class="form-actions">
            <button type="button" id="btn-next" class="btn-primary">
              Continuer
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M6 3l5 5-5 5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>

        </form>
        <!-- FIN formulaire étape 1 -->

        <!-- Lien vers la page de connexion ── modifier href -->
        <div class="form-footer-note">
          Déjà un compte ?
          <!-- ↓ modifier href vers votre page de connexion -->
          <a href="/connexion">Se connecter</a>
        </div>

      </div>
    </div>
    <!-- FIN CARTE ÉTAPE 1 -->


    <!-- ============================================================
         ██████████████████████████████████████████████████████████
         ÉTAPE 2 — PROFIL NUTRITIONNEL (champs recommandés)
         Correspond à la table SQL : taille_cm, poids_kg, objectif
         Cette étape est FACULTATIVE mais recommandée.
         Masquée par défaut — affichée par JS après validation étape 1
         ██████████████████████████████████████████████████████████
    ============================================================ -->
    <div class="form-card animate-in" id="form-step-2" style="display:none;">

      <!-- En-tête carte étape 2 ── modifier badge, titre, sous-titre -->
      <div class="form-card-header">
        <div class="badge">✦ Étape 2 sur 2</div>
        <h2>Mon profil nutrition</h2>
        <p>Ces données permettent de personnaliser votre programme alimentaire.</p>
      </div>

      <div class="form-body">

        <!-- Bandeau "optionnel" ── modifier ou supprimer ce message -->
        <div class="optional-banner">
          <span class="icon">🌿</span>
          <p>
            <strong>Cette étape est facultative</strong> mais vivement recommandée.
            Ces informations permettent de calculer votre programme sur mesure. Vous pouvez les modifier à tout moment depuis votre profil.
          </p>
        </div>

        <!--
          ACTION DU FORMULAIRE (étape 2)
          ↳ Même logique que l'étape 1 — modifier action/method selon votre backend
        -->
        <form id="formulaire-etape-2" action="" method="POST" novalidate>

          <!-- Section mesures corporelles -->
          <div class="form-section-label">Vos mesures</div>

          <!-- ── TAILLE ──────────────────────────────────────────
               Colonne DB : taille_cm DECIMAL(5,1)
               Unité : centimètres (ex: 165.0)
               Modifier min/max selon les valeurs acceptées par votre DB
          ────────────────────────────────────────────────────── -->
          <div class="field-row">

            <div class="field-group">
              <label for="taille_cm">
                Taille <span class="opt">(cm)</span>
              </label>
              <!-- taille minimale acceptée en cm -->
              <!-- taille maximale acceptée en cm -->
              <!-- précision DECIMAL(5,1) -->
              <input
                type="number"
                id="taille_cm"
                name="taille_cm"
                placeholder="165"
                min="100"
                max="250"
                step="0.1"
              />
              <span class="field-error" id="err-taille">Taille invalide (100–250 cm).</span>
            </div>


            <!-- ── POIDS ────────────────────────────────────────
                 Colonne DB : poids_kg DECIMAL(5,2)
                 Unité : kilogrammes (ex: 62.50)
            ────────────────────────────────────────────────────── -->
            <div class="field-group">
              <label for="poids_kg">
                Poids <span class="opt">(kg)</span>
              </label>
              <!-- poids minimal en kg -->
              <!-- poids maximal en kg -->
              <!-- précision DECIMAL(5,2) -->
              <input
                type="number"
                id="poids_kg"
                name="poids_kg"
                placeholder="62"
                min="30"
                max="300"
                step="0.01"
              />
              <span class="field-error" id="err-poids">Poids invalide (30–300 kg).</span>
            </div>

          </div>
          <!-- FIN taille & poids -->


          <hr class="form-divider" />


          <!-- ── OBJECTIF ────────────────────────────────────────
               Colonne DB : objectif ENUM('augmenter_poids','reduire_poids','imc_ideal')
               Pour ajouter une option : copier un .objectif-option
               et changer value, emoji, titre, sous-titre
               ⚠ La value doit correspondre EXACTEMENT aux valeurs ENUM de votre DB
          ────────────────────────────────────────────────────── -->
          <div class="field-group">
            <div class="form-section-label">Votre objectif principal</div>

            <div class="objectif-group" id="objectif-group">

              <!-- Option 1 : Perdre du poids ── modifier value si besoin -->
              <label class="objectif-option" data-value="reduire_poids">
                <input type="radio" name="objectif" value="reduire_poids" />
                <div class="objectif-emoji">🏃‍♀️</div>
                <div class="objectif-text">
                  <!-- Modifier le titre et le sous-titre ici -->
                  <div class="objectif-title">Perdre du poids</div>
                  <div class="objectif-sub">Programme déficit calorique personnalisé</div>
                </div>
                <div class="objectif-check"></div>
              </label>

              <!-- Option 2 : Atteindre l'IMC idéal -->
              <label class="objectif-option" data-value="imc_ideal">
                <input type="radio" name="objectif" value="imc_ideal" />
                <div class="objectif-emoji">⚖️</div>
                <div class="objectif-text">
                  <div class="objectif-title">Atteindre mon IMC idéal</div>
                  <div class="objectif-sub">Équilibre et bien-être durable</div>
                </div>
                <div class="objectif-check"></div>
              </label>

              <!-- Option 3 : Prendre du poids / masse -->
              <label class="objectif-option" data-value="augmenter_poids">
                <input type="radio" name="objectif" value="augmenter_poids" />
                <div class="objectif-emoji">💪</div>
                <div class="objectif-text">
                  <div class="objectif-title">Prendre du poids / masse</div>
                  <div class="objectif-sub">Programme surplus calorique sain</div>
                </div>
                <div class="objectif-check"></div>
              </label>

            </div>
            <span class="field-error" id="err-objectif">Veuillez sélectionner votre objectif.</span>
          </div>
          <!-- FIN objectif -->


          <!-- ── BOUTONS ÉTAPE 2 ─────────────────────────────────
               btn-submit  : soumet le formulaire final
               btn-back    : retour à l'étape 1
               .skip-link  : passer cette étape (va directement au dashboard)
                             ↓ modifier href du lien "passer"
          ────────────────────────────────────────────────────── -->
          <div class="form-actions">

            <!-- Bouton principal : finaliser l'inscription -->
            <button type="button" id="btn-submit" class="btn-primary">
              Créer mon programme ✦
            </button>

            <!-- Bouton retour : revenir à l'étape 1 -->
            <button type="button" id="btn-back" class="btn-secondary">
              <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Retour
            </button>

          </div>

          <!-- Lien "passer cette étape" ── modifier href vers votre dashboard -->
          <div class="skip-link">
            <a href="/dashboard" id="skip-step2">Passer cette étape pour l'instant</a>
          </div>

        </form>
        <!-- FIN formulaire étape 2 -->

      </div>
    </div>
    <!-- FIN CARTE ÉTAPE 2 -->


    <!-- ============================================================
         PAGE DE SUCCÈS — affichée après soumission de l'étape 2
         Modifier le titre, message et le lien du bouton
    ============================================================ -->
    <div class="success-card" id="success-card">
      <div class="success-icon">🎉</div>

      <!-- Modifier le titre de confirmation -->
      <h2>Bienvenue sur <em>Aliméa</em> !</h2>

      <!-- Modifier le message de confirmation -->
      <p>
        Votre compte a été créé avec succès.<br />
        Votre programme personnalisé est en cours de génération.
      </p>

      <!-- Bouton vers le tableau de bord ── modifier href -->
      <a href="/dashboard" class="btn-primary" style="max-width:280px; margin:0 auto; text-decoration:none;">
        Accéder à mon espace
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
          <path d="M6 3l5 5-5 5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </div>
    <!-- FIN succès -->

  </main>


  <!-- ============================================================
       JAVASCRIPT — LOGIQUE DES FORMULAIRES
       Toute la logique de navigation entre étapes, validation
       et interactions UX est ici.
       NE PAS modifier sauf si vous savez ce que vous faites.
       Les zones modifiables sont clairement indiquées.
  ============================================================ -->
  <script>

    /* ── RÉFÉRENCES AUX ÉLÉMENTS DOM ──────────────────────────── */
    const step1Card       = document.getElementById('form-step-1');
    const step2Card       = document.getElementById('form-step-2');
    const successCard     = document.getElementById('success-card');
    const stepInd1        = document.getElementById('step-indicator-1');
    const stepInd2        = document.getElementById('step-indicator-2');
    const btnNext         = document.getElementById('btn-next');
    const btnBack         = document.getElementById('btn-back');
    const btnSubmit       = document.getElementById('btn-submit');
    const skipStep2       = document.getElementById('skip-step2');


    /* ── UTILITAIRES ───────────────────────────────────────────── */

    /** Affiche ou cache un message d'erreur sous un champ */
    function setError(inputEl, errorId, show) {
      const errEl = document.getElementById(errorId);
      if (!errEl) return;
      if (show) {
        inputEl && inputEl.classList.add('error');
        errEl.classList.add('visible');
      } else {
        inputEl && inputEl.classList.remove('error');
        errEl.classList.remove('visible');
      }
    }

    /** Vérifie qu'un champ texte n'est pas vide */
    function notEmpty(val) { return val.trim().length > 0; }

    /** Vérifie le format e-mail (basique) */
    function isEmail(val) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val); }


    /* ── BOUTONS AFFICHER/MASQUER MOT DE PASSE ─────────────────── */

    document.getElementById('toggle-pwd').addEventListener('click', function() {
      const pwdField = document.getElementById('password');
      pwdField.type = pwdField.type === 'password' ? 'text' : 'password';
      this.textContent = pwdField.type === 'password' ? '👁' : '🙈';
    });

    /* ── SÉLECTION DU GENRE (radio stylé) ──────────────────────── */

    document.querySelectorAll('#genre-group .genre-option').forEach(function(label) {
      label.addEventListener('click', function() {
        // Retirer "selected" de toutes les options
        document.querySelectorAll('#genre-group .genre-option').forEach(l => l.classList.remove('selected'));
        // Activer l'option cliquée
        this.classList.add('selected');
        this.querySelector('input[type="radio"]').checked = true;
        setError(null, 'err-genre', false);
      });
    });


    /* ── SÉLECTION DE L'OBJECTIF (radio stylé) ─────────────────── */

    document.querySelectorAll('#objectif-group .objectif-option').forEach(function(label) {
      label.addEventListener('click', function() {
        document.querySelectorAll('#objectif-group .objectif-option').forEach(l => l.classList.remove('selected'));
        this.classList.add('selected');
        this.querySelector('input[type="radio"]').checked = true;
        setError(null, 'err-objectif', false);
      });
    });


    /* ── VALIDATION ÉTAPE 1 ─────────────────────────────────────── */
    /*
     * Règles de validation — modifier ici pour ajuster les règles
     * Chaque règle : [valeur, id_erreur, condition_d'erreur]
     */
    function validateStep1() {
      let valid = true;

      const prenom  = document.getElementById('prenom').value;
      const nom     = document.getElementById('nom').value;
      const email   = document.getElementById('email').value;
      const pwd     = document.getElementById('password').value;
      const dob     = document.getElementById('date_naissance').value;
      const genre   = document.querySelector('input[name="genre"]:checked');
      const cgv     = document.getElementById('cgv').checked;

      /* Validation prénom */
      if (!notEmpty(prenom)) {
        setError(document.getElementById('prenom'), 'err-prenom', true);
        valid = false;
      } else { setError(document.getElementById('prenom'), 'err-prenom', false); }

      /* Validation nom */
      if (!notEmpty(nom)) {
        setError(document.getElementById('nom'), 'err-nom', true);
        valid = false;
      } else { setError(document.getElementById('nom'), 'err-nom', false); }

      /* Validation email */
      if (!isEmail(email)) {
        setError(document.getElementById('email'), 'err-email', true);
        valid = false;
      } else { setError(document.getElementById('email'), 'err-email', false); }

      /* Validation mot de passe (obligatoire) */
      if (!notEmpty(pwd)) {
        setError(document.getElementById('password'), 'err-password', true);
        valid = false;
      } else { setError(document.getElementById('password'), 'err-password', false); }

      /* Validation genre */
      if (!genre) {
        setError(null, 'err-genre', true);
        valid = false;
      } else { setError(null, 'err-genre', false); }

      /* Validation date de naissance */
      if (!dob) {
        setError(document.getElementById('date_naissance'), 'err-dob', true);
        valid = false;
      } else { setError(document.getElementById('date_naissance'), 'err-dob', false); }

      /* Validation CGV */
      if (!cgv) {
        setError(null, 'err-cgv', true);
        valid = false;
      } else { setError(null, 'err-cgv', false); }

      return valid;
    }


    /* ── PASSER À L'ÉTAPE 2 ─────────────────────────────────────── */

    btnNext.addEventListener('click', function() {

      if (!validateStep1()) return; // stopper si erreurs

      /* Masquer étape 1, afficher étape 2 */
      step1Card.style.display = 'none';
      step2Card.style.display = 'block';
      step2Card.classList.remove('animate-in');
      void step2Card.offsetWidth; // forcer reflow pour relancer animation
      step2Card.classList.add('animate-in');

      /* Mettre à jour l'indicateur de progression */
      stepInd1.classList.remove('active');
      stepInd1.classList.add('done');
      stepInd1.querySelector('.step-circle').textContent = '✓';
      stepInd2.classList.add('active');

      /* Remonter en haut */
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });


    /* ── RETOUR À L'ÉTAPE 1 ─────────────────────────────────────── */

    btnBack.addEventListener('click', function() {
      step2Card.style.display = 'none';
      step1Card.style.display = 'block';
      step1Card.classList.remove('animate-in');
      void step1Card.offsetWidth;
      step1Card.classList.add('animate-in');

      /* Rétablir l'indicateur */
      stepInd1.classList.add('active');
      stepInd1.classList.remove('done');
      stepInd1.querySelector('.step-circle').textContent = '1';
      stepInd2.classList.remove('active');

      window.scrollTo({ top: 0, behavior: 'smooth' });
    });


    /* ── VALIDATION ÉTAPE 2 (optionnelle mais si remplie, validée) ─ */

    function validateStep2() {
      let valid = true;

      const taille  = document.getElementById('taille_cm').value;
      const poids   = document.getElementById('poids_kg').value;
      const objectif = document.querySelector('input[name="objectif"]:checked');

      /* Si taille est renseignée, vérifier la plage */
      if (taille && (parseFloat(taille) < 100 || parseFloat(taille) > 250)) {
        setError(document.getElementById('taille_cm'), 'err-taille', true);
        valid = false;
      } else { setError(document.getElementById('taille_cm'), 'err-taille', false); }

      /* Si poids est renseigné, vérifier la plage */
      if (poids && (parseFloat(poids) < 30 || parseFloat(poids) > 300)) {
        setError(document.getElementById('poids_kg'), 'err-poids', true);
        valid = false;
      } else { setError(document.getElementById('poids_kg'), 'err-poids', false); }

      /*
       * Objectif requis si taille ou poids est renseigné
       * (logique métier — modifier si besoin)
       */
      if ((taille || poids) && !objectif) {
        setError(null, 'err-objectif', true);
        valid = false;
      } else { setError(null, 'err-objectif', false); }

      return valid;
    }


    /* ── SOUMISSION FINALE (étape 2) ────────────────────────────── */
    /*
     * C'est ici que vous envoyez les données au serveur.
     * Actuellement : simulation avec délai (remplacer par fetch/AJAX)
     *
     * ↓ ZONE À MODIFIER POUR CONNECTER VOTRE BACKEND ↓
     */
    btnSubmit.addEventListener('click', function() {

      if (!validateStep2()) return;

      /* Désactiver le bouton pendant l'envoi */
      this.disabled = true;
      this.textContent = 'Création en cours…';

      /*
       * ────────────────────────────────────────────────────────────
       * REMPLACER CE BLOC PAR VOTRE APPEL SERVEUR (fetch / axios)
       * Exemple avec fetch :
       *
       *   const formData = new FormData(document.getElementById('formulaire-etape-2'));
       *   // Ajouter les champs de l'étape 1 si nécessaire
       *
       *   fetch('/api/inscription', { method: 'POST', body: formData })
       *     .then(res => res.json())
       *     .then(data => { showSuccess(); })
       *     .catch(err => { console.error(err); });
       *
       * ────────────────────────────────────────────────────────────
       */
      setTimeout(function() {
        showSuccess();
      }, 1200); /* ← Simuler un appel réseau de 1.2s (supprimer en prod) */

    });


    /* ── PASSER L'ÉTAPE 2 ───────────────────────────────────────── */
    /*
     * Si l'utilisateur clique "Passer cette étape"
     * ↓ Modifier la redirection ici (ou utiliser window.location.href)
     */
    skipStep2.addEventListener('click', function(e) {
      e.preventDefault();
      /* Simulation : afficher le succès sans profil nutritionnel */
      showSuccess();
      /* En production, remplacer par :
         window.location.href = '/dashboard'; */
    });


    /* ── AFFICHER LA PAGE DE SUCCÈS ─────────────────────────────── */

    function showSuccess() {
      step2Card.style.display  = 'none';
      step1Card.style.display  = 'none';

      successCard.style.display = 'flex';
      successCard.style.flexDirection = 'column';
      successCard.style.alignItems = 'center';

      /* Mettre à jour le stepper (tout validé) */
      stepInd2.classList.remove('active');
      stepInd2.classList.add('done');
      stepInd2.querySelector('.step-circle').textContent = '✓';

      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

  </script>
  <!-- FIN JAVASCRIPT -->

</body>
</html>