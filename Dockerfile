FROM php:8.3-cli

# dashboard only → pcntl unnecessary
RUN apt-get update && apt-get install -y git unzip libzip-dev \
    && docker-php-ext-install pdo_mysql zip \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# ignore pcntl requirement when installing Horizon
RUN composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-pcntl

# tiny built-in HTTP server is fine for local use
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]