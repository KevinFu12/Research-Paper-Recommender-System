# 1. Use the official PHP 8.2 FPM image as the base
FROM php:8.2-fpm

# 2. Install system dependencies for PostgreSQL and Nginx
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    nginx

# 3. Install PHP extensions for PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# 4. Install Composer to manage Laravel dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set the working directory
WORKDIR /var/www/html

# 6. Copy the application code into the container
COPY . .

# 7. Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# 8. Set correct permissions for Laravel's storage and cache folders
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Copy the Nginx configuration into the container
COPY nginx.conf /etc/nginx/sites-available/default

# 10. Expose the port Cloud Run uses (default is 8080)
EXPOSE 8080

# 11. Start Nginx and PHP-FPM together
CMD service nginx start && php-fpm
