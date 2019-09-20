FROM php:7.3-fpm-alpine
COPY ./composer.phar /usr/bin/composer

ENV PHPREDIS_VERSION 5.0.2

RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/$PHPREDIS_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && apk add --update --no-cache libintl icu-dev libxml2-dev libzip-dev freetype-dev libjpeg-turbo-dev libmcrypt-dev libpng-dev \
    && docker-php-ext-install intl zip soap mysqli pdo pdo_mysql redis gd \
    && rm -rf /usr/src/php/ext/redis