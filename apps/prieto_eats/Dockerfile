# ============================================================
# STAGE 1 — Build de assets frontend (Vite + TailwindCSS)
# ============================================================
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

# ============================================================
# STAGE 2 — PHP 8.2 + Apache (imagen final de producción)
# ============================================================
FROM php:8.2-apache

# Habilitar mod_rewrite (necesario para las rutas de Laravel)
RUN a2enmod rewrite

# Instalar dependencias del sistema y extensiones PHP para Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libpq-dev libzip-dev \
    && docker-php-ext-install \
        pdo pdo_pgsql \
        mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer desde su imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Apuntar DocumentRoot al /public de Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Copiar el código fuente
COPY . .

# Copiar los assets compilados desde el stage de frontend
COPY --from=frontend /app/public/build ./public/build

# Instalar dependencias PHP solo de producción
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Copiar y activar el entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
