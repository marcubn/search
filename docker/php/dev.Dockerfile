FROM php:alpine

RUN pecl install xdebug && docker-php-ext-enable xdebug && \
    docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --ignore-platform-reqs

VOLUME /app

RUN ["bin/composer.phar", "install", "--no-dev", "--no-interaction", "--optimize-autoloader", "--no-suggest"]
