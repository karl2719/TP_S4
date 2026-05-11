# TP_S4
Application web de gestion de regimes alimentaires personnalises.

## Avant de lancer le serveur
Avant `php spark serve`, lance :

```bash
composer update --lock
```

Pourquoi : si tu supprimes `vendor/` (et `writable/`), il faut un `composer.lock`
coherent avec `composer.json` pour reconstruire toutes les dependances sans erreur.

## Description rapide
Projet CodeIgniter 4 pour la gestion de regimes alimentaires personnalises.
Le front-office permet aux utilisateurs de s'inscrire, se connecter, consulter
des regimes adaptes a leur objectif (prise de poids, perte de poids, IMC ideal)
et gerer leur wallet. Le back-office permet aux admins de gerer les regimes,
les activites, les codes portefeuille et les parametres globaux.

## Fonctionnement (resume)
- Authentification front-office avec profil utilisateur et objectif nutritionnel.
- Catalogue de regimes avec prix par duree et souscription.
- Wallet pour l'achat de regimes via codes de credit.
- Option Gold (remise) et export PDF.
- Back-office pour la gestion des ressources et des statistiques.

## Routes cles
Front-office :
- `/` et `/login` : page de connexion
- `/register/step1` et `/register/step2` : inscription en 2 etapes
- `/logout` : deconnexion
- `/dashboard` : tableau de bord utilisateur
- `/profil` et `/profil/update` : profil et mise a jour
- `/regimes`, `/regimes/{id}` et `/regimes/acheter` : liste, detail et achat
- `/wallet` et `/wallet/crediter` : portefeuille et credit
- `/gold` et `/gold/activer` : option Gold
- `/export/pdf/{id}` : export PDF d'un regime

Back-office :
- `/admin` et `/admin/login` : connexion admin
- `/admin/logout` : deconnexion admin
- `/admin/dashboard` : dashboard admin
- `/admin/regimes/*` : CRUD regimes
- `/admin/activites/*` : CRUD activites
- `/admin/codes/*` : CRUD codes portefeuille
- `/admin/params` : parametres globaux
