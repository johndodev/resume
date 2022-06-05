FROM php:8.1.5-apache

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN apt-get update \
    && apt-get install -y \
    zip \
    git \
    locales \
    # intl
    libicu-dev \
    # pour php ext zip
    libzip-dev

RUN echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && locale-gen;

RUN docker-php-ext-install intl zip pdo pdo_mysql opcache

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tld && \
    mv composer.phar /usr/local/bin/composer

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# vendor directory is ignored on docker-compose to increase performance on windows..
# don't forget to rebuild image (or copy vendor folder) when updating dependencies
# COPY ./vendor /var/www/html/vendor

RUN a2enmod rewrite
