FROM php:8.3-cli

# This Dockerfile sets up a PHP environment for a Laravel application
# It installs necessary applications, PHP extensions, Composer, and sets up the application directory
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    libxml2-dev \
    libonig-dev \
    libpq-dev \
    build-essential \
    pkg-config \
    tzdata \
    cron \
    supervisor \
    caddy \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        zip \
        opcache \
        intl \
        bcmath \
        mbstring \
        sockets \
        xml \
        soap \
        pcntl \
        exif \
        ctype \
        fileinfo


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Change default php memory limit
RUN echo "memory_limit=1024M" > /usr/local/etc/php/conf.d/memory-limit.ini
# Install Composer dependencies
# This will install the dependencies defined in your composer.json file
# The --optimize-autoloader flag is used to optimize the autoloader for production
# The --no-dev flag is used to skip installing development dependencies
# Adjust the path to your Laravel project as necessary
RUN composer install --optimize-autoloader --no-dev
RUN php artisan migrate --force --no-interaction
RUN php artisan octane:install --server=frankenphp --force --no-interaction

# Setup the Caddyfile for Octane with FrankenPHP
# The Caddyfile is used by Caddy to serve the Laravel application
# This file is used by Caddy to serve the Laravel application
# The Caddyfile should be located in the config/octane directory of your Laravel project
RUN caddy fmt --overwrite config/octane/Caddyfile

# Create necessary directories and set permissions for Caddy
# Caddy will use these directories to store data and configuration
# The directories are created under /var/www/html/storage/caddy
# The ownership is set to www-data to allow Caddy to write to these directories
RUN mkdir -p /var/www/html/storage/caddy/data \
             /var/www/html/storage/caddy/config \
    && chown -R www-data:www-data /var/www/html/storage/caddy

ENV XDG_DATA_HOME=/var/www/html/storage/caddy/data
ENV XDG_CONFIG_HOME=/var/www/html/storage/caddy/config

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Create the storage and bootstrap/cache directories
# These directories are necessary for Laravel to function correctly
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 770 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy the cron file and set permissions
# This file should contain the cron job to run the Laravel scheduler
# The cron job is set to run every minute
# Adjust the path to your Laravel project as necessary
COPY docker/laravel-cron /etc/cron.d/laravel-cron
RUN chmod 0644 /etc/cron.d/laravel-cron

# Create the log file to be able to run cron in the foreground
RUN touch /var/log/cron.log \
 && chown www-data:www-data /var/log/cron.log

# Copy the supervisor configuration file
# This file should contain the configuration for running the Laravel scheduler and cron
# Adjust the path to your supervisor configuration as necessary
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN mkdir -p /var/log/supervisor && chown -R www-data:www-data /var/log/supervisor

# Ensure the www-data user has ownership of the web root
# This is necessary for the web server to serve files correctly
RUN chown -R www-data:www-data /var/www/html

# Expose the port that the application will run on
# This is the port that will be mapped to the host machine
# Adjust the port as necessary for your application
EXPOSE 8000

# Start the cron service and the supervisor service
# The cron service will run the Laravel scheduler every minute
# The supervisor service will manage the processes defined in the supervisor configuration file
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
