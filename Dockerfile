FROM php:8.2-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy project files to Apache root
COPY . /var/www/html/

# Set permissions for SQLite database and storage
RUN chmod -R 777 /var/www/html/database /var/www/html/public/storage

EXPOSE 80
