FROM php:7.4-fpm-alpine

RUN apk add --no-cache \
      libzip-dev \
      zip \
    && docker-php-ext-install zip

COPY ./files /var/www/app/files
COPY ./PHP /var/www/app/php
COPY ./go/build /var/www/app/go

WORKDIR /var/www/app