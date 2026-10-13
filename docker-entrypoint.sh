#!/bin/bash
set -e

PORT="${PORT:-8080}"
echo "Configuring Apache to listen on port ${PORT}..."

# Update Apache port dynamically for Render
sed -i "s/Listen [0-9]*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Package discovery
echo "Discovering packages..."
php artisan package:discover --ansi || true

# Create storage symlink if not already present
if [ ! -L /var/www/html/public/storage ]; then
    php artisan storage:link || true
fi

# Run migrations and seeders safely
echo "Checking database migrations..."
php artisan migrate --force --seed || php artisan migrate --force || true

# Optimization caches
echo "Optimizing Laravel cache..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Starting Apache on port ${PORT}..."
exec apache2-foreground
