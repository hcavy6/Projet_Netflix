## Prérequis

  * PHP 8.4
  * Composer
  * Docker (pour la base de données MariaDB)
  * Symfony CLI

## Installation

1.  **Récupérer le projet**
    Clonez ce dépôt et placez-vous dans le dossier du projet.

2.  **Installer les dépendances**

    ```bash
    composer install
    ```

3.  **Configurer l'environnement**
    Créez un fichier `.env.local` pour définir vos variables spécifiques (ou modifiez `.env`) :

      * Base de données : `DATABASE_URL` (par défaut configuré pour le conteneur Docker fourni).
      * Emails : `MAILER_DSN` (nécessaire pour l'envoi des tokens de validation).
      * API TMDb: `TMDB_API_KEY` (clé API requise pour récupérer les films).

4.  Lancer la base de données

    ```bash
    docker compose up -d
    ```

5.  Mettre à jour la base de données
    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

 Démarrage

Lancez le serveur de développement :

```bash
symfony serve -d
```

L'application est accessible sur `http://127.0.0.1:8000`.

Fonctionnalités principales

  * Inscription et Connexion : Création de compte avec validation obligatoire de l'email via un lien envoyé par courriel.
  * Page d'accueil : Liste les utilisateurs inscrits et affiche les films populaires récupérés depuis l'API TMDb.
  * Sécurité : Authentification gérée par le composant Security de Symfony avec un vérificateur d'utilisateur personnalisé (`ConfirmEmailUserChecker`).

Structure

  * `src/Controller` : Contient la logique pour l'accueil et la gestion des utilisateurs.
  * `src/Entity` : Définit les données (User, Token, Watchlist).
  * `src/Service` : Contient le service d'appel à l'API TMDb.
  * `src/Business` : Gère la logique de création des tokens.
