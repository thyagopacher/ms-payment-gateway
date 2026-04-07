FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    curl-dev \
    oniguruma-dev

RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    intl \
    gd \
    opcache

WORKDIR /var/www/html

EXPOSE 9000
