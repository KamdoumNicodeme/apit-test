
# APi Localisation Tracker

Ce projet est une application web qui suit la localisation des utilisateurs et affiche leurs positions sur une carte. L'application utilise Laravel pour l'API backend et Angular pour le frontend.


## Caractéristiques

- API RESTful qui permet aux utilisateurs de s'inscrire et de s'authentifier.
- Les utilisateurs peuvent ajouter leur emplacement actuel en soumettant leur latitude et leur longitude à l'API.
- Les utilisateurs peuvent visualiser leur position actuelle et celle des autres utilisateurs sur une carte.
- La carte est mise à jour en temps réel au fur et à mesure que les utilisateurs ajoutent leur position.

## Exigences techniques

- Laravel : https://laravel.com/docs/8.x
- Angular : https://angular.io/docs
- Node.js : https://nodejs.org/en/docs/
- Socket.IO : https://socket.io/docs/v4/
- Docker : https://docs.docker.com/
- Nginx : https://nginx.org/en/docs/

## Installation

#### 1- executer la commande composer create-project laravel/laravel apit-test une fois apres avoir telecharger composer
#### 2- configuration d'un fichier docker-compose.yml contenant toutes les exigences techniques backend
#### 3- configuration d'un fichier Dockerfile pour l'execution en mode production 


##### detail docker-compose.yml 
- La version 3.9 de Docker Compose est utilisée.
- Un réseau nommé "webapp" est défini pour connecter les services.
- Trois services sont définis : nginx, php et mysql.
- Le service "nginx" utilise l'image nginx:stable-alpine pour le serveur web. Il est lié au service "php", qui fournit le backend de l'application. Le port 8000 du conteneur est exposé sur le port 80 de l'hôte. Les fichiers de configuration et de logs sont montés en tant que volumes pour le conteneur.
- Le service "php" utilise un Dockerfile pour construire une image personnalisée contenant l'application Laravel et les dépendances nécessaires. Le port 9001 du conteneur est exposé sur le port 9000 de l'hôte. Les fichiers de l'application sont montés en tant que volume pour le conteneur.
- Le service "mysql" utilise l'image mysql:8.0 pour la base de données. Le port 3306 du conteneur est exposé sur le port 3306 de l'hôte. Les fichiers de la base de données sont montés en tant que volume pour le conteneur. Les variables d'environnement sont définies pour spécifier le nom de la base de données, le mot de passe root et le nom du service MySQL.
- Les services "nginx" et "php" dépendent du service "mysql" pour pouvoir fonctionner correctement.
- Tous les services sont connectés au réseau "webapp" pour pouvoir communiquer entre eux.

#### detail dockerfile


- La première ligne FROM php:8.2.4-fpm-alpine spécifie la version de l'image de base à utiliser, qui est l'image officielle de PHP FPM (FastCGI Process Manager) Alpine 8.2.4.

- La commande RUN permet d'exécuter des commandes dans l'image Docker en cours de construction. Dans ce cas, la commande apk add --no-cache nodejs yarn installe Node.js et Yarn dans l'image Docker, et docker-php-ext-install pdo pdo_mysql installe les extensions PHP PDO et PDO MySQL.

- La commande suivante RUN curl -sS https://getcomposer.org/installer |php -- --install-dir=/usr/local/bin --filename=composer télécharge et installe Composer, un gestionnaire de dépendances pour PHP.

- Enfin, la commande WORKDIR /var/www/html définit le répertoire de travail dans l'image Docker. Cela permettra à l'application PHP d'être exécutée à partir de ce répertoire lorsqu'elle sera exécutée dans un conteneur Docker.


