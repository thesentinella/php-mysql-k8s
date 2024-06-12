FROM php:apache

RUN docker-php-ext-install mysqli

# Copy the PHP application code to the Apache document root
COPY index.php /var/www/html/

# Expose port 80
EXPOSE 80
