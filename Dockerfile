FROM php:8.4-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS\
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    curl-dev \
    oniguruma-dev \
    librdkafka-dev \
    cyrus-sasl-dev \
    openssl-dev \
    bash

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

RUN pecl install redis \
    && pecl install rdkafka \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable rdkafka

RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    intl \
    gd \
    pcntl \
    opcache

WORKDIR /var/www/html

EXPOSE 9000
