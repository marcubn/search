FROM php:alpine

RUN apk add --no-cache $PHPIZE_DEPS && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    docker-php-ext-install pdo_mysql

VOLUME /app

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
