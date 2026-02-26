# ---- Build frontend assets (Vite) ----
FROM node:20-alpine AS nodebuild
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js ./
# if you use Tailwind config, copy it too (safe even if not present)
COPY tailwind.config.* postcss.config.* ./ 2>/dev/null || true
RUN npm run build

# ---- Build PHP deps (Composer) ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

# ---- Runtime: Apache + PHP ----
FROM php:8.3-apache

# System deps + PHP extensions commonly needed by Laravel
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
  && docker-php-ext-install pdo_mysql zip \
  && a2enmod rewrite \
  && rm -rf /var/lib/apt/lists/*

# Set Apache docroot to /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Copy app files
COPY . .

# Copy vendor from composer stage
COPY --from=vendor /app/vendor ./vendor

# Copy built assets into public/build
COPY --from=nodebuild /app/public/build ./public/build

# Permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Render uses $PORT
EXPOSE 10000
CMD ["bash", "-lc", "php artisan config:clear && php artisan route:clear && php artisan view:clear && apache2-foreground"]