# AgentFlow — Documentation de déploiement

## Prérequis

| Composant | Version recommandée |
|-----------|-------------------|
| Debian    | 11 (Bullseye) ou 12 (Bookworm) |
| Apache    | 2.4+ |
| PHP       | 8.1+ |
| MariaDB   | 10.6+ |

Extensions PHP requises : `pdo`, `pdo_mysql`, `mbstring`

---

## 1. Installation des paquets

```bash
sudo apt update && sudo apt upgrade -y

# Apache + PHP + MariaDB
sudo apt install -y apache2 php php-mysql php-mbstring mariadb-server git

# Vérification
apache2 -v
php -v
mysql --version
```

---

## 2. Cloner le projet

```bash
sudo mkdir -p /var/www/agentflow
sudo git clone https://github.com/phamnhathuyhuynh-collab/agentflow.git /var/www/agentflow

# Permissions
sudo chown -R www-data:www-data /var/www/agentflow
sudo chmod -R 755 /var/www/agentflow
```

---

## 3. Configuration Apache VirtualHost

```bash
# Copier le fichier de configuration
sudo cp /var/www/agentflow/agentflow.conf /etc/apache2/sites-available/agentflow.conf

# Activer le site
sudo a2ensite agentflow.conf

# Désactiver le site par défaut (optionnel)
sudo a2dissite 000-default.conf

# Recharger Apache
sudo systemctl reload apache2
```

Ajouter dans `/etc/hosts` (sur la machine cliente) :
```
127.0.0.1   agentflow.local
```

---

## 4. Configuration de la base de données

```bash
# Sécuriser MariaDB
sudo mysql_secure_installation

# Se connecter
sudo mysql -u root -p

# Dans MySQL :
CREATE USER 'agentflow'@'localhost' IDENTIFIED BY 'motdepasse';
GRANT ALL PRIVILEGES ON agentflow.* TO 'agentflow'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Initialiser le schéma :
```bash
sudo mysql -u root -p < /var/www/agentflow/docs/schema.sql
```

---

## 5. Configuration de l'application

Éditer `/var/www/agentflow/src/Config/database.php` :

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'agentflow');
define('DB_USER', 'agentflow');
define('DB_PASS', 'motdepasse');
```

---

## 6. Vérifications

Ouvrir dans le navigateur : `http://agentflow.local`

Parcours de test minimal :
1. Accéder à `http://agentflow.local` → liste des agents (vide)
2. Créer un agent via le formulaire
3. Depuis la page agent, lancer un run
4. Vérifier que le run passe à `done` avec un résultat simulé
5. Tester le bouton "Mode compact" → vérifier le cookie dans les DevTools

---

## Structure du projet

```
/public           → Point d'entrée (index.php) + assets
/src/Controller   → AgentController.php, RunController.php
/src/Model        → AgentModel.php, RunModel.php, Database.php
/src/View         → agent/, run/, layout/, errors/
/src/Config       → database.php, models.php
/docs             → schema.sql
agentflow.conf    → Configuration Apache VirtualHost
README.md         → Ce fichier
```
