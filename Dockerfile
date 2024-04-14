FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -  &&\
    apt-get install -y nodejs

COPY . /var/www/html

RUN composer install --no-interaction --prefer-dist --optimize-autoloader && \
    npm install && \
    npm run prod

RUN chown -R www-data:www-data /var/www/html
EXPOSE 80
