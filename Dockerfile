# Use the official PHP 8.2 FPM image
FROM php:8.2-fpm

# Update and install essential packages
RUN apt-get update && apt-get install -y --no-install-recommends \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg \
    && rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*
RUN curl -fsSL https://deb.debian.org/debian-archive-keyring.gpg | gpg --dearmor -o /usr/share/keyrings/debian-archive-keyring.gpg || echo "Failed to fetch keyring" && \
    apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    supervisor \
    && rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*

# Install Node.js 18 and npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y --no-install-recommends nodejs && \
    rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer by copying it from the Composer Docker image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www

# Copy the application code to the container asdasd
COPY . .

# Create necessary directories and set permissions for Laravel
RUN mkdir -p storage/framework/views \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage \
    && chown -R www-data:www-data bootstrap/cache \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache

# Install Laravel dependencies using Composer
RUN composer install --no-dev --optimize-autoloader --no-security-blocking

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www

# Copy Nginx configuration
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./nginx/default.conf /etc/nginx/sites-enabled/default
COPY ./nginx/default.conf /etc/nginx/sites-available/default

COPY custom-php.ini /usr/local/etc/php/conf.d/

RUN sed -i 's/listen = \/run\/php\/php8.2-fpm.sock/listen = 9000/' /usr/local/etc/php-fpm.d/www.conf

# Install Node.js dependencies and run the build script
RUN npm install

# Expose HTTP port
EXPOSE 80



# Copy the Supervisor configuration
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Add custom PHP settings to allow large file uploads
RUN echo "upload_max_filesize = 2G" >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo "post_max_size = 2G" >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo "memory_limit = 2G" >> /usr/local/etc/php/conf.d/uploads.ini

# Configure PHP-FPM pool settings
RUN { \
    echo "pm = dynamic"; \
    echo "pm.max_children = 200"; \
    echo "pm.start_servers = 50"; \
    echo "pm.min_spare_servers = 30"; \
    echo "pm.max_spare_servers = 60"; \
    echo "pm.max_requests = 2000"; \
} >> /usr/local/etc/php-fpm.d/zz-docker.conf
# Ensure Laravel required directories exist and have correct permissions
RUN mkdir -p storage/framework/{cache,sessions,views} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy the entrypoint script and make it executable
COPY ./docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set ENTRYPOINT to your script
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
