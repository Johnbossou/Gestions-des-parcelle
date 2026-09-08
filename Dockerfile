# ---------- Stage 1 : dépendances PHP ----------
FROM composer:2 AS composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

# ---------- Stage 2 : assets Vite ----------
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY resources/css resources/css
COPY resources/js resources/js
COPY vite.config.js ./
RUN npm run build

# ---------- Stage 3 : runtime PHP-FPM ----------
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        mbstring \
        gd \
        zip \
        intl \
        exif \
        opcache \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY --from=composer /app/vendor ./vendor
COPY . .

COPY --from=assets /app/public/build ./public/build

RUN php artisan package:discover --ansi

RUN chown -R www-data:www-data storage bootstrap/cache public

USER www-data

EXPOSE 8080

CMD ["sh", "-c", "php artisan migrate --force --no-interaction && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]