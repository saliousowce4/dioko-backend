# Use a standard PHP image with Apache web server
FROM php:8.2-apache

# Install system dependencies required by Laravel and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql zip

# Install Composer (PHP package manager)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure Apache to serve the Laravel public directory
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the composer files
COPY composer.json composer.lock ./

# Install Laravel dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Copy the rest of the application code
COPY . .

# Fix permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 (standard for web traffic)
EXPOSE 80
