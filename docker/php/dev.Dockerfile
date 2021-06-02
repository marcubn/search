FROM php:alpine

# Copy composer.lock and composer.json
COPY composer.json /var/www/

RUN apk add --no-cache $PHPIZE_DEPS && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    docker-php-ext-install pdo_mysql

VOLUME /app

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

