FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git unzip zip curl sqlite3 libsqlite3-dev nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

RUN cp .env.example .env
RUN touch database/database.sqlite

RUN php artisan key:generate --force
RUN php artisan migrate --force || true
RUN php artisan storage:link || true
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=$PORT