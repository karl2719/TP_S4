
CREATE DATABASE IF NOT EXISTS alimea
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE alimea;


CREATE TABLE users (
    id            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    nom           VARCHAR(80)     NOT NULL,
    prenom        VARCHAR(80)     NOT NULL,
    email         VARCHAR(150)    NOT NULL UNIQUE,
    password      VARCHAR(255)    NOT NULL,
    genre         ENUM('homme','femme','autre') NOT NULL,
    date_naissance DATE           NULL,
    created_at    DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_email (email)
) ;



CREATE TABLE user_health_history (
    id          INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    user_id     INT UNSIGNED   NOT NULL,
    taille_cm   DECIMAL(5,1)   NOT NULL COMMENT 'Taille en centimètres',
    poids_kg    DECIMAL(5,2)   NOT NULL COMMENT 'Poids en kilogrammes',
    objectif    ENUM('augmenter_poids','reduire_poids','imc_ideal') NOT NULL,
    updated_at  DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP
                               ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_health_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_health_user (user_id)
) ;


CREATE TABLE wallets (
    id       INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    user_id  INT UNSIGNED   NOT NULL UNIQUE,
    is_gold  TINYINT(1)     NOT NULL DEFAULT 0,
    sold     DECIMAL(10,2)  NOT NULL DEFAULT 0.0,
    gold_activated_at DATETIME NULL COMMENT 'Date d activation de l option Gold',
    PRIMARY KEY (id),
    CONSTRAINT fk_wallet_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ;



CREATE TABLE wallet_transactions (
    id          INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    user_id     INT UNSIGNED   NOT NULL,
    type        ENUM('recharge','achat_regime','achat_gold') NOT NULL,
    montant     DECIMAL(10,2)  NOT NULL COMMENT 'Positif = crédit, Négatif = débit',
    description VARCHAR(255)   NULL,
    created_at  DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_trans_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_trans_user (user_id),
    INDEX idx_trans_type (type)
) ;



CREATE TABLE codes_portefeuille (
    id         INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    code       VARCHAR(20)    NOT NULL UNIQUE,
    montant    DECIMAL(10,2)  NOT NULL,
    is_used    TINYINT(1)     NOT NULL DEFAULT 0,
    used_at    DATETIME       NULL,
    created_at DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    used_by    INT UNSIGNED   NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_code_user FOREIGN KEY (used_by)
        REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX idx_code (code),
    INDEX idx_is_used (is_used)
) ;



CREATE TABLE regimes (
    id               INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    nom              VARCHAR(120)   NOT NULL,
    description      TEXT           NULL,
    pct_viande       DECIMAL(5,2)   NOT NULL DEFAULT 0.00 COMMENT 'Pourcentage viande (0–100)',
    pct_poisson      DECIMAL(5,2)   NOT NULL DEFAULT 0.00 COMMENT 'Pourcentage poisson (0–100)',
    pct_volaille     DECIMAL(5,2)   NOT NULL DEFAULT 0.00 COMMENT 'Pourcentage volaille (0–100)',
    variation_poids_kg DECIMAL(5,2) NOT NULL COMMENT 'Variation de poids possible en kg (+ ou -)',
    objectif_cible   ENUM('augmenter_poids','reduire_poids','imc_ideal','tous') NOT NULL DEFAULT 'tous',
    is_active        TINYINT(1)     NOT NULL DEFAULT 1,
    created_at       DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_objectif (objectif_cible),
    INDEX idx_active (is_active)
) ;



CREATE TABLE regime_prix (
    id         INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    regime_id  INT UNSIGNED   NOT NULL,
    duree_jours INT UNSIGNED  NOT NULL COMMENT 'Ex : 7, 14, 30 jours',
    prix       DECIMAL(10,2)  NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_prix_regime FOREIGN KEY (regime_id)
        REFERENCES regimes(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY uq_regime_duree (regime_id, duree_jours),
    INDEX idx_regime (regime_id)
) ;



CREATE TABLE activites_sportives (
    id                 INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    nom                VARCHAR(120)  NOT NULL,
    description        TEXT          NULL,
    intensite          ENUM('faible','modere','intense') NOT NULL DEFAULT 'modere',
    calories_par_heure INT UNSIGNED  NOT NULL DEFAULT 0,
    objectif_cible     ENUM('augmenter_poids','reduire_poids','imc_ideal','tous') NOT NULL DEFAULT 'tous',
    is_active          TINYINT(1)    NOT NULL DEFAULT 1,
    created_at         DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ;



CREATE TABLE user_regimes_paiement (
    id          INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    user_id     INT UNSIGNED  NOT NULL,
    regime_id   INT UNSIGNED  NOT NULL,
    prix_paye   DECIMAL(10,2) NOT NULL COMMENT 'Prix theoriquemnt payé (sans remise Gold éventuelle)',
    remise_gold TINYINT(1)    NOT NULL DEFAULT 0 COMMENT '1 si remise Gold de 15% appliquée',
    duree_jours INT UNSIGNED  NOT NULL,
    date_debut  DATE          NOT NULL,
    date_fin    DATE          NOT NULL,
    statut      ENUM('actif','termine','annule') NOT NULL DEFAULT 'actif',
    created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_ur_user   FOREIGN KEY (user_id)
        REFERENCES users(id)   ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_ur_regime FOREIGN KEY (regime_id)
        REFERENCES regimes(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX idx_ur_user   (user_id),
    INDEX idx_ur_regime (regime_id),
    INDEX idx_ur_statut (statut)
) ;



CREATE TABLE user_activites (
    id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id      INT UNSIGNED NOT NULL,
    activite_id  INT UNSIGNED NOT NULL,
    regime_id    INT UNSIGNED NULL COMMENT 'Activité liée à un régime particulier, optionnel',
    assigned_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_ua_user     FOREIGN KEY (user_id)
        REFERENCES users(id)              ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_ua_activite FOREIGN KEY (activite_id)
        REFERENCES activites_sportives(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_ua_regime   FOREIGN KEY (regime_id)
        REFERENCES regimes(id)            ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX idx_ua_user (user_id)
) ;



CREATE TABLE admin_users (
    id            INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    username      VARCHAR(80)   NOT NULL UNIQUE,
    password      VARCHAR(255)  NOT NULL,
    nom_complet   VARCHAR(150)  NULL,
    role          ENUM('superadmin','admin','moderateur') NOT NULL DEFAULT 'admin',
    is_active     TINYINT(1)    NOT NULL DEFAULT 1,
    last_login    DATETIME      NULL,
    created_at    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_username (username)
) ;


CREATE TABLE codes_remise (
    id          INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    cle         VARCHAR(80)   NOT NULL UNIQUE COMMENT 'Ex : prix_gold, remise_gold_pct, imc_min_normal',
    valeur      VARCHAR(255)  NOT NULL,
    description TEXT          NULL,
    created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
                              ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_cle (cle)
) ;

CREATE TABLE gold_payement (
    id          INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    user_id     INT UNSIGNED  NOT NULL,
    prix_paye   DECIMAL(10,2) NOT NULL,
    code_remise_id INT UNSIGNED NOT NULL,
    created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
                              ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_crt_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_crt_code_remise FOREIGN KEY (code_remise_id)
        REFERENCES codes_remise(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX idx_crt_user (user_id),
    INDEX idx_crt_code_remise (code_remise_id)
) ;





INSERT INTO codes_remise (cle, valeur, description) VALUES
('remise_gold_pct_1',       '123ABC',  'remise_gold_pct'),
('remise_gold_pct_2',       '456AZD',  'remise_gold_pct'),
('remise_gold_pct_3',       '745FDS',  'remise_gold_pct'),
('remise_gold_pct_4',       '12DS2D',  'remise_gold_pct'),
('remise_gold_pct_5',       '3EW34G',  'remise_gold_pct');


INSERT INTO users (nom, prenom, email, password, genre, date_naissance) VALUES
('Martin',  'Lina',   'lina.martin@example.com',   '$2y$10$demoHashLina',   'femme', '1999-04-12'),
('Bernard', 'Hugo',   'hugo.bernard@example.com',  '$2y$10$demoHashHugo',   'homme', '1996-09-23'),
('Nguyen',  'My',     'my.nguyen@example.com',     '$2y$10$demoHashMy',     'femme', '2001-02-05'),
('Diallo',  'Ibra',   'ibra.diallo@example.com',   '$2y$10$demoHashIbra',   'homme', '1997-12-19'),
('Rossi',   'Elena',  'elena.rossi@example.com',   '$2y$10$demoHashElena',  'autre', '1998-07-08');

INSERT INTO regimes (nom, description, pct_viande, pct_poisson, pct_volaille, variation_poids_kg, objectif_cible) VALUES
('Equilibre',   'Regime equilibre pour maintien',             40.00, 30.00, 30.00,  0.00, 'imc_ideal'),
('Proteine+',   'Augmentation de masse maigre',               60.00, 20.00, 20.00,  3.00, 'augmenter_poids'),
('Leger',       'Reduction de poids progressive',             20.00, 40.00, 40.00, -4.00, 'reduire_poids'),
('Marin',       'Focus poisson et omega',                      10.00, 70.00, 20.00, -2.00, 'tous'),
('VolailleFit', 'Focus volaille et controle calories',         15.00, 15.00, 70.00, -1.50, 'tous');

INSERT INTO activites_sportives (nom, description, intensite, calories_par_heure, objectif_cible) VALUES
('Marche rapide',     'Marche active en exterieur',    'faible',  250, 'tous'),
('Jogging',           'Course legere 30-45 minutes',  'modere',  450, 'reduire_poids'),
('Natation',          'Nage continue',                'modere',  500, 'tous'),
('HIIT',              'Intervalles haute intensite',  'intense', 650, 'reduire_poids'),
('Musculation',       'Renforcement musculaire',      'intense', 550, 'augmenter_poids');

INSERT INTO codes_portefeuille (code, montant) VALUES
('WALLET-0001',  5.00),
('WALLET-0002', 10.00),
('WALLET-0003', 15.00),
('WALLET-0004', 20.00),
('WALLET-0005', 25.00),
('WALLET-0006', 30.00),
('WALLET-0007', 35.00),
('WALLET-0008', 40.00),
('WALLET-0009', 45.00),
('WALLET-0010', 50.00),
('WALLET-0011', 60.00),
('WALLET-0012', 70.00),
('WALLET-0013', 80.00),
('WALLET-0014', 90.00),
('WALLET-0015', 100.00);



INSERT INTO admin_users (username, password, nom_complet, role) VALUES
('admin', 'admin', 'Super Administrateur', 'superadmin');
