# Dockerfile
LABEL maintainer="mrsiddiki@gmail.com"
FROM php:7.0-apache

RUN apt-get update && apt-get install -y \
		libmcrypt-dev \
		&& docker-php-ext-install -j$(nproc) iconv mcrypt


RUN docker-php-ext-install pdo_mysql

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite

#ADD . /var/www

#ADD ./public /var/www/html
#WORKDIR /var/www/html/

#RUN chmod 777 -R /var/www/html/app/storage
