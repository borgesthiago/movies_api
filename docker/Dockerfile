FROM php:7.4-fpm

RUN apt-get update

RUN apt-get install -y git \
libzip-dev \
zip \
unzip

RUN apt-get install -y zlib1g-dev git default-mysql-client\
&& docker-php-ext-install pdo_mysql \
&& docker-php-ext-configure zip \
&& docker-php-ext-install zip \
&& docker-php-ext-install mysqli

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
&& chmod +sx /usr/local/bin/composer

EXPOSE 9000