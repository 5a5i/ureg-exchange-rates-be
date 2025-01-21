# Step 1: Use an official PHP runtime as a parent image
FROM php:8.2-fpm

# Step 2: Set working directory
WORKDIR /var/www/html

# Step 3: Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    nodejs \
    npm \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Step 4: Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Step 5: Copy application files
COPY . .

# Step 6: Install backend dependencies
RUN composer install --no-dev --optimize-autoloader

# Step 7: Install frontend dependencies and build assets
RUN npm install && npm run production

# Step 8: Set appropriate permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Step 9: Run migrations and seed the database
CMD php artisan migrate:refresh --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=8000

# Step 10: Expose port 8000
EXPOSE 8000
