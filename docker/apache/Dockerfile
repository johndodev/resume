FROM php:8.1.5-apache

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

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install intl zip pdo pdo_mysql opcache

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tld && \
    mv composer.phar /usr/local/bin/composer

COPY docker/apache/sites-enabled/vhost.conf /etc/apache2/sites-enabled/000-default.conf
COPY . .

# Some secret from ENV
ARG DATABASE_URL=${DATABASE_URL}
ENV DATABASE_URL=${DATABASE_URL}
RUN echo "DATABASE_URL=$DATABASE_URL" >> .env.local

RUN APP_ENV=prod APP_DEBUG=0 composer install --no-dev --optimize-autoloader \
    && composer dump-env prod

RUN chmod 777 -R var

RUN a2enmod rewrite

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

ENTRYPOINT ["sh", "./docker/apache/entrypoint.sh"]
