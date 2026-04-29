# docker/php/Dockerfile
FROM php:8.3-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS icu-dev libzip-dev postgresql-dev oniguruma-dev \
  && docker-php-ext-install pdo_pgsql mbstring intl zip opcache \
  && apk del $PHPIZE_DEPS

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
