FROM php:8.2-apache

# Install PostgreSQL dependencies, git, unzip and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Enable Apache modules
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer.json first for better layer caching
COPY composer.json .

# Install composer dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Copy all project files
COPY . .

# Set DocumentRoot to /var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Create logs and cache directories if they don't exist
RUN mkdir -p /var/www/html/logs /var/www/html/cache

# Set permissions for logs and cache directories
RUN chown -R www-data:www-data /var/www/html/logs /var/www/html/cache \
    && chmod -R 775 /var/www/html/logs /var/www/html/cache

# Expose port 80
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
