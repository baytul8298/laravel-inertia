FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev gettext libgettextpo-dev libicu-dev libonig-dev \
    libxml2-dev libpq-dev libpng-dev libjpeg-dev libfreetype6-dev libssl-dev \
    libmagickwand-dev imagemagick git curl nano gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gettext gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js 20 + npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install and configure Xdebug
RUN pecl install xdebug imagick \
    && docker-php-ext-enable xdebug imagick

# Set working directory
WORKDIR /var/www/html

# Use non-root user
USER www-data





















#FROM php:8.2-fpm
#
## Install system dependencies
#RUN apt-get update && apt-get install -y \
#    zip \
#    unzip \
#    libzip-dev \
#    gettext \
#    libgettextpo-dev \
#    libicu-dev \
#    libonig-dev \
#    libxml2-dev \
#    libpq-dev \
#    libpng-dev \
#    libjpeg-dev \
#    libfreetype6-dev \
#    libssl-dev \
#    git \
#    curl \
#    nano \
#    && docker-php-ext-install pdo_mysql zip gettext \
#    && apt-get clean \
#    && rm -rf /var/lib/apt/lists/*
#
## Optional: Install and configure Xdebug for PHP 8.2
#RUN pecl install xdebug \
#    && docker-php-ext-enable xdebug \
#    && rm -rf /tmp/pear \
#    && apt-get clean \
#    && rm -rf /var/lib/apt/lists/*
#
## Set working directory
#WORKDIR /var/www/html
#
## Use non-root user for better security
#USER www-data

