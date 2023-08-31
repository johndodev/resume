FROM php:8.2.6-apache

RUN apt-get update \
    && apt-get install -y \
    zip \
    git \
    locales \
    supervisor \
    # intl
    libicu-dev \
    # pour php ext zip
    libzip-dev

RUN echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && locale-gen;

COPY docker/php/php.ini "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install intl zip pdo pdo_mysql opcache

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tld && \
    mv composer.phar /usr/local/bin/composer

COPY docker/apache/sites-enabled/vhost.conf /etc/apache2/sites-enabled/000-default.conf
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY . .

# Some secret from ENV
ARG DATABASE_URL=${DATABASE_URL}
ENV DATABASE_URL=${DATABASE_URL}
RUN echo "DATABASE_URL=$DATABASE_URL" >> .env.local

# dependencies
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN APP_ENV=prod APP_DEBUG=0 composer install --no-dev --no-interaction --no-autoloader --no-scripts
COPY . .
RUN APP_ENV=prod APP_DEBUG=0 && APP_ENV=prod APP_DEBUG=0 composer dump-autoload --optimize && APP_ENV=prod APP_DEBUG=0 composer run-script post-install-cmd && composer dump-env prod

RUN chmod 777 -R var

RUN a2enmod rewrite expires

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

ENTRYPOINT ["bash", "docker/apache/docker-entry.sh"]
