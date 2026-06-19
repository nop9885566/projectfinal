#!/bin/bash
set -e

cd /var/www/html

echo "==> Running composer post-install scripts..."
composer run-script post-autoload-dump 2>/dev/null || true

echo "==> Generating application key (if not set)..."
php artisan key:generate --no-interaction --force 2>/dev/null || true

echo "==> Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Running migrations..."
php artisan migrate --force --no-interaction

echo "==> Linking storage..."
php artisan storage:link 2>/dev/null || true

echo "==> Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "==> Starting services via Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
