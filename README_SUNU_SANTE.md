# 🌟 Sunu Santé - Plateforme de Gestion des Demandes d'Assurance Santé

## 📋 Vue d'ensemble

**Sunu Santé** est une plateforme professionnelle de gestion des demandes d'assurance santé développée en Laravel 12. Elle permet aux entreprises de gérer efficacement leurs polices d'assurance santé et de suivre les demandes de leurs employés.

## 🎯 Fonctionnalités principales

### ✅ **Gestion des entreprises clientes**
- Création et gestion des profils d'entreprises
- Attribution de tokens d'accès uniques
- Suivi des statistiques (utilisateurs, assurés)

### ✅ **Gestion des assurés**
- Import en masse via fichiers Excel
- Création automatique des comptes utilisateurs
- Attribution automatique des rôles et permissions
- Envoi automatique des identifiants de connexion par email

### ✅ **Workflow des demandes**
- Création et suivi des demandes d'assurance
- Processus de validation par les gestionnaires
- Statuts multiples (en attente, validée, rejetée)
- Commentaires et pièces justificatives

### ✅ **Système d'authentification sécurisé**
- Rôles et permissions granulaires (Admin, Gestionnaire, Assuré)
- Changement de mot de passe obligatoire à la première connexion
- Gestion des sessions et sécurité

### ✅ **Import/Export Excel**
- Template Excel personnalisé avec instructions
- Validation des données lors de l'import
- Export des données des assurés
- Gestion des erreurs et logs

## 🏗️ Architecture technique

### **Framework et technologies**
- **Laravel 12.22.1** - Framework PHP moderne
- **SQLite** (développement) / **MySQL** (production)
- **Bootstrap 5.3.0** - Framework CSS responsive
- **Font Awesome 6.0** - Icônes vectorielles
- **Alpine.js** - Interactions JavaScript légères

### **Packages principaux**
- **Laravel Breeze** - Authentification et autorisation
- **Spatie Laravel Permission** - Gestion des rôles et permissions
- **Maatwebsite Excel** - Import/Export de fichiers Excel
- **DomPDF** - Génération de PDF (à implémenter)

### **Structure de la base de données**
```
users (utilisateurs avec rôles)
├── clients (entreprises clientes)
├── assures (profils des assurés)
├── beneficiaires (membres de famille)
├── demandes (demandes d'assurance)
└── cartes (cartes d'assurance)
```

## 🚀 Installation et configuration

### **Prérequis**
- PHP 8.2+
- Composer 2.0+
- Node.js 18+ (pour les assets)
- SQLite ou MySQL

### **Installation**

1. **Cloner le projet**
```bash
git clone [url-du-repo]
cd sunu-sante
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Installer les dépendances Node.js**
```bash
npm install
```

4. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configuration de la base de données**
```bash
# Dans .env
DB_CONNECTION=sqlite
DB_DATABASE=/chemin/vers/database.sqlite
```

6. **Exécuter les migrations et seeders**
```bash
php artisan migrate
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=ClientSeeder
```

7. **Démarrer le serveur**
```bash
php artisan serve
```

### **Configuration de l'email**
```bash
# Dans .env
MAIL_MAILER=log  # Pour le développement (logs dans storage/logs)
MAIL_MAILER=smtp # Pour la production
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-app
MAIL_ENCRYPTION=tls
```

## 👥 Utilisateurs par défaut

### **Administrateur**
- **Email :** `admin@sunusante.com`
- **Mot de passe :** `password`
- **Rôle :** Administrateur complet

### **Gestionnaire d'assurance**
- **Email :** `gestionnaire@sunusante.com`
- **Mot de passe :** `password`
- **Rôle :** Gestion des demandes et des assurés

## 🔐 Système de rôles et permissions

### **Administrateur**
- Gestion complète des utilisateurs
- Création et gestion des entreprises clientes
- Attribution des gestionnaires aux entreprises
- Accès à toutes les fonctionnalités

### **Gestionnaire d'assurance**
- Gestion des assurés de son entreprise
- Traitement des demandes d'assurance
- Import/export des données
- Gestion des bénéficiaires

### **Assuré**
- Consultation de son profil
- Création de demandes d'assurance
- Suivi de l'état de ses demandes
- Gestion de ses informations personnelles

## 📊 Workflow d'utilisation

### **1. Création d'une entreprise**
- L'administrateur crée le profil de l'entreprise
- Un gestionnaire d'assurance est assigné
- L'entreprise reçoit un token d'accès unique

### **2. Import des employés**
- Le gestionnaire télécharge le template Excel
- Remplit le fichier avec les informations des employés
- Importe le fichier dans le système
- Les comptes sont créés automatiquement
- Les identifiants sont envoyés par email

### **3. Première connexion des employés**
- L'employé reçoit ses identifiants par email
- Se connecte avec le mot de passe temporaire
- Doit changer son mot de passe immédiatement
- Accède à son espace personnel

### **4. Gestion des demandes**
- L'assuré crée une demande d'assurance
- Le gestionnaire traite la demande
- Statut mis à jour (validée/rejetée)
- Notifications automatiques

## 🎨 Personnalisation du design

### **Couleurs de l'entreprise**
```css
:root {
    --primary-color: #2E86AB;      /* Bleu principal */
    --secondary-color: #A23B72;    /* Violet secondaire */
    --accent-color: #F18F01;       /* Orange accent */
    --success-color: #C73E1D;      /* Rouge succès */
    --dark-color: #1B1B1E;         /* Noir profond */
}
```

### **Fichiers de style**
- `public/css/sunu-sante.css` - Styles personnalisés
- Variables CSS pour la cohérence visuelle
- Design responsive et moderne

## 📁 Structure des fichiers

```
sunu-sante/
├── app/
│   ├── Http/Controllers/     # Contrôleurs
│   ├── Models/              # Modèles Eloquent
│   ├── Imports/             # Classes d'import Excel
│   ├── Exports/             # Classes d'export Excel
│   ├── Notifications/       # Notifications email
│   └── Http/Middleware/     # Middlewares
├── database/
│   ├── migrations/          # Migrations de base de données
│   ├── seeders/             # Seeders pour les données de test
│   └── factories/           # Factories pour les tests
├── resources/views/         # Vues Blade
├── routes/                  # Définition des routes
├── public/                  # Assets publics
└── config/                  # Configuration
```

## 🔧 Développement et maintenance

### **Commandes utiles**
```bash
# Créer une nouvelle migration
php artisan make:migration nom_de_la_migration

# Créer un nouveau contrôleur
php artisan make:controller NomController

# Créer un nouveau modèle
php artisan make:model Nom

# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Regénérer l'autoloader
composer dump-autoload
```

### **Logs et débogage**
- **Logs d'application :** `storage/logs/laravel.log`
- **Logs d'email :** `storage/logs/laravel.log` (avec MAIL_MAILER=log)
- **Erreurs d'import :** Loggées automatiquement

## 🚀 Déploiement en production

### **Configuration recommandée**
- **Serveur web :** Nginx ou Apache
- **PHP :** 8.2+ avec extensions requises
- **Base de données :** MySQL 8.0+ ou PostgreSQL
- **Cache :** Redis ou Memcached
- **Queue :** Redis ou base de données

### **Variables d'environnement critiques**
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com
DB_CONNECTION=mysql
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
MAIL_MAILER=smtp
```

## 📞 Support et contact

### **Équipe de développement**
- **Email :** dev@sunusante.com
- **Documentation :** [URL de la documentation]
- **Issues :** [URL du système de tickets]

### **Maintenance et mises à jour**
- Mises à jour de sécurité automatiques
- Sauvegardes quotidiennes de la base de données
- Monitoring 24/7 des performances

## 🔮 Évolutions futures

### **Phase 2 (en cours)**
- [ ] Génération de PDF pour les cartes d'assurance
- [ ] Notifications en temps réel
- [ ] API REST pour intégrations tierces
- [ ] Tableau de bord avancé avec graphiques

### **Phase 3 (planifiée)**
- [ ] Application mobile (React Native)
- [ ] Intégration avec des systèmes de paie
- [ ] Module de facturation
- [ ] Système de rapports avancés

---

**Sunu Santé** - Votre santé, notre priorité 🏥

*Dernière mise à jour : Août 2025*
