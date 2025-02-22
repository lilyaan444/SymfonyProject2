# 🏢 Backoffice Symfony - Projet de Gestion de Clients et Produits - Lilyan MULLER

> **Note :** Ce projet est un backoffice destiné à la gestion des utilisateurs, des produits et des clients dans une petite entreprise. Il a été développé dans le cadre d'un projet de ma troisième année de BUT Informatique.

---

## 📹 Présentation Vidéo



https://github.com/user-attachments/assets/0104e0e9-0047-4715-8cb9-6c44125d4f5e


---

## 📝 Table des matières
1. [Aperçu du projet](#-aperçu-du-projet)
2. [Fonctionnalités](#-fonctionnalités)
3. [Installation](#-installation)
4. [Utilisation](#-utilisation)
5. [Technologies utilisées](#-technologies-utilisées)
6. [Tests](#-tests)

---

## 🌟 Aperçu du Projet

Ce projet est un backoffice développé avec Symfony permettant de gérer les utilisateurs, les produits et les clients d'une entreprise. Il inclut des fonctionnalités comme l'importation de produits depuis un fichier CSV, la gestion des utilisateurs avec différents rôles et la possibilité d'ajouter et modifier des informations clients. Il utilise également un système de sécurité pour restreindre l'accès à certaines sections selon les rôles des utilisateurs.

---

## ✨ Fonctionnalités

- **Gestion des utilisateurs** : 
  - Lister, ajouter, modifier (sauf mot de passe) et supprimer des utilisateurs (seulement pour les administrateurs).
  - Implémentation de rôles (`ROLE_ADMIN`, `ROLE_USER`, `ROLE_MANAGER`) pour restreindre l'accès.
- **Gestion des produits** : 
  - Ajouter, modifier et supprimer des produits (seulement pour les administrateurs).
  - Tri des produits par prix décroissant.
  - Exportation des produits en format CSV.
  - Importation de produits depuis un fichier CSV.
- **Gestion des clients** : 
  - Ajouter, modifier et lister des clients (gestionnaires et administrateurs uniquement).
  - Validation des champs clients (email, prénom, nom) et vérification de l'unicité des emails.
- **Sécurité** : 
  - Système de connexion sécurisé avec authentification.
  - Restriction d'accès aux différentes sections selon le rôle de l'utilisateur.

---

## 🚀 Installation

### Installation avec IDX

1. **Forker le projet**  
   Forkez-le dépot actuel sur votre compte GitHub.

2. **Importer le projet sur IDX**  
   Connectez-vous à IDX et importez votre fork du projet depuis votre dépôt GitHub.
   
4. **Changer de branch**  
   Dans le terminal de votre projet :
   - git checkout -b MinecraftShop origin/MinecraftShop

5. **Démarrer le projet**  
   Une fois le projet importé et le checkout effectuer, il devrait être automatiquement lancé sur IDX. Accédez à l'onglet "Terminal", cliquez sur `start`, puis ouvrez le lien localhost pour visualiser l'application.

6. **Installer les dépendances**  
   Dans le terminal de votre projet :
   - Lancez la commande : `composer install` pour installer les dépendances PHP.
   - Puis la commande : `npm install` et `encore dev`

7. **Configurer la base de données**  
   - Connectez-vous à MySQL en utilisant : `mysql -u root`.  
   - Créez la base de données :  
     ```sql
     CREATE DATABASE MC;
     ```
   - Exécutez les commandes suivantes pour configurer les tables et charger les données de test :  
     ```bash
     php bin/console doctrine:schema:update --force
     php bin/console doctrine:fixtures:load
     ```

8. **Configurer les variables d'environnement**  
    Créez un fichier `.env.local` à la racine du projet et ajoutez la ligne suivante pour configurer         l'accès à la base de données :  
    ```
    DATABASE_URL="mysql://root:@127.0.0.1:3306/MC?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
    ```

9. **Compiler les assets**  
   Si vous utilisez Tailwind CSS, compilez les assets avec :
   ```bash
   php bin/console tailwind:build
   ```

10. **Créer la base de données**  
   Créez la base de données et appliquez les migrations :
   ```bash
   php bin/console doctrine:schema:update --force
   ```

11. **Charger des données de test**  
   Ajoutez des données de test dans la base avec :
   ```bash
   php bin/console doctrine:fixtures:load
   ```

   Vous pouvez maintenant accéder à l'application via `http://localhost:8000`.

---

## 📖 Utilisation

1. **Connexion** : Accédez à l'interface de connexion pour vous authentifier. Les utilisateurs sont définis dans les fixtures du projet.
2. **Gestion des utilisateurs** : L'administrateur peut gérer les utilisateurs (ajouter, modifier, supprimer) via l'onglet "Utilisateurs".
3. **Gestion des produits** : Les administrateurs peuvent ajouter, modifier, supprimer des produits et importer la liste en CSV via la commande "php bin/console app:import-products public/products.csv".
4. **Gestion des clients** : Les gestionnaires et administrateurs peuvent ajouter et modifier des clients via l'onglet "Clients" ou la commande "php bin/console app:create-client".

---

## 💻 Technologies utilisées

- **Backend** : Symfony 5, Doctrine ORM
- **Frontend** : Twig, Tailwind CSS
- **Base de données** : MariaDB
- **Sécurité** : Symfony Security (authentification et autorisation)
- **Import/Export CSV** : PHP, Symfony Console

---

## 🧪 Tests

Des tests unitaires ont été écrits pour les services critiques du projet, y compris :
- Test de création d'un utilisateur, produit ou client avec un mock ou stub.
- Test des fonctionnalités de gestion des produits et clients.

Pour exécuter les tests, utilisez la commande suivante :
```bash
php bin/console doctrine:fixtures:load
php bin/console phpunit
```
