# Fixed the image tag here
FROM richarvey/nginx-php-fpm:php83

# Copy your code
COPY . /var/www/html

# Install the bcmath extension and other dependencies
# Added --ignore-platform-reqs to bypass version check errors
RUN apk add --no-cache php83-bcmath && \
    composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Set the web root
ENV WEBROOT /var/www/html/public
ENV APP_ENV production
ENV RUN_SCRIPTS 1

# Permissions
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html