FROM php:8.1-fpm-alpine

WORKDIR /var/www/shop

RUN docker-php-ext-install pdo pdo_mysql

