# Installation du Projet EMISA ANNUAIRE

Ce guide décrit les étapes nécessaires pour installer et lancer ce projet Symfony en local.

## Prérequis
Avant de commencer, assure-toi d'avoir les outils suivants installés sur ta machine :

- [PHP](https://www.php.net/) (≥ 8.1 recommandé)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/)
- [Symfony CLI](https://symfony.com/download)

---

## Installation

### 1. Configuration de l'environnement
Copie le fichier `.env` en `.env.local` :

```bash
cp .env .env.local
```

### 2. Configuration de la connexion à la base de données

- Ouvre le fichier `.env.local`.
- **Commente** la ligne de connexion PostgreSQL :
  ```
  # DATABASE_URL="postgresql://..."
  ```
- **Décommente** la ligne de connexion MySQL :
  ```
  DATABASE_URL="mysql://user:password@127.0.0.1:3306/database_name?serverVersion=8.0"
  ```
- Remplace `user`, `password` et `database_name` par tes propres informations de connexion MySQL.

### 3. Installation des dépendances
Exécute la commande suivante pour installer toutes les dépendances du projet :

```bash
composer install
```

### 4. Création de la base de données
Crée la base de données configurée précédemment :

```bash
php bin/console doctrine:database:create
```

### 5. Exécution des migrations
Applique les migrations pour configurer les tables de la base de données :

```bash
php bin/console doctrine:migrations:migrate
```

### 6. Lancer le serveur de développement
Utilise Symfony CLI pour lancer le serveur local :

```bash
symfony serve
```

---

## Accéder à l'application
Une fois le serveur lancé, accède à l'application via l'URL suivante :

```
http://127.0.0.1:8000
```

---

## Notes
- Si tu rencontres des erreurs liées aux dépendances ou à la configuration PHP, assure-toi que toutes les extensions PHP nécessaires sont activées.
- Pour vérifier que tout fonctionne correctement, tu peux exécuter :

```bash
php bin/console debug:router
```

---

Bonne installation ! ✅
