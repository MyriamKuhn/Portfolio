# Utilisation d'une image de base PHP avec Apache
FROM php:8.3-apache

# Installation des extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip

# Installation de Composer pour gérer les dépendances PHP comme PHPMailer et Dotenv
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Activer le module de réécriture Apache
RUN a2enmod rewrite

# Installation de Node.js et npm pour gérer Bootstrap et SASS
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g sass

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les répertoires spécifiques du projet
COPY App/ /var/www/html/App/
COPY assets/ /var/www/html/assets/
COPY vendors/ /var/www/html/vendors/
COPY index.html /var/www/html/index.html
COPY main.js /var/www/html/main.js
COPY composer.json composer.lock ./

# Installer les dépendances PHP avec Composer
RUN composer install

# Installation des dépendances front-end via npm
RUN npm install

# Compiler les fichiers SASS en CSS
RUN npm run build:sass

# Accorder les permissions pour Apache
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80 pour Apache
EXPOSE 80