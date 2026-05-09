# 🥗 CARNET DE BORD — PROJET S4 : Application de Régime Alimentaire
> **Stack** : PHP 8+ / CodeIgniter 4 · HTML/CSS · JavaScript/AJAX · MySQL  
> **Deadline** : Lundi 11 mai 2026  
> **Groupe** : 3 personnes (mixte fille/garçon)  
> **Branche principale** : `main` (tous les merges se font ici)

---

## 📁 STRUCTURE DES FICHIERS DE CE CARNET

| Fichier | Rôle |
|---|---|
| `CARNET_DE_BORD.md` | Ce fichier — vision globale, étapes, logique |
| `DATABASE_SCHEMA.sql` | Script SQL complet (tables + données minimales) |
| `ROUTES_ET_CONTROLLERS.md` | Toutes les routes, controllers, méthodes |
| `TACHES_EQUIPE.md` | Répartition des tâches par membre |

---

## 🗺️ VISION GLOBALE DU PROJET

L'application a **deux faces** :

### Front Office (utilisateur final)
- Inscription en 2 étapes
- Login / Profil
- Calcul IMC automatique
- Choix d'objectif (augmenter / réduire / IMC idéal)
- Suggestions de régimes + activités sportives
- Paiement via code portefeuille
- Option Gold (remise 15%)
- Export PDF du plan

### Back Office (administrateur)
- Dashboard avec graphiques/statistiques
- CRUD Régimes (% viande, poisson, volaille + prix + durée)
- CRUD Activités sportives
- CRUD Codes portefeuille
- CRUD Paramètres
- Gestion des utilisateurs

---

## 🗄️ BASE DE DONNÉES — LOGIQUE DES TABLES

> Le script SQL complet est dans `DATABASE_SCHEMA.sql`

### Liste des tables

| Table | Description |
|---|---|
| `users` | Comptes utilisateurs (infos perso + santé) |
| `regimes` | Les régimes disponibles |
| `regime_prix` | Prix selon durée (relation avec regimes) |
| `activites` | Activités sportives |
| `objectifs` | Les 3 types d'objectifs possibles |
| `user_regimes` | Régimes achetés/souscrits par un user |
| `user_activites` | Activités liées à un plan utilisateur |
| `codes_portefeuille` | Codes à entrer pour créditer le wallet |
| `parametres` | Paramètres globaux de l'appli (IMC idéal, etc.) |
| `admins` | Comptes back-office |

### Relations clés
```
users (1) ──────< (N) user_regimes >──────── (1) regimes
users (1) ──────< (N) user_activites >─────── (1) activites
regimes (1) ────< (N) regime_prix
codes_portefeuille : utilisé_par → users.id (nullable)
```

### Champs importants — `users`
```
id, nom, prenom, email, password (hashé), genre (M/F),
taille (cm), poids (kg), objectif_id, 
option_gold (0/1), solde_wallet (decimal),
created_at, updated_at
```

### Champs importants — `regimes`
```
id, nom, description, 
pct_viande (int), pct_poisson (int), pct_volaille (int),
variation_poids_par_semaine (decimal, + ou -),
actif (0/1), created_at
```

### Champs importants — `regime_prix`
```
id, regime_id (FK), duree_semaines (int), prix (decimal)
```

### Champs importants — `codes_portefeuille`
```
id, code (varchar unique), montant (decimal),
utilisateur_id (nullable FK → users),
utilise_le (datetime nullable), actif (0/1)
```

---

## 🧮 LOGIQUE MÉTIER — CALCULS

### Calcul IMC
```
IMC = poids (kg) / (taille (m))²
taille_m = taille_cm / 100
```

### Interprétation IMC
```
< 18.5      → Insuffisance pondérale
18.5 – 24.9 → Poids normal (IMC idéal)
25.0 – 29.9 → Surpoids
≥ 30        → Obésité
```

### Poids idéal (formule Lorentz)
```
Homme : poids_idéal = taille_cm - 100 - (taille_cm - 150) / 4
Femme : poids_idéal = taille_cm - 100 - (taille_cm - 150) / 2.5
```

### Suggestion de régime selon objectif
```
objectif = "augmenter_poids"  → filtrer regimes où variation_poids_par_semaine > 0
objectif = "reduire_poids"    → filtrer regimes où variation_poids_par_semaine < 0
objectif = "imc_ideal"        → filtrer selon si IMC actuel > 24.9 (réduire) ou < 18.5 (augmenter)
```

### Durée estimée pour atteindre l'objectif
```
delta_poids = poids_cible - poids_actuel
semaines_necessaires = delta_poids / variation_poids_par_semaine (valeur absolue)
afficher durée estimée en semaines et mois
```

### Prix avec option Gold
```
prix_final = prix_base * 0.85  (si user.option_gold = 1)
```

### Achat d'un régime
```
1. Vérifier solde_wallet >= prix_final
2. Déduire le montant : UPDATE users SET solde_wallet = solde_wallet - prix_final
3. Insérer dans user_regimes : (user_id, regime_id, regime_prix_id, date_debut, date_fin)
4. date_fin = date_debut + duree_semaines * 7 jours
```

---

## 🏗️ ARCHITECTURE CODEIGNITER 4

### Structure des dossiers (à l'intérieur de `app/`)
```
app/
├── Controllers/
│   ├── Auth.php           ← Inscription (2 étapes) + Login + Logout
│   ├── Dashboard.php      ← Page principale user connecté
│   ├── Profil.php         ← Complétion et édition profil
│   ├── Regime.php         ← Affichage, filtrage, achat régimes
│   ├── Wallet.php         ← Saisie de code + crédit
│   ├── Gold.php           ← Souscription option gold
│   ├── Export.php         ← Génération PDF
│   └── admin/
│       ├── AdminAuth.php      ← Login admin
│       ├── AdminDashboard.php ← Stats + graphiques
│       ├── AdminRegimes.php   ← CRUD régimes
│       ├── AdminActivites.php ← CRUD activités
│       ├── AdminCodes.php     ← CRUD + validation codes
│       └── AdminParams.php    ← CRUD paramètres
│
├── Models/
│   ├── UserModel.php
│   ├── RegimeModel.php
│   ├── RegimePrixModel.php
│   ├── ActiviteModel.php
│   ├── CodePortefeuilleModel.php
│   ├── UserRegimeModel.php
│   ├── ParametreModel.php
│   └── AdminModel.php
│
├── Views/
│   ├── layouts/
│   │   ├── main.php           ← Layout front (header, nav, footer)
│   │   └── admin.php          ← Layout back-office
│   ├── auth/
│   │   ├── login.php
│   │   ├── register_step1.php ← Infos perso
│   │   └── register_step2.php ← Infos santé
│   ├── dashboard/
│   │   └── index.php          ← Dashboard utilisateur (IMC, objectif, régimes)
│   ├── profil/
│   │   └── edit.php
│   ├── regime/
│   │   ├── liste.php
│   │   └── detail.php
│   ├── wallet/
│   │   └── index.php
│   ├── gold/
│   │   └── index.php
│   └── admin/
│       ├── login.php
│       ├── dashboard.php
│       ├── regimes/
│       │   ├── index.php
│       │   ├── create.php
│       │   └── edit.php
│       ├── activites/
│       │   ├── index.php
│       │   ├── create.php
│       │   └── edit.php
│       ├── codes/
│       │   ├── index.php
│       │   └── create.php
│       └── params/
│           └── index.php
```

---

## 🔀 ROUTES — `app/Config/Routes.php`

```php
// AUTH FRONT
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');
$routes->get('register/step1', 'Auth::registerStep1');
$routes->post('register/step1', 'Auth::doRegisterStep1');
$routes->get('register/step2', 'Auth::registerStep2');
$routes->post('register/step2', 'Auth::doRegisterStep2');

// FRONT USER (protégé par filtre auth)
$routes->get('dashboard', 'Dashboard::index');
$routes->get('profil', 'Profil::index');
$routes->post('profil/update', 'Profil::update');
$routes->get('regimes', 'Regime::index');
$routes->get('regimes/(:num)', 'Regime::detail/$1');
$routes->post('regimes/acheter', 'Regime::acheter');
$routes->get('wallet', 'Wallet::index');
$routes->post('wallet/crediter', 'Wallet::crediter');
$routes->get('gold', 'Gold::index');
$routes->post('gold/activer', 'Gold::activer');
$routes->get('export/pdf/(:num)', 'Export::pdf/$1');

// BACK OFFICE (protégé par filtre admin)
$routes->get('admin', 'admin\AdminAuth::login');
$routes->post('admin/login', 'admin\AdminAuth::doLogin');
$routes->get('admin/logout', 'admin\AdminAuth::logout');
$routes->get('admin/dashboard', 'admin\AdminDashboard::index');

// CRUD Régimes admin
$routes->get('admin/regimes', 'admin\AdminRegimes::index');
$routes->get('admin/regimes/create', 'admin\AdminRegimes::create');
$routes->post('admin/regimes/store', 'admin\AdminRegimes::store');
$routes->get('admin/regimes/edit/(:num)', 'admin\AdminRegimes::edit/$1');
$routes->post('admin/regimes/update/(:num)', 'admin\AdminRegimes::update/$1');
$routes->get('admin/regimes/delete/(:num)', 'admin\AdminRegimes::delete/$1');

// CRUD Activités admin
$routes->get('admin/activites', 'admin\AdminActivites::index');
$routes->get('admin/activites/create', 'admin\AdminActivites::create');
$routes->post('admin/activites/store', 'admin\AdminActivites::store');
$routes->get('admin/activites/edit/(:num)', 'admin\AdminActivites::edit/$1');
$routes->post('admin/activites/update/(:num)', 'admin\AdminActivites::update/$1');
$routes->get('admin/activites/delete/(:num)', 'admin\AdminActivites::delete/$1');

// CRUD Codes admin
$routes->get('admin/codes', 'admin\AdminCodes::index');
$routes->get('admin/codes/create', 'admin\AdminCodes::create');
$routes->post('admin/codes/store', 'admin\AdminCodes::store');
$routes->get('admin/codes/delete/(:num)', 'admin\AdminCodes::delete/$1');

// CRUD Paramètres admin
$routes->get('admin/params', 'admin\AdminParams::index');
$routes->post('admin/params/update', 'admin\AdminParams::update');
```

---

## 🔐 FILTRES D'AUTHENTIFICATION

Créer `app/Filters/AuthFilter.php` :
```php
<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
```

Créer `app/Filters/AdminFilter.php` (même logique, vérifie `session('admin_id')`).

Déclarer dans `app/Config/Filters.php` :
```php
public array $aliases = [
    'auth'  => \App\Filters\AuthFilter::class,
    'admin' => \App\Filters\AdminFilter::class,
];
public array $filters = [
    'auth'  => ['before' => ['dashboard', 'profil*', 'regimes*', 'wallet*', 'gold*', 'export*']],
    'admin' => ['before' => ['admin/dashboard*', 'admin/regimes*', 'admin/activites*', 'admin/codes*', 'admin/params*']],
];
```

---

## 📋 CONTROLLERS — LOGIQUE DÉTAILLÉE

### `Auth.php`

#### `registerStep1()` GET
- Affiche `auth/register_step1.php`
- Champs : `nom`, `prenom`, `email`, `password`, `password_confirm`, `genre`

#### `doRegisterStep1()` POST
- Valider tous les champs (email unique, password == password_confirm)
- Stocker dans session temporaire : `session()->set('reg_step1', $data)`
- Rediriger vers `/register/step2`

#### `registerStep2()` GET
- Vérifier que `session('reg_step1')` existe, sinon redirect step1
- Afficher `auth/register_step2.php`
- Champs : `taille` (cm), `poids` (kg), `objectif_id`

#### `doRegisterStep2()` POST
- Récupérer step1 depuis session
- Hasher le mot de passe : `password_hash($pass, PASSWORD_DEFAULT)`
- Calculer IMC et stocker
- Insérer dans `users`
- Détruire `reg_step1` de la session
- Connecter l'utilisateur (session `user_id`)
- Redirect vers `/dashboard`

#### `doLogin()` POST
- Vérifier email dans DB
- `password_verify($input, $hash)`
- Si OK : `session()->set(['user_id'=>..., 'user_nom'=>...])`
- Redirect `/dashboard`

---

### `Dashboard.php`

#### `index()` GET
- Récupérer user complet depuis DB
- Calculer IMC
- Récupérer ses `user_regimes` actifs (date_fin >= today)
- Récupérer ses activités liées
- Passer à la vue : `imc`, `interpretation_imc`, `poids_ideal`, `regimes_actifs`, `activites`

---

### `Regime.php`

#### `index()` GET
- Récupérer l'objectif du user (depuis session ou DB)
- Filtrer les régimes correspondants (SQL avec `WHERE variation_poids_par_semaine > 0` etc.)
- Afficher la liste avec prix (les plus courts et les plus longs)
- Afficher badge "Gold" si user.option_gold = 1

#### `acheter()` POST
- Récupérer `regime_prix_id` depuis POST
- Récupérer le prix correspondant
- Si gold : prix * 0.85
- Vérifier solde
- Déduire solde, insérer `user_regimes`
- Response JSON `{success: true, message: '...', nouveau_solde: ...}` (appel AJAX)

---

### `Wallet.php`

#### `crediter()` POST
- Récupérer `code` depuis POST
- Chercher dans `codes_portefeuille` où `code = ? AND actif = 1 AND utilisateur_id IS NULL`
- Si trouvé : 
  - `UPDATE users SET solde_wallet = solde_wallet + montant`
  - `UPDATE codes_portefeuille SET utilisateur_id = ?, utilise_le = NOW(), actif = 0`
  - Response JSON `{success: true, montant: ..., nouveau_solde: ...}`
- Sinon : Response JSON `{success: false, message: 'Code invalide ou déjà utilisé'}`

---

### `Gold.php`

#### `index()` GET
- Afficher page avec prix Gold (récupéré depuis `parametres` clé `prix_gold`)
- Afficher les avantages

#### `activer()` POST
- Vérifier solde >= prix_gold
- Déduire, set `option_gold = 1`
- Response JSON ou redirect avec flash message

---

### `Export.php`

#### `pdf($user_regime_id)` GET
- Utiliser la lib **TCPDF** ou **Dompdf** (installer via composer)
- Récupérer le plan complet (user, regime, activités, dates)
- Générer un PDF et le renvoyer en download
- Installation Dompdf : `composer require dompdf/dompdf`

---

### `admin/AdminDashboard.php`

#### `index()` GET
Calculer et passer à la vue :
- Nombre total d'utilisateurs
- Nombre d'utilisateurs avec option Gold
- Nombre de régimes actifs
- Total des ventes (somme des prix payés dans `user_regimes`)
- Répartition des objectifs (pour pie chart)
- Nouveaux inscrits par mois (pour bar chart)
- Régimes les plus populaires

---

### `admin/AdminRegimes.php`

#### `store()` POST
- Valider : `pct_viande + pct_poisson + pct_volaille = 100` (obligation)
- Insérer dans `regimes`
- Puis insérer dans `regime_prix` pour chaque durée soumise (ex: 4 sem, 8 sem, 12 sem)
- Redirect avec flash "Régime créé avec succès"

#### `edit($id)` GET
- Récupérer régime + ses prix
- Afficher formulaire pré-rempli

#### `update($id)` POST
- Mettre à jour `regimes`
- Supprimer les anciens `regime_prix` pour ce regime, réinsérer

---

## 🎨 VUES — INSTRUCTIONS UI/UX

### Design général Front Office
- Navbar : Logo + lien Dashboard / Régimes / Wallet / Profil / Logout
- Afficher **solde wallet** dans la navbar en temps réel
- Afficher badge **GOLD ⭐** si option gold active
- Utiliser Bootstrap 5 (CDN) + CSS custom
- Utiliser Chart.js (CDN) pour les graphiques admin

### Inscription — Step 1
```html
<!-- Champs : Prénom, Nom, Email, Genre (radio M/F), Password, Confirm Password -->
<!-- Bouton : Suivant → -->
```

### Inscription — Step 2
```html
<!-- Champs : Taille (cm), Poids (kg), Objectif (select ou radio : augmenter/réduire/imc_idéal) -->
<!-- Afficher en temps réel l'IMC calculé en JavaScript au fur et à mesure de la saisie -->
<!-- Bouton : Créer mon compte -->
```

### Dashboard utilisateur
```
┌─────────────────────────────────────────────┐
│  Bonjour [Prénom] !          Solde: XX.XX €  │
├──────────────┬──────────────────────────────┤
│   MON IMC    │     MON OBJECTIF              │
│   22.4       │  🎯 Réduire mon poids          │
│   Poids norm │  Poids idéal : 68 kg          │
│              │  Durée estimée : 12 semaines  │
├──────────────┴──────────────────────────────┤
│  MES RÉGIMES ACTIFS                          │
│  [Régime X] - du 01/05 au 28/07              │
├─────────────────────────────────────────────┤
│  MES ACTIVITÉS RECOMMANDÉES                  │
│  [Activité A] [Activité B]                   │
└─────────────────────────────────────────────┘
```

### Page Régimes
- Filtre automatique selon objectif du user
- Cartes régimes avec : nom, description, % macros (barre visuelle), prix par durée
- Bouton "Acheter" → Modal AJAX (affiche prix, solde, confirmation)
- Si gold : afficher prix barré + prix réduit

---

## ⚡ AJAX — POINTS D'APPEL JAVASCRIPT

### 1. Achat d'un régime
```javascript
// Sur clic "Confirmer l'achat"
fetch('/regimes/acheter', {
  method: 'POST',
  headers: {'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
  body: JSON.stringify({regime_prix_id: id, csrf_token: token})
})
.then(r => r.json())
.then(data => {
  if(data.success) {
    document.getElementById('solde-nav').textContent = data.nouveau_solde + ' €';
    // Fermer modal, afficher message succès
  } else {
    // Afficher erreur (solde insuffisant, etc.)
  }
});
```

### 2. Crédit wallet
```javascript
// Sur soumission du formulaire code
fetch('/wallet/crediter', {method:'POST', ...})
.then(r => r.json())
.then(data => { /* mettre à jour affichage solde */ });
```

### 3. IMC en temps réel (inscription step 2)
```javascript
function calculerIMC() {
  const taille = parseFloat(document.getElementById('taille').value) / 100;
  const poids = parseFloat(document.getElementById('poids').value);
  if(taille > 0 && poids > 0) {
    const imc = (poids / (taille * taille)).toFixed(1);
    document.getElementById('imc-preview').textContent = imc;
    // Changer couleur selon interprétation
  }
}
document.getElementById('taille').addEventListener('input', calculerIMC);
document.getElementById('poids').addEventListener('input', calculerIMC);
```

---

## 📊 DASHBOARD ADMIN — GRAPHIQUES

Utiliser **Chart.js** via CDN.

### Graphique 1 : Bar Chart — Inscrits par mois
```php
// SQL
SELECT MONTH(created_at) as mois, COUNT(*) as total
FROM users
GROUP BY MONTH(created_at)
ORDER BY mois
```
```javascript
new Chart(ctx, {
  type: 'bar',
  data: { labels: mois, datasets: [{ label: 'Inscrits', data: totaux }] }
});
```

### Graphique 2 : Pie Chart — Répartition des objectifs
```php
SELECT o.libelle, COUNT(u.id) as total
FROM users u JOIN objectifs o ON u.objectif_id = o.id
GROUP BY o.id
```

### Graphique 3 : Bar — Régimes les plus vendus
```php
SELECT r.nom, COUNT(ur.id) as ventes
FROM user_regimes ur JOIN regimes r ON ur.regime_id = r.id
GROUP BY r.id ORDER BY ventes DESC LIMIT 5
```

### Tableau croisé : Objectif × IMC
- Compter combien d'utilisateurs par (objectif × catégorie IMC)
- Afficher en HTML table avec classes CSS colorées

---

## 🔒 SÉCURITÉ — CHECKLIST

- [ ] Toujours utiliser les **Query Builder** de CI4 (pas de SQL brut avec variables utilisateur)
- [ ] Token CSRF activé dans `app/Config/Security.php` : `$csrfProtection = 'session'`
- [ ] Hasher les mots de passe : `password_hash()` / `password_verify()`
- [ ] Vérifier que l'utilisateur connecté est bien propriétaire des ressources qu'il accède
- [ ] Filtres Auth et Admin sur toutes les routes protégées
- [ ] Valider et sanitiser tous les inputs POST
- [ ] Ne jamais afficher les erreurs PHP en production (`CI_ENVIRONMENT = production`)

---

## 📦 DÉPENDANCES — INSTALLATION

```bash
# Créer le projet CodeIgniter 4
composer create-project codeigniter4/appstarter nom_du_projet

# Aller dans le dossier
cd nom_du_projet

# Installer Dompdf pour export PDF
composer require dompdf/dompdf

# Copier env
cp env .env
# Éditer .env : database.default.hostname, database, username, password
# Mettre CI_ENVIRONMENT = development
```

### CDN à inclure dans le layout HTML
```html
<!-- Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js (pour admin) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Font Awesome (icônes) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
```

---

## 🗃️ DONNÉES MINIMALES REQUISES

Le script SQL `DATABASE_SCHEMA.sql` insère :

| Entité | Quantité |
|---|---|
| Utilisateurs | 5 |
| Codes portefeuille | 15 |
| Régimes | 5 |
| Activités sportives | 5 |
| Admin | 1 |
| Objectifs | 3 |

---

## 📅 ORDRE D'IMPLÉMENTATION RECOMMANDÉ

### Phase 1 — Base (Jour 1-2)
1. Créer le projet CI4, configurer `.env` et DB
2. Exécuter `DATABASE_SCHEMA.sql`
3. Créer les Models (UserModel, RegimeModel, etc.)
4. Implémenter Auth (login + inscription 2 étapes)
5. Créer les filtres Auth et Admin

### Phase 2 — Front Office Core (Jour 2-3)
6. Dashboard utilisateur (IMC, objectif, plans actifs)
7. Page Profil
8. Page Régimes + Filtrage par objectif
9. Système Wallet (saisie code, crédit)
10. Option Gold

### Phase 3 — Back Office (Jour 3-4)
11. Login admin
12. CRUD Régimes (avec regime_prix)
13. CRUD Activités
14. CRUD Codes portefeuille
15. CRUD Paramètres
16. Dashboard stats + graphiques

### Phase 4 — Finitions (Jour 4-5)
17. Export PDF (Dompdf)
18. AJAX pour achats et wallet
19. UI/UX polish (Bootstrap, responsive)
20. Tests complets de tous les flux
21. Seed données minimales vérifiées
22. Commits propres, merge vers `main`

---

## ✅ CHECKLIST FINALE AVANT LIVRAISON

- [ ] Toutes les fonctionnalités Front Office opérationnelles
- [ ] Toutes les fonctionnalités Back Office opérationnelles
- [ ] Export PDF fonctionnel
- [ ] Option Gold active et remise 15% appliquée
- [ ] 5 users, 15 codes, 5 régimes, 5 activités en base
- [ ] Données minimales insérées via script SQL
- [ ] Graphiques dashboard admin affichés
- [ ] Formulaire en 2 étapes d'inscription fonctionnel
- [ ] Calcul IMC en temps réel (JS)
- [ ] AJAX sur achat régime et crédit wallet
- [ ] Lien GitHub/GitLab fourni avec commits tout au long
- [ ] Merge sur branche `main` effectué
- [ ] Google Sheet de suivi des tâches rempli
- [ ] Formulaire Google Forms de livraison soumis
- [ ] Script SQL de la base inclus dans la livraison

---

## 🔗 LIENS UTILES

- [CodeIgniter 4 Docs](https://codeigniter.com/user_guide/)
- [CI4 Query Builder](https://codeigniter.com/user_guide/database/query_builder.html)
- [CI4 Sessions](https://codeigniter.com/user_guide/libraries/sessions.html)
- [CI4 Validation](https://codeigniter.com/user_guide/libraries/validation.html)
- [Dompdf GitHub](https://github.com/dompdf/dompdf)
- [Chart.js Docs](https://www.chartjs.org/docs/latest/)
- [Bootstrap 5](https://getbootstrap.com/docs/5.3/)
