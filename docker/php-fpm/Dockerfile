FROM php:7.3-fpm-alpine

ENV PHPREDIS_VERSION 5.0.2

RUN apk update && mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/$PHPREDIS_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install pdo_mysql redis \
    && apk del --no-network .fetch-deps \
    && apk del --no-network .build-deps \
    && docker-php-source delete \
    && rm -rf /usr/src/php/ext/redis

CMD ["php-fpm"]

EXPOSE 9000