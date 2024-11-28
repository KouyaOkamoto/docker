FROM php:8.1-apache

# Install PHP extensions and required packages
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install \
    mysqli \
    pdo_mysql \
    intl \
    zip

# Enable Apache modules
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY src/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html