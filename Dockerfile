FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libpq-dev libcurl4-openssl-dev postgresql-client \
    && docker-php-ext-install pdo_pgsql curl \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

COPY . .

EXPOSE 8000

CMD ["sh", "-c", "psql \"${DATABASE_URL}\" -f database/schema.sql 2>/dev/null; php -S 0.0.0.0:${PORT:-8000} -t public public/index.php"]
