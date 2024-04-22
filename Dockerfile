FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd
RUN a2enmod rewrite
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -  &&\
    apt-get install -y nodejs
COPY . /var/www/html
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm install && \
    npm runnpm
RUN chown -R www-data:www-data /var/www/html
#RUN php /var/www/html/artisan migrate --force && \
#    php /var/www/html/artisan db:seed --force
EXPOSE 80
