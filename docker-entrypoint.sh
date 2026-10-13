#!/bin/bash
set -e

PORT="${PORT:-8080}"
echo "Configuring Apache to listen on port ${PORT}..."

# Update Apache port dynamically for Render
sed -i "s/Listen [0-9]*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Ensure storage and database directories exist with full write permissions
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache \
         /var/www/html/database

touch /var/www/html/database/database.sqlite
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Default APP_KEY if missing
FINAL_KEY="${APP_KEY:-base64:/jveEbPwfVseoXlQLvZbmbO+Mx1sL9zf8nb+qQDe+Do=}"

# Determine DB Driver
if [ -n "$DATABASE_URL" ]; then
    DB_CONN="pgsql"
elif [ -n "$DB_HOST" ]; then
    DB_CONN="${DB_CONNECTION:-mysql}"
else
    DB_CONN="sqlite"
fi

# Write runtime .env file so Apache, PHP, and Artisan all have access to configuration
cat <<EOF > /var/www/html/.env
APP_NAME="${APP_NAME:-Khyber Pro}"
APP_ENV="${APP_ENV:-production}"
APP_KEY="${FINAL_KEY}"
APP_DEBUG="${APP_DEBUG:-true}"
APP_URL="${APP_URL:-http://localhost}"

LOG_CHANNEL=stderr
LOG_LEVEL=debug

DB_CONNECTION=${DB_CONN}
DB_DATABASE=${DB_DATABASE:-/var/www/html/database/database.sqlite}
DB_HOST=${DB_HOST:-}
DB_PORT=${DB_PORT:-}
DB_USERNAME=${DB_USERNAME:-}
DB_PASSWORD=${DB_PASSWORD:-}
DATABASE_URL=${DATABASE_URL:-}

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
EOF

chmod 666 /var/www/html/.env
chown www-data:www-data /var/www/html/.env

# Clear stale caches
echo "Clearing previous caches..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Package discovery
echo "Discovering packages..."
php artisan package:discover --ansi || true

# Create storage symlink
if [ ! -L /var/www/html/public/storage ]; then
    echo "Linking storage..."
    php artisan storage:link || true
fi

# Run database migrations and seed default users
echo "Running database migrations..."
php artisan migrate --force || true
php artisan db:seed --force || true

# Cache configs and routes with runtime variables
echo "Caching configuration and routes..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Starting Apache on port ${PORT}..."
exec apache2-foreground
