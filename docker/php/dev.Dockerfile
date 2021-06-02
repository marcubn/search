FROM php:alpine

RUN apk add --no-cache $PHPIZE_DEPS && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    docker-php-ext-install pdo_mysql

VOLUME /app

RUN ["bin/composer.phar", "install", "--no-dev", "--no-interaction", "--optimize-autoloader", "--no-suggest"]
