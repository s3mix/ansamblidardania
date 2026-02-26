# ---- Build frontend assets (Vite) ----
FROM node:20-alpine AS nodebuild
WORKDIR /app

COPY package*.json ./
RUN npm ci

# Copy what Vite/Laravel typically needs
COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

RUN npm run build


# ---- Build PHP deps (Composer) ----
FROM composer:2 AS vendor
WORKDIR /app

# Cache-friendly
COPY composer.json composer.lock ./

# Copy minimum Laravel files so post-install scripts can run (artisan must exist)
COPY artisan ./artisan
COPY bootstrap ./bootstrap
COPY config ./config
COPY app ./app
COPY routes ./routes
COPY resources ./resources

RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader


# ---- Runtime: PHP (serve on Render $PORT) ----
FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
  && docker-php-ext-install pdo_mysql zip \
  && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy full app
COPY . .

# Bring in vendor + built assets
COPY --from=vendor /app/vendor ./vendor
COPY --from=nodebuild /app/public/build ./public/build

# Ensure Laravel runtime dirs exist + are writable
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

CMD ["bash", "-lc", "php -S 0.0.0.0:${PORT} -t public"]