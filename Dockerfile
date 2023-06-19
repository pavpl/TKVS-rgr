FROM php:7.4.29-fpm

RUN docker-php-ext-install pdo mysqli pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer