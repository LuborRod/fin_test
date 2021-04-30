FROM php:7.4-fpm

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY ./conf.d /usr/local/etc/php/conf.d

WORKDIR /app