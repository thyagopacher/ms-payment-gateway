FROM php:8.4-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS\
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    curl-dev \
    curl \
    oniguruma-dev \
    librdkafka-dev \
    cyrus-sasl-dev \
    openssl-dev \
    bash \
    nano

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

# install newrelic
RUN curl -Ls https://download.newrelic.com/php_agent/release/ | \
    grep -Eo 'newrelic-php5-[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+-linux-musl\.tar\.gz' | \
    sort -V | \
    tail -n 1 | \
    xargs -I {} curl -L https://download.newrelic.com/php_agent/release/{} | \
    tar -C /tmp -xz

RUN NR_INSTALL_USE_CP_NOT_LN=1 NR_INSTALL_SILENT=1 \
    /tmp/newrelic-php5-*/newrelic-install install

RUN echo "extension=newrelic.so" > /usr/local/etc/php/conf.d/newrelic.ini \
 && echo "newrelic.enabled = true" >> /usr/local/etc/php/conf.d/newrelic.ini \
 && echo "newrelic.license = \${NEW_RELIC_LICENSE_KEY}" >> /usr/local/etc/php/conf.d/newrelic.ini \
 && echo "newrelic.appname = \${NEW_RELIC_APP_NAME}" >> /usr/local/etc/php/conf.d/newrelic.ini

RUN rm -rf /tmp/newrelic-php5-*

WORKDIR /var/www/html

EXPOSE 9000
