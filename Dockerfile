FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libzip-dev libpng-dev libjpeg62-turbo-dev \
    libfreetype6-dev libonig-dev libxml2-dev \
    nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite mbstring zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

RUN cp .env.example .env || true
RUN touch database/database.sqlite

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=$PORT