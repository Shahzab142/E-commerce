#!/bin/bash
set -e

PORT="${PORT:-8080}"
echo "Configuring Apache to listen on port ${PORT}..."

# Update Apache port dynamically for Render
sed -i "s/Listen [0-9]*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Ensure APP_KEY exists
if [ -z "$APP_KEY" ]; then
    echo "Warning: APP_KEY not provided. Using default encryption key..."
    export APP_KEY="base64:/jveEbPwfVseoXlQLvZbmbO+Mx1sL9zf8nb+qQDe+Do="
fi

# Ensure storage directories exist and have proper permissions
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache \
         /var/www/html/database
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# If no external database is provided, fallback to SQLite
if [ -z "$DATABASE_URL" ] && [ -z "$DB_HOST" ]; then
    echo "No external database credentials found. Setting up SQLite database..."
    export DB_CONNECTION=sqlite
    export DB_DATABASE=/var/www/html/database/database.sqlite
    touch /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
    chmod 777 /var/www/html/database/database.sqlite
fi

# Clear any cached configuration first
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

# Run migrations and seed default demo users
echo "Running database migrations and seeders..."
php artisan migrate --force --seed || php artisan migrate --force || true

# Optimize cache for production
echo "Caching configuration and routes..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Starting Apache on port ${PORT}..."
exec apache2-foreground
