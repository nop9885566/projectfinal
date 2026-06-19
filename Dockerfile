# ──────────────────────────────────────────────
# Stage 1 – Build frontend assets (Node / Vite)
# ──────────────────────────────────────────────
FROM node:22-alpine AS node-build

WORKDIR /app

COPY package.json bun.lock* package-lock.json* ./
RUN npm install --frozen-lockfile 2>/dev/null || npm install

COPY . .
RUN npm run build

# ──────────────────────────────────────────────
# Stage 2 – PHP 8.4 production image
# ──────────────────────────────────────────────
FROM php:8.4-fpm-alpine AS php-base

# Install system dependencies
RUN apk add --no-cache \
    bash \
    curl \
    git \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    mysql-client \
    icu-dev \
    freetype-dev \
    libjpeg-turbo-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first (for layer caching)
COPY composer.json composer.lock ./

# Install PHP dependencies (no dev, no scripts yet)
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --optimize-autoloader \
    --prefer-dist

# Copy application source
COPY . .

# Copy built frontend assets from node-build stage
COPY --from=node-build /app/public/build ./public/build

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# ──────────────────────────────────────────────
# Nginx configuration
# ──────────────────────────────────────────────
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# ──────────────────────────────────────────────
# PHP-FPM configuration
# ──────────────────────────────────────────────
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# ──────────────────────────────────────────────
# Supervisor configuration (nginx + php-fpm)
# ──────────────────────────────────────────────
COPY docker/supervisord.conf /etc/supervisord.conf

# Startup script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
