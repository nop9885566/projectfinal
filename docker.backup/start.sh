#!/bin/bash
set -e

cd /var/www/html

echo "==> Creating .env if missing..."
if [ ! -f .env ]; then
    cp .env.example .env 2>/dev/null || touch .env
fi

echo "==> Running composer post-install scripts..."
composer run-script post-autoload-dump 2>/dev/null || true

echo "==> Clearing old cache..."
php artisan config:clear 2>/dev/null || true
php artisan cache:clear  2>/dev/null || true

echo "==> Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Checking DB connection..."
php artisan db:show 2>/dev/null || echo "DB not ready yet (non-fatal)"

echo "==> Running migrations..."
php artisan migrate --force --no-interaction || echo "migrate failed - check DB env vars"

echo "==> Linking storage..."
php artisan storage:link 2>/dev/null || true

echo "==> Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

echo "==> Starting services via Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf

