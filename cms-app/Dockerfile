FROM php:8.3-cli AS base

RUN apt-get update \
 && apt-get install -y git unzip libzip-dev libpq-dev libicu-dev zlib1g-dev \
 && docker-php-ext-install pdo_mysql intl zip \
 && pecl install redis \
 && docker-php-ext-enable redis \
 # Horizon workers need pcntl & posix
 && docker-php-ext-install pcntl posix

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

CMD ["php", "/app/artisan", "horizon"]