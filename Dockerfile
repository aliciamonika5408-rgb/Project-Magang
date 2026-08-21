FROM php:8.2-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy project files to Apache root
COPY . /var/www/html/

# Set ownership and permissions for SQLite database and storage
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/database /var/www/html/public/storage

EXPOSE 80
