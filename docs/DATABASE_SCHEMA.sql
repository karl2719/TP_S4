    -- ============================================================
    --  PROJET S4 — SCRIPT SQL COMPLET
    --  Base : diet_app
    --  SGBD : MySQL 8+ (compatible MariaDB)
    --  Auteur : Généré pour le projet S4
    -- ============================================================

    CREATE DATABASE IF NOT EXISTS diet_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    USE diet_app;

    -- ============================================================
    -- TABLE : objectifs
    -- Les 3 objectifs possibles pour un utilisateur
    -- ============================================================
    CREATE TABLE objectifs (
        id      INT AUTO_INCREMENT PRIMARY KEY,
        code    VARCHAR(30) NOT NULL UNIQUE,   -- 'augmenter_poids' | 'reduire_poids' | 'imc_ideal'
        libelle VARCHAR(100) NOT NULL
    ) ENGINE=InnoDB;

    INSERT INTO objectifs (code, libelle) VALUES
    ('augmenter_poids', 'Augmenter mon poids'),
    ('reduire_poids',   'Réduire mon poids'),
    ('imc_ideal',       'Atteindre mon IMC idéal');

    -- ============================================================
    -- TABLE : users
    -- Comptes des utilisateurs du Front Office
    -- ============================================================
    CREATE TABLE users (
        id            INT AUTO_INCREMENT PRIMARY KEY,
        nom           VARCHAR(100) NOT NULL,
        prenom        VARCHAR(100) NOT NULL,
        email         VARCHAR(150) NOT NULL UNIQUE,
        password      VARCHAR(255) NOT NULL,        -- bcrypt hash
        genre         ENUM('M','F') NOT NULL,
        taille        DECIMAL(5,2) NOT NULL,        -- en cm (ex: 175.00)
        poids         DECIMAL(5,2) NOT NULL,        -- en kg (ex: 70.00)
        objectif_id   INT NOT NULL,
        option_gold   TINYINT(1) NOT NULL DEFAULT 0,
        solde_wallet  DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at    DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (objectif_id) REFERENCES objectifs(id)
    ) ENGINE=InnoDB;

    -- ============================================================
    -- TABLE : admins
    -- Comptes administrateurs Back Office
    -- ============================================================
    CREATE TABLE admins (
        id         INT AUTO_INCREMENT PRIMARY KEY,
        nom        VARCHAR(100) NOT NULL,
        email      VARCHAR(150) NOT NULL UNIQUE,
        password   VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;

    -- ============================================================
    -- TABLE : regimes
    -- Les régimes alimentaires proposés
    -- ============================================================
    CREATE TABLE regimes (
        id                         INT AUTO_INCREMENT PRIMARY KEY,
        nom                        VARCHAR(150) NOT NULL,
        description                TEXT,
        pct_viande                 INT NOT NULL DEFAULT 0,   -- % de viande (0-100)
        pct_poisson                INT NOT NULL DEFAULT 0,   -- % de poisson
        pct_volaille               INT NOT NULL DEFAULT 0,   -- % de volaille
        -- CONTRAINTE LOGIQUE : pct_viande + pct_poisson + pct_volaille = 100
        variation_poids_par_semaine DECIMAL(4,2) NOT NULL,  -- kg/semaine (positif = prise, négatif = perte)
        actif                      TINYINT(1) NOT NULL DEFAULT 1,
        created_at                 DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at                 DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        CONSTRAINT chk_pct_total CHECK (pct_viande + pct_poisson + pct_volaille = 100)
    ) ENGINE=InnoDB;

    -- ============================================================
    -- TABLE : regime_prix
    -- Prix d'un régime selon la durée choisie
    -- Un même régime peut avoir plusieurs durées/prix
    -- ============================================================
    CREATE TABLE regime_prix (
        id              INT AUTO_INCREMENT PRIMARY KEY,
        regime_id       INT NOT NULL,
        duree_semaines  INT NOT NULL,          -- ex: 4, 8, 12
        prix            DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (regime_id) REFERENCES regimes(id) ON DELETE CASCADE,
        UNIQUE KEY uq_regime_duree (regime_id, duree_semaines)
    ) ENGINE=InnoDB;

    -- ============================================================
    -- TABLE : activites
    -- Les activités sportives disponibles
    -- ============================================================
    CREATE TABLE activites (
        id             INT AUTO_INCREMENT PRIMARY KEY,
        nom            VARCHAR(150) NOT NULL,
        description    TEXT,
        calories_heure INT NOT NULL DEFAULT 0,    -- calories brûlées par heure
        intensite      ENUM('faible','moderate','intense') NOT NULL DEFAULT 'moderate',
        objectif_code  VARCHAR(30) DEFAULT NULL,  -- NULL = convient à tous, sinon code objectif ciblé
        actif          TINYINT(1) NOT NULL DEFAULT 1,
        created_at     DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;

    -- ============================================================
    -- TABLE : user_regimes
    -- Régimes achetés/souscrits par les utilisateurs
    -- ============================================================
    CREATE TABLE user_regimes (
        id               INT AUTO_INCREMENT PRIMARY KEY,
        user_id          INT NOT NULL,
        regime_id        INT NOT NULL,
        regime_prix_id   INT NOT NULL,
        prix_paye        DECIMAL(10,2) NOT NULL,  -- prix réel payé (avec réduction gold éventuelle)
        gold_applique    TINYINT(1) NOT NULL DEFAULT 0,
        date_debut       DATE NOT NULL,
        date_fin         DATE NOT NULL,
        created_at       DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id)        REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (regime_id)      REFERENCES regimes(id),
        FOREIGN KEY (regime_prix_id) REFERENCES regime_prix(id)
    ) ENGINE=InnoDB;

    -- ============================================================
    -- TABLE : user_activites
    -- Activités recommandées liées à un user_regime
    -- ============================================================
    CREATE TABLE user_activites (
        id              INT AUTO_INCREMENT PRIMARY KEY,
        user_regime_id  INT NOT NULL,
        activite_id     INT NOT NULL,
        created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_regime_id) REFERENCES user_regimes(id) ON DELETE CASCADE,
        FOREIGN KEY (activite_id)    REFERENCES activites(id)
    ) ENGINE=InnoDB;

    -- ============================================================
    -- TABLE : codes_portefeuille
    -- Codes à usage unique pour créditer le wallet
    -- ============================================================
    CREATE TABLE codes_portefeuille (
        id              INT AUTO_INCREMENT PRIMARY KEY,
        code            VARCHAR(20) NOT NULL UNIQUE,
        montant         DECIMAL(10,2) NOT NULL,
        actif           TINYINT(1) NOT NULL DEFAULT 1,
        utilisateur_id  INT DEFAULT NULL,     -- NULL = non utilisé
        utilise_le      DATETIME DEFAULT NULL,
        created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (utilisateur_id) REFERENCES users(id) ON DELETE SET NULL
    ) ENGINE=InnoDB;

    -- ============================================================
    -- TABLE : parametres
    -- Paramètres globaux de l'application (modifiables en back-office)
    -- ============================================================
    CREATE TABLE parametres (
        id          INT AUTO_INCREMENT PRIMARY KEY,
        cle         VARCHAR(50) NOT NULL UNIQUE,
        valeur      VARCHAR(255) NOT NULL,
        description VARCHAR(255),
        updated_at  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;

    -- ============================================================
    -- DONNÉES MINIMALES — ADMINS (1)
    -- Mot de passe : Admin@1234
    -- ============================================================
    INSERT INTO admins (nom, email, password) VALUES
    ('Super Admin', 'admin@dietapp.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
    -- Note: remplacer ce hash par password_hash('Admin@1234', PASSWORD_DEFAULT) en PHP

    -- ============================================================
    -- DONNÉES MINIMALES — UTILISATEURS (5)
    -- Mot de passe pour tous : Password@123
    -- ============================================================
    INSERT INTO users (nom, prenom, email, password, genre, taille, poids, objectif_id, option_gold, solde_wallet) VALUES
    ('Rakoto',    'Jean',    'jean.rakoto@mail.com',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'M', 175.00, 85.00, 2, 0, 50.00),
    ('Rasoa',     'Marie',   'marie.rasoa@mail.com',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'F', 162.00, 55.00, 3, 1, 120.00),
    ('Rabe',      'Paul',    'paul.rabe@mail.com',      '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'M', 180.00, 65.00, 1, 0, 30.00),
    ('Ravao',     'Sophie',  'sophie.ravao@mail.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'F', 158.00, 72.00, 2, 0, 0.00),
    ('Andrianina','Thomas',  'thomas.and@mail.com',     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'M', 170.00, 58.00, 1, 1, 200.00);
    -- ⚠️ IMPORTANT : En PHP lors de l'inscription, utiliser password_hash('Password@123', PASSWORD_DEFAULT)
    -- Le hash ci-dessus est un exemple Laravel/bcrypt. Régénérer avec PHP avant les tests.

    -- ============================================================
    -- DONNÉES MINIMALES — RÉGIMES (5)
    -- ============================================================
    INSERT INTO regimes (nom, description, pct_viande, pct_poisson, pct_volaille, variation_poids_par_semaine) VALUES
    ('Régime Minceur Express',    'Régime hypocalorique riche en poisson, idéal pour perdre du poids rapidement.', 10, 60, 30, -0.75),
    ('Régime Équilibre Marin',    'Combinaison équilibrée pour maintenir son IMC idéal avec une bonne proportion de poisson.', 20, 50, 30, -0.30),
    ('Régime Prise de Masse',     'Riche en viande rouge et volaille pour une prise de masse musculaire progressive.', 50, 10, 40, 0.60),
    ('Régime Volaille Actif',     'Priorité à la volaille, adapté aux sportifs voulant augmenter légèrement le poids.', 15, 20, 65, 0.40),
    ('Régime Détox Poisson',      'Quasi exclusivement à base de poisson pour une détoxification et perte de poids douce.', 5, 80, 15, -0.50);

    -- ============================================================
    -- DONNÉES MINIMALES — REGIME_PRIX (3 durées par régime)
    -- ============================================================
    INSERT INTO regime_prix (regime_id, duree_semaines, prix) VALUES
    -- Régime 1 : Minceur Express
    (1, 4,  29.99),
    (1, 8,  49.99),
    (1, 12, 69.99),
    -- Régime 2 : Équilibre Marin
    (2, 4,  24.99),
    (2, 8,  44.99),
    (2, 12, 59.99),
    -- Régime 3 : Prise de Masse
    (3, 4,  34.99),
    (3, 8,  59.99),
    (3, 12, 79.99),
    -- Régime 4 : Volaille Actif
    (4, 4,  27.99),
    (4, 8,  49.99),
    (4, 12, 64.99),
    -- Régime 5 : Détox Poisson
    (5, 4,  22.99),
    (5, 8,  39.99),
    (5, 12, 54.99);

    -- ============================================================
    -- DONNÉES MINIMALES — ACTIVITÉS SPORTIVES (5)
    -- ============================================================
    INSERT INTO activites (nom, description, calories_heure, intensite, objectif_code) VALUES
    ('Course à pied',       'Jogging léger à vitesse modérée, idéal pour brûler des calories.',                        500, 'moderate', 'reduire_poids'),
    ('Natation',            'Nage libre en piscine, excellente pour le cardio et la tonification.',                     450, 'moderate', NULL),
    ('Musculation',         'Entraînement avec poids pour augmenter la masse musculaire.',                              350, 'intense',  'augmenter_poids'),
    ('Yoga / Stretching',   'Exercices de flexibilité et de respiration, idéal pour la récupération.',                 200, 'faible',   'imc_ideal'),
    ('Vélo / Cyclisme',     'Cyclisme d\'endurance pour renforcer les jambes et brûler les graisses progressivement.',  400, 'moderate', 'reduire_poids');

    -- ============================================================
    -- DONNÉES MINIMALES — CODES PORTEFEUILLE (15)
    -- ============================================================
    INSERT INTO codes_portefeuille (code, montant, actif) VALUES
    ('DIET-AAA-001', 10.00,  1),
    ('DIET-BBB-002', 20.00,  1),
    ('DIET-CCC-003', 50.00,  1),
    ('DIET-DDD-004', 10.00,  1),
    ('DIET-EEE-005', 15.00,  1),
    ('DIET-FFF-006', 25.00,  1),
    ('DIET-GGG-007', 30.00,  1),
    ('DIET-HHH-008', 10.00,  1),
    ('DIET-III-009', 20.00,  1),
    ('DIET-JJJ-010', 50.00,  1),
    ('DIET-KKK-011', 10.00,  1),
    ('DIET-LLL-012', 15.00,  1),
    ('DIET-MMM-013', 25.00,  1),
    ('DIET-NNN-014', 10.00,  1),
    ('DIET-OOO-015', 100.00, 1);

    -- ============================================================
    -- DONNÉES MINIMALES — PARAMÈTRES
    -- ============================================================
    INSERT INTO parametres (cle, valeur, description) VALUES
    ('prix_gold',        '49.99',  'Prix unique de l\'option Gold (en €)'),
    ('imc_min_normal',   '18.5',   'IMC minimum pour être dans la zone normale'),
    ('imc_max_normal',   '24.9',   'IMC maximum pour être dans la zone normale'),
    ('nom_application',  'Comme j\'adore','Nom affiché de l\'application'),
    ('email_contact',    'contact@dietapp.com', 'Email de contact affiché aux utilisateurs');

    -- ============================================================
    -- VUES UTILES (optionnelles, facilitent les requêtes)
    -- ============================================================

    -- Vue : utilisateurs avec leur IMC calculé
    CREATE VIEW vue_users_imc AS
    SELECT
        u.id,
        u.nom,
        u.prenom,
        u.email,
        u.genre,
        u.taille,
        u.poids,
        ROUND(u.poids / ((u.taille / 100) * (u.taille / 100)), 2) AS imc,
        o.libelle AS objectif,
        u.option_gold,
        u.solde_wallet
    FROM users u
    JOIN objectifs o ON u.objectif_id = o.id;

    -- Vue : statistiques ventes par régime
    CREATE VIEW vue_ventes_regimes AS
    SELECT
        r.id,
        r.nom AS regime_nom,
        COUNT(ur.id) AS nb_ventes,
        SUM(ur.prix_paye) AS total_revenu
    FROM regimes r
    LEFT JOIN user_regimes ur ON ur.regime_id = r.id
    GROUP BY r.id, r.nom;
