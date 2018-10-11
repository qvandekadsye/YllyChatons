ylly Chatons
====

# Environnement de développement
 * Symfony 3.4
 * PHP version 7.2
 * Extension PHP OpenSSL
 * Mysql 5.6
 
 
 # Installation
 ## Composer
  1. Une fois le projet cloné, rendez-vous dans le dossier du projet et lancez la commande : ```composer install```
  ## Base de données
  2. Renseignez vos paramètres de base de données dans le fichier ```app/config/parameters.yml```
  3. Créez la base de données en entrant la commande ```php bin/console doctrine:schema:update --force  ```
## API
 L'API étant sécurisée, il va falloir générer des clés SSH : 
 
``` bash
Dans le dossier app du projet
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

``` bash
$ openssl rsa -in config/jwt/private.pem -out config/jwt/private2.pem
$ mv config/jwt/private.pem config/jwt/private.pem-back
$ mv config/jwt/private2.pem config/jwt/private.pem
```

Et enfin dans le fichier ```parameters.yml```, veuillez indiquez la passphrase choisie comme ceci : 
``` yml
passphrase: [votre passphrase]
```
 # Gestion du projet
 Vous trouverez un tableau Kaban du projet à cette adresse : https://github.com/qvandekadsye/Yllychatons/projects/1
 
 # Taches effectuées
 - Création des entités ```Kitty```et ```race```
 - Mise en place d'un panneau d'administration avec :
   - SonataAdmin pour l'administation en elle-même
   - SonataUserBundle pour la gestion des utilisateurs
   - Et SonataMediaBundle pour la gestion des images pour l'entité ```Kitty```
- Mise en place d'une API avec documentation pour Gérer les chatons
   - GET
        - Tous les chatons avec pagination
        - Un chaton en particulier
        - Affichage des noms des chatons uniquement lorsque l'utilisateur est anonyme
   - POST
   - PUT
   - DELETE
   - Sécurisation de l'api avec JWT
  
  # Troubleshooting
  **La clé privée SSH existe mais n'est pas trouvée par l'application**
  - Il faut changer les droits pour donner les droits en lecture
