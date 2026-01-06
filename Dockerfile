FROM richarvey/nginx-php-fpm:latest

# Copy your code into the container
COPY . /var/www/html

# Tell the container where the public folder is
ENV WEBROOT /var/www/html/public
ENV APP_ENV production

# Fix permissions so Laravel can write logs and cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache