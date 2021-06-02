FROM php:alpine
RUN docker-php-ext-install pdo
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo
VOLUME /app
RUN composer install --ignore-platform-reqs

EXPOSE 8000
