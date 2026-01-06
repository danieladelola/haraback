FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    oniguruma-dev \
    libzip-dev

# Install PHP extensions (including bcmath for your BTC library)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Setup working directory
WORKDIR /var/www/html
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Fix permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Setup Nginx config (Coolify handles the SSL, we just need basic port 80)
RUN echo 'server { \
    listen 80; \
    index index.php index.html; \
    root /var/www/html/public; \
    location ~ \.php$ { \
        try_files $uri =404; \
        fastcgi_split_path_info ^(.+)\.php(/.*)$; \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        include fastcgi_params; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
        fastcgi_param PATH_INFO $fastcgi_path_info; \
    } \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
        gzip_static on; \
    } \
}' > /etc/nginx/http.d/default.conf

# Start Nginx and PHP-FPM
EXPOSE 80
CMD php-fpm -D && nginx -g 'daemon off;'