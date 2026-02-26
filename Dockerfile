# ---- Build frontend assets (Vite) ----
FROM node:20-alpine AS nodebuild
WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY resources ./resources
COPY vite.config.js ./

RUN npm run build


# ---- Build PHP deps (Composer) ----
FROM composer:2 AS vendor
WORKDIR /app

# Copy composer files first (cache-friendly)
COPY composer.json composer.lock ./

# Copy minimum Laravel files needed so post-install scripts can run
COPY artisan ./artisan
COPY bootstrap ./bootstrap
COPY config ./config
COPY app ./app
COPY routes ./routes
COPY resources ./resources

RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader


# ---- Runtime: PHP (use built-in server on Render $PORT) ----
FROM php:8.4-cli

# System deps + PHP extensions commonly needed by Laravel
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
  && docker-php-ext-install pdo_mysql zip \
  && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy full app
COPY . .

# Bring in vendor + built assets from previous stages
COPY --from=vendor /app/vendor ./vendor
COPY --from=nodebuild /app/public/build ./public/build

# Permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Render provides $PORT. Serve Laravel from /public.
CMD ["bash", "-lc", "php -S 0.0.0.0:${PORT} -t public"]