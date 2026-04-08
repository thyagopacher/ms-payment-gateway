FROM php:8.4-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS\
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    curl-dev \
    oniguruma-dev

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    intl \
    gd \
    opcache

WORKDIR /var/www/html

EXPOSE 9000
