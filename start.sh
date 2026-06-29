#!/bin/bash
set -e

echo "=== [0/5] Pre-flight checks ==="
if [ ! -f .env ]; then
    echo "No .env found, creating one..."
    cp .env.example .env || touch .env
fi
touch database/database.sqlite || true

echo "=== [1/5] Generating app key if missing ==="
php artisan key:generate --no-interaction --force 2>/dev/null || echo "Key already set or failed (non-fatal)"

echo "=== [2/5] Caching config/routes/views ==="
php artisan config:cache || echo "config:cache failed (non-fatal)"
php artisan route:cache  || echo "route:cache failed (non-fatal)"
php artisan view:cache   || echo "view:cache failed (non-fatal)"

echo "=== [3/5] Running migrations ==="
php artisan migrate --force --no-interaction || echo "migrate failed (non-fatal, DB may not be ready)"

echo "=== [4/5] Linking storage ==="
php artisan storage:link 2>/dev/null || true

echo "=== [5/5] Starting Laravel server on port ${PORT:-8000} ==="
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
