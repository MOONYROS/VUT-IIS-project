# Dockerfile
FROM php:8.2-apache

# Instalace rozšíření pdo_mysql
RUN docker-php-ext-install pdo_mysql

COPY php.ini /usr/local/etc/php/conf.d