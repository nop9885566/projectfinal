#!/bin/bash
set -e

echo "=== [0/5] Pre-flight checks ==="
if [ ! -f .env ]; then
    echo "No .env found, creating one..."
    cp .env.example .env || touch .env
fi
touch database/database.sqlite || true

echo "=== [1/5] Generating app key if missing ==="
php artisan key:generate --no-interaction --force || true

echo "=== [2/5] Creating storage directories ==="
mkdir -p storage/framework/{sessions,views,cache} storage/logs
chmod -R 775 storage bootstrap/cache || true

echo "=== [3/5] Running migrations ==="
php artisan migrate --force --no-interaction || true

echo "=== [4/5] Linking storage ==="
php artisan storage:link || true

echo "=== [5/5] Clearing caches ==="
php artisan optimize:clear || true

echo "=== [6/6] Starting PHP server on port ${PORT:-8000} ==="
exec php -S 0.0.0.0:${PORT:-8000} -t public/
