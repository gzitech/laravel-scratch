FROM php:7.3-fpm-alpine
COPY ./composer.phar /usr/bin/composer

ENV PHPREDIS_VERSION 5.0.2

RUN apk update && mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/$PHPREDIS_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install pdo_mysql redis \
    && rm -rf /usr/src/php/ext/redis

CMD ["php-fpm"]

EXPOSE 9000