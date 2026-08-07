#!/bin/bash
echo "🔧 Fixing Laravel storage permissions..."
mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
# Run the migrations
echo "Running migrations..."
php artisan key:generate
to handle PHP-FPM and Nginx
echo "Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
