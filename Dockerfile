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
    && docker-php-ext-install pdo pdo_mysql gd \
    && npm install -g pnpm

# Step 4: Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Step 5: Copy application files
COPY . .

# Step 6: Install backend dependencies
RUN composer install --no-dev --optimize-autoloader

# Step 7: Install frontend dependencies and build assets
RUN cd /var/www/html && pnpm install && pnpm run build

# Step 8: Set appropriate permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Step 9: Command to start both Laravel backend and Vite frontend
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=8000 & pnpm run dev

# Step 10: Expose necessary ports
EXPOSE 8000 5173
