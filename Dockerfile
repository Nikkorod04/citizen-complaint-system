# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite (needed for Laravel routes)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files into container
COPY . .

# Install Composer (from the official Composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set Laravel storage & cache permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 🧩 Important: Point Apache DocumentRoot to Laravel's public folder
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Expose port 80 (Apache default)
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
